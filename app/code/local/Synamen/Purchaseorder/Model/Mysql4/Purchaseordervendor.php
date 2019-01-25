<?php
class Synamen_Purchaseorder_Model_Mysql4_Purchaseordervendor extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("purchaseorder/purchaseordervendor", "id_synamen_purchase_order_vendor");
    }
}