<?php

class Synamen_Purchaseorder_Model_Purchaseordervendor extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("purchaseorder/purchaseordervendor");

    }
	
	public function getVendors() {

        $vendorsArray = array();
        foreach($this->getCollection() as $vendor){
            $vendorsArray[$vendor->getId_synamen_purchase_order_vendor()] = $vendor->getName();

        }
        return $vendorsArray;

    }
	
	public function getVendorSearch() {

        $vendorsArray = array();
        foreach($this->getCollection() as $vendor){
            $vendorsArray[$vendor->getName()] = $vendor->getName();

        }
        return $vendorsArray;

    }

}
	 