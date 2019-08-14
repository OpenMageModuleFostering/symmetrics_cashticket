<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Model_Mysql4_Item extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('cashticket/item', 'item_id');
    }
}
