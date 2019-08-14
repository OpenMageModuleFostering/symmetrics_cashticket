<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Adminhtml_Config extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Prepare the page with 
     * the grid on it
     *
     * @return object
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_config';
        $this->_blockGroup = 'cashticket';
        $this->_headerText = Mage::helper('cashticket')->__('Cash-Ticket Configuration');
        $this->_addButtonLabel = Mage::helper('cashticket')->__('Add Item');
        parent::__construct();
    }
}
