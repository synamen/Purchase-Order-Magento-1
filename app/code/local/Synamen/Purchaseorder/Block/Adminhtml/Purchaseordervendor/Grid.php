<?php

class Synamen_Purchaseorder_Block_Adminhtml_Purchaseordervendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("purchaseordervendorGrid");
				$this->setDefaultSort("id_synamen_purchase_order_vendor");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("purchaseorder/purchaseordervendor")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id_synamen_purchase_order_vendor", array(
				"header" => Mage::helper("purchaseorder")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id_synamen_purchase_order_vendor",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("purchaseorder")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("company", array(
				"header" => Mage::helper("purchaseorder")->__("Company"),
				"index" => "company",
				));
				$this->addColumn("mobilenumber", array(
				"header" => Mage::helper("purchaseorder")->__("Mobile Number"),
				"index" => "mobilenumber",
				));
				$this->addColumn("city", array(
				"header" => Mage::helper("purchaseorder")->__("City"),
				"index" => "city",
				));
				$this->addColumn("state", array(
				"header" => Mage::helper("purchaseorder")->__("State"),
				"index" => "state",
				));
				$this->addColumn("country", array(
				"header" => Mage::helper("purchaseorder")->__("Country"),
				"index" => "country",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id_synamen_purchase_order_vendor');
			$this->getMassactionBlock()->setFormFieldName('id_synamen_purchase_order_vendors');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_purchaseordervendor', array(
					 'label'=> Mage::helper('purchaseorder')->__('Remove Purchaseordervendor'),
					 'url'  => $this->getUrl('*/adminhtml_purchaseordervendor/massRemove'),
					 'confirm' => Mage::helper('purchaseorder')->__('Are you sure?')
				));
			return $this;
		}
			

}