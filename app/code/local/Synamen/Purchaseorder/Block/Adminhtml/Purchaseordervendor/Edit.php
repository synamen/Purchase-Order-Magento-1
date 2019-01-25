<?php
	
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseordervendor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id_synamen_purchase_order_vendor";
				$this->_blockGroup = "purchaseorder";
				$this->_controller = "adminhtml_purchaseordervendor";
				$this->_updateButton("save", "label", Mage::helper("purchaseorder")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("purchaseorder")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("purchaseorder")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("purchaseordervendor_data") && Mage::registry("purchaseordervendor_data")->getId() ){

				    return Mage::helper("purchaseorder")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("purchaseordervendor_data")->getId()));

				} 
				else{

				     return Mage::helper("purchaseorder")->__("Add Item");

				}
		}
}