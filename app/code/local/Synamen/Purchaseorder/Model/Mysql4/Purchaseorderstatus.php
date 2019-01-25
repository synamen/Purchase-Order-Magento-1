<?php
class Synamen_Purchaseorder_Model_Mysql4_Purchaseorderstatus extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("purchaseorder/purchaseorderstatus", "id_synamen_purchase_order_statuses");
    }
}