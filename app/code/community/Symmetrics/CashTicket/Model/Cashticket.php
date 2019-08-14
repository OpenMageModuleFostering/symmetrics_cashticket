<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_CashTicket extends Mage_Payment_Model_Method_Abstract
{
    /**
     * Internal payment code
     *
     * @var string
     */
    protected $_code = 'cashticket';

    /**
     * If gateway
     *
     * @var boolean
     */
    protected $_isGateway = true;
    
    /**
     * If use authorization
     *
     * @var boolean
     */
    protected $_canAuthorize = true;
    
    /**
     * If use capturing
     *
     * @var boolean
     */
    protected $_canCapture = true;
    
    /**
     * If capture partial amounts
     *
     * @var boolean
     */
    protected $_canCapturePartial = false;
    
    /**
     * If using refund 
     *
     * @var boolean
     */
    protected $_canRefund = false;
    
    /**
     * If can void
     *
     * @var boolean
     */
    protected $_canVoid = false;
    
    /**
     * If using for internal
     *
     * @var boolean
     */
    protected $_canUseInternal = true;
    
    /**
     * If using on checkout
     *
     * @var boolean
     */
    protected $_canUseCheckout = true;
    
    /**
     * If using on multishipping
     *
     * @var boolean
     */
    protected $_canUseForMultishipping = true;
    
    /**
     * If saving creditcards 
     *
     * @var boolean
     */
    protected $_canSaveCc = false;
    
    /**
     * If validating
     *
     * @var boolean
     */
    protected $_canValidate = true;
    
    /**
     * Define block for payment form
     *
     * @var string
     */
    protected $_formBlockType = 'cashticket/form';

    /**
     * Define block for payment info
     *
     * @var string
     */
    protected $_infoBlockType = 'cashticket/info';
    
    /**
     * Id of the transaction for 
     * current API call
     *
     * @var string
     */
    protected $_transactionId = '';

    public function _construct()
    {
        parent::_construct();
        $this->_init('cashticket/item');
    }
    
    /**
     * Get API object
     *
     * @return object
     */
    public function getApi($transactionId)
    {
        $api = Mage::getModel('cashticket/api');
        $api->setTransactionId($transactionId);
        $api->setOrder($this->getQuote());

        return $api;
    }
    
    /**
     * Get checkout from session
     *
     * @return object
     */
    public function getCheckout()
    {
        return Mage::getModel('checkout/session');
    }
    
    /**
     * Get session for Cash-Ticket
     *
     * @return object
     */
    public function getSession()
    {
        return Mage::getModel('cashticket/session');
    }
    
    /**
     * Get quote
     *
     * @return object
     */
    public function getQuote()
    {
        return $this->getCheckout()->getQuote();
    }

    /**
     * Check if payment method is available
     *
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        // if quote is not set - something went wrong
        if (is_null($quote)) {
           return false;
        }

        // if cart value > 1000 - cancel
        // cash-ticket does not support orders 
        // with value > 1000 at this time
        if (Mage::app()->getStore()->roundPrice($quote->getGrandTotal()) <= 1000) {
            return true;
        }

        return false;
    }

    /**
     * Create disposition on Cash-Ticket
     *
     * @return object
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        // generate random transaction number (number from 100 to 999 + orderid)
        $transactionId = rand(100, 999) . $payment->getOrder()->increment_id;
        $api = $this->getApi($transactionId);

        // override the amount to get the really order amount
        // needed for currency operations
        $amount = $api->formatPrice($this->getQuote()->getGrandTotal());
            
        $params = array(
            'amount' => $amount
        );

        // save transactionid in payment data
        $payment->setAdditionalData($transactionId);
        
        // get response from api
        $response = $api->call('CreateDisposition', $params);

        // if response could be parsed and no error happened
        if (is_object($response) && $response->errCode == '0')
        {
            return $this;
        }
        else {
            // TODO: Translate
            Mage::throwException(Mage::helper('cashticket')->__('Bei der Bezahlung ist ein Fehler aufgetreten. Vermutlich ist dies ein temporärer Fehler und die Bezahlung kann durch Neu-Laden der Seite abgeschlossen werden. Falls dieses Problem weiterhin besteht, kontaktieren Sie bitte unseren Support.'));
        }
        
        return $this;
    }

    /**
     * Get redirect URL
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('cashticket/processing/redirect');
    }
}
