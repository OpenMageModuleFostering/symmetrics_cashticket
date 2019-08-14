<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Adminhtml_Config_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Add buttons to the edit form
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'cashticket';
        $this->_controller = 'adminhtml_config';
        
        $this->_updateButton('save', 'label', Mage::helper('cashticket')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('cashticket')->__('Delete'));
        
        // add "save and continue" button
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        // js needed for "save and continue"
        $this->_formScripts[] = "
           function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Set page header
     *
     * @return string
     */
    public function getHeaderText()
    {
        // if editing an item - set "Edit" as a page header
        if (Mage::registry('cashticket_data') && Mage::registry('cashticket_data')->getId()) {
            return Mage::helper('cashticket')->__('Edit Item "%s"', $this->htmlEscape(Mage::registry('cashticket_data')->getCurrencyCode()));
        }
        else {
            // ohterwise set "Add"
            return Mage::helper('cashticket')->__('Add Item');
        }
    }
}
