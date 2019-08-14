<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_Source_Locale
{
    /**
     * Get locales
     *
     * @return array
     */
    public function getOptionArray()
    {
        return array(
            'de_de' => Mage::helper('cashticket')->__('German Germany'),
            'de_at' => Mage::helper('cashticket')->__('German Austria'),
            'en_uk' => Mage::helper('cashticket')->__('British English'),
            'en_us' => Mage::helper('cashticket')->__('American English')
        );
    }
}
