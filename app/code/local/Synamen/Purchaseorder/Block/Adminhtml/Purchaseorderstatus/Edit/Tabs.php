<?php
class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorderstatus_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("purchaseorderstatus_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("purchaseorder")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("purchaseorder")->__("Item Information"),
				"title" => Mage::helper("purchaseorder")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorderstatus_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
