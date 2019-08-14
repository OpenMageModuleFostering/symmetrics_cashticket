<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Symmetrics
 * @package   Symmetrics_CashTicket
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Eugen Gitin <eg@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * Symmetrics_CashTicket_Block_Adminhtml_Config_Renderer
 *
 * @category  Symmetrics
 * @package   Symmetrics_CashTicket
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Eugen Gitin <eg@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
*/
class Symmetrics_CashTicket_Block_Adminhtml_Config_Renderer 
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Rendering of the grid column
     *
     * @param Varien_Object $row row
     *
     * @return string
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