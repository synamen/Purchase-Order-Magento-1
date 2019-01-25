<?php
	
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorders_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id_synamen_purchase_orders";
				$this->_blockGroup = "purchaseorder";
				$this->_controller = "adminhtml_purchaseorders";
				$this->_updateButton("save", "label", Mage::helper("purchaseorder")->__("Save Item"));
				$this->_removeButton('delete');

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("purchaseorder")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);

				$this->_addButton('download', array(
					'label'   => Mage::helper('purchaseorder')->__('Download'),
					'onclick' => "setLocation('{$this->getUrl('*/*/download/id/'.$this->getRequest()->getParam('id'))}')",
					'class'   => 'save'
				));

				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("purchaseorders_data") && Mage::registry("purchaseorders_data")->getId() ){

				    return Mage::helper("purchaseorder")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("purchaseorders_data")->getId()));

				} 
				else{

				     return Mage::helper("purchaseorder")->__("Add Item");

				}
		}
}