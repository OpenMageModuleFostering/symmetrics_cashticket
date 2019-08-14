<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Form extends Mage_Payment_Block_Form
{
    /**
     * Set template for payment info 
     * below the radio selector 
     *
     * @return object
     */
    protected function _construct()
    {
        $this->setTemplate('cashticket/form.phtml');
        parent::_construct();
    }
}
