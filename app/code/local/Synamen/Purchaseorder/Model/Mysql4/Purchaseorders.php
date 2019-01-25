<?php
class Synamen_Purchaseorder_Model_Mysql4_Purchaseorders extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("purchaseorder/purchaseorders", "id_synamen_purchase_orders");
    }
}