<?php

class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorderstatus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("purchaseorderstatusGrid");
				$this->setDefaultSort("id_synamen_purchase_order_statuses");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("purchaseorder/purchaseorderstatus")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id_synamen_purchase_order_statuses", array(
				"header" => Mage::helper("purchaseorder")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id_synamen_purchase_order_statuses",
				));
                
				$this->addColumn("title", array(
				"header" => Mage::helper("purchaseorder")->__("Title"),
				"index" => "title",
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
			$this->setMassactionIdField('id_synamen_purchase_order_statuses');
			$this->getMassactionBlock()->setFormFieldName('id_synamen_purchase_order_statusess');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_purchaseorderstatus', array(
					 'label'=> Mage::helper('purchaseorder')->__('Remove Purchaseorderstatus'),
					 'url'  => $this->getUrl('*/adminhtml_purchaseorderstatus/massRemove'),
					 'confirm' => Mage::helper('purchaseorder')->__('Are you sure?')
				));
			return $this;
		}
			

}