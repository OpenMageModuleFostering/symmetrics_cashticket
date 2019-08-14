<?php
/**
 * @category Symmetrics
 * @package Symmetrics_CashTicket
 * @author symmetrics gmbh <info@symmetrics.de>, Eugen Gitin <eg@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Symmetrics_CashTicket_Block_Error extends Mage_Core_Block_Abstract
{
    /**
     * This block is shown when the customer
     * cancels the payment process from
     * CashTicket page
     *
     * @return string
     */
    protected function _toHtml()
    {
        $url = Mage::getUrl('checkout/onepage');
        
        $html = '';
        
        $html .= '<p>'.Mage::helper('cashticket')->__('Cash-Ticket payment was canceled. Redirecting to checkout...').'</p>';
        $html .= '<p><a href="'.$url.'">'.Mage::helper('cashticket')->__('Click here to return to checkout').'</a></p>';

        $html .= '<script language="javascript">';
        $html .= 'document.location.href="'.$url.'";';
        $html .= '</script>';

        return $html;
    }
}
