<?php
class Synamen_Purchaseorder_Block_Adminhtml_Orderid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $orderid = $row->getData($this->getColumn()->getIndex());
        $order = Mage::getModel('sales/order')->load($orderid);
    	$Incrementid = $order->getIncrementId();
        return $Incrementid;
    }
}