<?php
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorders_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("purchaseorder_form", array("legend"=>Mage::helper("purchaseorder")->__("Item information")));

				
						$fieldset->addField("vendor_id", "select", array(
						"label" => Mage::helper("purchaseorder")->__("Vendor Name"),
						"class" => "required-entry",
						"required" => true,
						"name" => "vendor_id",
						'options'=> Mage::getModel('purchaseorder/purchaseordervendor')->getVendors()
						));
					
						$fieldset->addField("product_code", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Product Code"),
						"class" => "required-entry",
						"required" => true,
						"name" => "product_code",
						'readonly' => true,
						));

						$fieldset->addField("increment_id", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Order ID"),
						"class" => "required-entry",
						"required" => true,
						"name" => "increment_id",
						'readonly' => true,
						'value' => 'test',
						));

						$fieldset->addField("product_name", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Product Name"),
						"class" => "required-entry",
						"required" => true,
						"name" => "product_name",
						'readonly' => true,
						));
					
						$fieldset->addField("qty", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Qty"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "qty",
						));
					
						$fieldset->addField("dimension", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Dimension"),
						"name" => "dimension",
						));
					
						$fieldset->addField("colour", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Colour"),
						"name" => "colour",
						));
					
						$fieldset->addField("note", "textarea", array(
						"label" => Mage::helper("purchaseorder")->__("Note"),
						"name" => "note",
						));

						$fieldset->addField("orderedod", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Order EDOD"),
						"name" => "orderedod",
						));
					
						$fieldset->addField("supplieredod", "text", array(
						"label" => Mage::helper("purchaseorder")->__("Supplier EDOD"),
						"name" => "supplieredod",
						));
					
						$fieldset->addField("status", "select", array(
						"label" => Mage::helper("purchaseorder")->__("Status"),
						"name" => "status",
						'options'=> Mage::getModel('purchaseorder/purchaseorderstatus')->getStatus()
						));
					

				if (Mage::getSingleton("adminhtml/session")->getPurchaseordersData())
				{
					$orderid = Mage::getSingleton("adminhtml/session")->getPurchaseordersData('order_id');
				 	$order = Mage::getModel('sales/order')->load($orderid);
    				$Incrementid = $order->getIncrementId();
					Mage::getSingleton("adminhtml/session")->setPurchaseordersData('increment_id', $Incrementid);
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPurchaseordersData());
					Mage::getSingleton("adminhtml/session")->setPurchaseordersData(null);
				} 
				elseif(Mage::registry("purchaseorders_data")) {
					$orderid = Mage::registry("purchaseorders_data")->getData('order_id');
				 	$order = Mage::getModel('sales/order')->load($orderid);
    				$Incrementid = $order->getIncrementId();
					Mage::registry("purchaseorders_data")->setData('increment_id', $Incrementid);
				    $form->setValues(Mage::registry("purchaseorders_data")->getData());
				}
				return parent::_prepareForm();
		}
}
