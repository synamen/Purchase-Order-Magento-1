<?php


class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorderstatus extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_purchaseorderstatus";
	$this->_blockGroup = "purchaseorder";
	$this->_headerText = Mage::helper("purchaseorder")->__("Purchaseorderstatus Manager");
	$this->_addButtonLabel = Mage::helper("purchaseorder")->__("Add New Item");
	parent::__construct();
	
	}

}