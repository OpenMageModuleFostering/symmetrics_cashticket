<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Adminhtml_CashticketController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Default action called by pressing
     * the "send" button in order info
     * performed by AJAX
     *
     * @return object
     */
    public function defaultAction()
    {
        $postParams = $this->getRequest()->getParams();
        // get action variable from post
        $action = $postParams['cashticketAction'];
        // get order by id
        $order = $this->getOrder($postParams['orderId']);
        // get api and set the transaction id
        $api = $this->getApi($postParams['transactionId']);
        // get entered amount
        $amount = $api->formatPrice($postParams['amount']);

        // if entered amount is less then zero by modifying transaction
        if ($amount <= 0 && $action == 'modify') {
            // return error message
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cashticket')->__('Debit amount must be greater then zero.'));
            return $this;
        }
        
        // switch between two functions (debit and modify) selected from order info box
        if ($action == 'debit') {
            // get disposition state from Cash-Ticket
            $response = $api->call('GetDispositionState', array());
            // if allow to debit
            if (is_object($response) && $response->errCode == '0' && $response->Amount > 0 && $response->TransactionState == 'D') {
                    $params = array(
                        'amount' => $amount,
                        'close' => '0',
                    );
                    // call Cash-Ticket debit function with entered amount                     
                    $debitResponse = $api->call('Debit', $params);
                    if ($debitResponse->errCode == '0') {
                        // if everything was ok - save the new status and add info to order history
                        $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PROCESSING, sprintf(Mage::helper('cashticket')->__('Amount %s %s was successfully captured from customers Cash-Tickets.'), $amount, $api->getCurrency()));
                        $order->save();
    
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cashticket')->__(sprintf(Mage::helper('cashticket')->__('Amount of %s %s was successfully debited.'), $amount, $api->getCurrency())));
                        return $this;
                    }
                    else {
                        $errorMessage = preg_replace('/&/', '', $debitResponse->errMessage);
                        $errorMessage = preg_replace('/;/', '', $errorMessage);
                        Mage::getSingleton('adminhtml/session')->addError($errorMessage);
                        return $this;
                    }
            }
            else {
                // if can not process debit
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cashticket')->__('Error processing the Cash-Ticket request.'));
                return $this;
            }
        }
        elseif ($action == 'modify') {
            // call Cash-Ticket modify function and modify the transaction amount
            $response = $api->call('ModifyDisposition', array('amount' => $amount));

            if (is_object($response) && $response->errCode == '0') {
                // if everything was ok - save the new status and add info to order history 
                $order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PROCESSING, sprintf('Disposition modified. New value: %s %s', $amount, $api->getCurrency()));
                $order->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cashticket')->__(sprintf('Disposition was successfully modified (%s %s).', $amount, $api->getCurrency())));
                return $this;
            }
            else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cashticket')->__('Error processing the Cash-Ticket request.'));
                return $this;
            }
        }

        return $this;
    }

    /**
     * Get order object and load 
     * order by id
     *
     * @return object
     */    
    public function getOrder($orderId = null)
    {
        $order = Mage::getModel('sales/order');
        $order->load($orderId);
        
        return $order;
    }

    /**
     * Get API object and set 
     * the transaction
     *
     * @return object
     */
    public function getApi($transactionId = null)
    {
        $postParams = $this->getRequest()->getParams();
        $cashTicketModel = Mage::getModel('cashticket/cashticket');
        $api = $cashTicketModel->getApi($transactionId);
        $api->setTransactionId($transactionId);
        $api->setOrder($this->getOrder($postParams['orderId']));

        return $api;
    }
}
