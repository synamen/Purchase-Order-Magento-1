<?php
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorderstatus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("purchaseorder_form", array("legend"=>Mage::helper("purchaseorder")->__("Item information")));

				
						$fieldset->addField("title", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Title"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "title",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPurchaseorderstatusData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPurchaseorderstatusData());
					Mage::getSingleton("adminhtml/session")->setPurchaseorderstatusData(null);
				} 
				elseif(Mage::registry("purchaseorderstatus_data")) {
				    $form->setValues(Mage::registry("purchaseorderstatus_data")->getData());
				}
				return parent::_prepareForm();
		}
}
