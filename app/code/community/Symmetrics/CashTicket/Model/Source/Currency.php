<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_Source_Currency
{
    /**
     * Get possible currencies
     *
     * @return array
     */
    public function getOptionArray()
    {
        return array(
            'CHF' => 'CHF',
            'DKK' => 'DKK',
            'SEK' => 'SEK',
            'SEK' => 'SEK',
            'PLN' => 'PLN',
            'GBP' => 'GBP',
            'EUR' => 'EUR',
            'USD' => 'USD',
            'CZK' => 'CZK'
        );
    }
}
