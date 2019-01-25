<?php
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseordervendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("purchaseorder_form", array("legend"=>Mage::helper("purchaseorder")->__("Item information")));

				
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("company", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Company"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "company",
						));
					
						$fieldset->addField("mobilenumber", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Mobile Number"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "mobilenumber",
						));
					
						$fieldset->addField("city", "text", array(
						"label" => Mage::helper("purchaseorder")->__("City"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "city",
						));
					
						$fieldset->addField("state", "text", array(
						"label" => Mage::helper("purchaseorder")->__("State"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "state",
						));
					
						$fieldset->addField("country", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Country"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "country",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPurchaseordervendorData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPurchaseordervendorData());
					Mage::getSingleton("adminhtml/session")->setPurchaseordervendorData(null);
				} 
				elseif(Mage::registry("purchaseordervendor_data")) {
				    $form->setValues(Mage::registry("purchaseordervendor_data")->getData());
				}
				return parent::_prepareForm();
		}
}
