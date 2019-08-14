<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_Item extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('cashticket/item');
    }

    /**
     * Get config item object
     * and load by currency
     *
     * @return string
     */
    public function getConfigItem($currency)
    {
        $ids = $this->getItemsCollection($currency)->getAllIds();
        return $this->load($ids[0])->toArray();
    }
    
    /**
     * Get all enabled config items
     * for current currency
     *
     * @return string
     */
    public function getItemsCollection($currency)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('currency_code', $currency)
            ->addFieldToFilter('enable', 1);

        return $collection;
    }
}
