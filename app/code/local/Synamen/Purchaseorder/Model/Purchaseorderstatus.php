<?php

class Synamen_Purchaseorder_Model_Purchaseorderstatus extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("purchaseorder/purchaseorderstatus");

    }
	
	public function getStatus() {

        $statusArray = array();
        foreach($this->getCollection() as $status){
            $statusArray[$status->getId_synamen_purchase_order_statuses()] = $status->getTitle();

        }
        return $statusArray;

    }
	
	public function getStatusSearch() {

        $statusArray = array();
        foreach($this->getCollection() as $status){
            $statusArray[$status->getTitle()] = $status->getTitle();

        }
        return $statusArray;

    }
	
	public function toOptionArray() {

        $statusArray = array();
        foreach($this->getCollection() as $status){
            $statusArray[$status->getId_synamen_purchase_order_statuses()] = $status->getTitle();

        }
        return $statusArray;

    }

}
	 