<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_Source_BusinessType
{
    /**
     * Get possible business types
     *
     * @return array
     */
    public function getOptionArray()
    {
        return array(
            'T' => Mage::helper('cashticket')->__('Tangible'),
            'I' => Mage::helper('cashticket')->__('Intangible')
        );
    }
}
