<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Adminhtml_Config_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('editForm');
    }

    /**
     * Preparing the form and adding 
     * fields to it
     *
     * @return object
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('cashticket_form', array(
            'legend'    => Mage::helper('cashticket')->__('Cash-Ticket Configuration'))
        );
        
        if ($this->getRequest()->getParam('id')) {
            $fieldset->addField('item_id', 'hidden', array(
                'name' => 'item_id',
            ));
        }
        
        $fieldset->addField('enable', 'select', array(
            'label'     => Mage::helper('cashticket')->__('Enable'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'enable',
            'options'   => array(
                0 => Mage::helper('cashticket')->__('No'),
                1 => Mage::helper('cashticket')->__('Yes'),
            )
        ));
        
        $fieldset->addField('currency_code', 'select', array(
            'label'     => Mage::helper('cashticket')->__('Currency'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'currency_code',
            'options'   => Mage::getModel('cashticket/source_currency')->getOptionArray()
        ));

        $fieldset->addField('merchant_id', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Merchant ID'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'merchant_id',
        ));
        
        $fieldset->addField('business_type', 'select', array(
            'label'     => Mage::helper('cashticket')->__('Business Type'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'business_type',
            'options'   => Mage::getModel('cashticket/source_businesstype')->getOptionArray()
        ));
        
        $fieldset->addField('reporting_criteria', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Reporting Criteria'),
            'required'  => false,
            'name'      => 'reporting_criteria',
        ));

        $fieldset->addField('locale', 'select', array(
            'label'     => Mage::helper('cashticket')->__('Language'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'locale',
            'options'   => Mage::getModel('cashticket/source_locale')->getOptionArray()
        ));

        $fieldset->addField('path_pem_test', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Path to PEM Certificate (Test)'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'path_pem_test',
        ));
        
        $fieldset->addField('path_pem_live', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Path to PEM Certificate (Live)'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'path_pem_live',
        ));
        
        $fieldset->addField('path_cert', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Path to the Server Certificate'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'path_cert',
        ));
        
        $fieldset->addField('sslcert_pass', 'text', array(
            'label'     => Mage::helper('cashticket')->__('Keyring Password'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'sslcert_pass',
        ));
        
        $fieldset->addField('sandbox', 'select', array(
            'label'     => Mage::helper('cashticket')->__('Sandbox'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'sandbox',
            'options'   => array(
                0 => Mage::helper('cashticket')->__('No'),
                1 => Mage::helper('cashticket')->__('Yes'),
            )
        ));
        
        // get form values from the session
        if (Mage::getSingleton('adminhtml/session')->getCashticketData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCashticketData());
            Mage::getSingleton('adminhtml/session')->setCashticketData(null);
        }
        elseif (Mage::registry('cashticket_data')) {
            $form->setValues(Mage::registry('cashticket_data')->getData());
        }
        
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
