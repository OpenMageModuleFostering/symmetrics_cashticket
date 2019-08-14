<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Info extends Mage_Payment_Block_Info
{
    /**
     * Result of the API call
     *
     * @var object
     */
    protected $_response;

    /**
     * API object
     *
     * @var object
     */
    protected $_api;
    
    /**
     * Set template for payment info 
     * on the right side of the 
     * checkout page
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('cashticket/info.phtml'); 
    }
    
    /**
     * Get the API object
     *
     * @return object
     */
    public function getApi($transactionId)
    {
        if (is_null($this->_api)) {
            $cashticketModel = Mage::getModel('cashticket/cashticket');
            $this->_api = $cashticketModel->getApi($transactionId);
            $this->_api->setOrder($this->getInfo()->getOrder());
        }
        return $this->_api;
    }

    /**
     * Get disposition state from Cash-Ticket
     * and set the response for later use
     *
     * @return object
     */
    public function callGetSerialNumbers()
    {
        if (is_null($this->_response)) {
            $this->_response = $this->_api->call('GetSerialNumbers', array());
            
            if ($this->_response->errCode != '0') {
                Mage::throwException(Mage::helper('cashticket')->__('Error getting Cash-Ticket status.'));
                return $this;
            }
        }
        return $this->_response;
    }
    
    /**
     * Map status codes to strings
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        if (is_null($this->_response)) {
            return $this;
        }
        
        switch ($this->_response->TransactionState) {
            case 'R':
               $status = $this->helper('cashticket')->__('Created (R)');
            break;
            case 'S':
               $status = $this->helper('cashticket')->__('Disposed (S)');
            break;
            case 'E':
               $status = $this->helper('cashticket')->__('Debited (E)');
            break;
            case 'O':
               $status = $this->helper('cashticket')->__('Consumed (O)');
            break;
            case 'L':
               $status = $this->helper('cashticket')->__('Canceled (L)');
            break;
            case 'I':
               $status = $this->helper('cashticket')->__('Invalid (I)');
            break;
            case 'X':
               $status = $this->helper('cashticket')->__('Expired (X)');
            break;
        	default:
        		$status = $this->helper('cashticket')->__(sprintf(Mage::helper('cashticket')->__('Unknown status (%s)'), $response->TransactionState));
        	break;
        }

        return $status;
    }

    /**
     * Get status codes allowed to 
     * continue transactions and debiting 
     *
     * @return array
     */
    public function getAllowedStats()
    {
        return array('R', 'S', 'E');
    }
}
