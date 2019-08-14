<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Adminhtml_Config_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Rendering of the grid column
     *
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $values = array();
        foreach (Mage::getModel('cashticket/item')->getSizeOptions() as $option) {
            foreach ($option as $key => $val) {
                if ($val['value'] == $row->getSize()) {
                    return $val['label'];
                    $values[$val['value']] = $val['label'];
                }
            }
        }
    }
}
