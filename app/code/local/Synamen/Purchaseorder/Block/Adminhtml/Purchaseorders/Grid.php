<?php

class Synamen_Purchaseorder_Block_Adminhtml_Purchaseorders_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("purchaseordersGrid");
				$this->setDefaultSort("id_synamen_purchase_orders");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("purchaseorder/purchaseorders")->getCollection();
				$collection->getSelect()->joinLeft(Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor'), Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor').'.id_synamen_purchase_order_vendor = main_table.vendor_id',array('name','name'));
				$collection->getSelect()->joinLeft(Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_statuses'), Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_statuses').'.id_synamen_purchase_order_statuses = main_table.status',array('title','title'));
				$collection->getSelect()->joinLeft(Mage::getSingleton('core/resource')->getTableName('sales_flat_order'), Mage::getSingleton('core/resource')->getTableName('sales_flat_order').'.entity_id = main_table.order_id',array('increment_id','increment_id'));
				
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
			$this->addColumn("id_synamen_purchase_orders", array(
			"header" => Mage::helper("purchaseorder")->__("ID"),
			"align" =>"right",
			"width" => "50px",
			"type" => "number",
			"index" => "id_synamen_purchase_orders",
			));

			$this->addColumn('date', array(
			'header'    => Mage::helper('purchaseorder')->__('Date'),
			'index'     => 'date',
			'type'      => 'datetime',
			));

			$this->addColumn("vendor_id", array(
			"header" => Mage::helper("purchaseorder")->__("Vendor"),
			"index" => "name",
			'type' => 'options',
			'options'=> Mage::getModel('purchaseorder/purchaseordervendor')->getVendorSearch()
			));

			$this->addColumn("increment_id", array(
			"header" => Mage::helper("purchaseorder")->__("Order ID"),
			"index" => "increment_id"
			));

			$this->addColumn("product_code", array(
			"header" => Mage::helper("purchaseorder")->__("Product Code"),
			"index" => "product_code",
			));
			$this->addColumn("product_name", array(
			"header" => Mage::helper("purchaseorder")->__("Product Name"),
			"index" => "product_name",
			));
			$this->addColumn("qty", array(
			"header" => Mage::helper("purchaseorder")->__("Qty"),
			"index" => "qty",
			));
			$this->addColumn("dimension", array(
			"header" => Mage::helper("purchaseorder")->__("Dimension"),
			"index" => "dimension",
			));
			$this->addColumn("orderedod", array(
			"header" => Mage::helper("purchaseorder")->__("Order EDOD"),
			"index" => "orderedod",
			'type'      => 'datetime',
			));
			$this->addColumn("supplieredod", array(
			"header" => Mage::helper("purchaseorder")->__("Supplier EDOD"),
			"index" => "supplieredod",
			'type'      => 'datetime',
			));
			
			
			
			// trying
			$this->addColumn("status", array(
			"header" => Mage::helper("purchaseorder")->__("Status"),
			"index" => "title",
			'type' => 'options',
			'options'=> Mage::getModel('purchaseorder/purchaseorderstatus')->getStatusSearch()
			));
			
			
			
			$this->addColumn('action', array(
			    'header'           => Mage::helper('purchaseorder')->__('Action'),
			    'align'            => 'center',
			    'renderer'         => 'purchaseorder/adminhtml_widget_grid_column_renderer_inline',
			    'index'            => 'action',
			    'type'      => 'concat',
			    'filter' => false,
			));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

			return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}

		protected function _orderFilter($collection, $column)
		{
		    $incrementId = $column->getFilter()->getValue();
		    if ($incrementId === null) { //here check if filter is not null
		        return $this;
		    }

		    /**
		     * Here you can add filter to collection
		     * or do other manipulations with collection.
		     * As example you can check filter incrementId and filter collection.
		     */
		    if ($incrementId != 0) { 
		        $order = Mage::getModel('sales/order')->load($incrementId, 'increment_id');
		    	$orderid = $order->getId();
		    	$collection->addFieldToFilter('order_id', array('eq' => $orderid));
		    }

		    return $this;
		}
		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id_synamen_purchase_orders');
			$this->getMassactionBlock()->setFormFieldName('id_synamen_purchase_orders');
			$this->getMassactionBlock()->setUseSelectAll(true);
			
				
			 $statuses = Mage::getSingleton('purchaseorder/purchaseorderstatus')->getStatus();
			 array_unshift($statuses, array('label'=>'', 'value'=>''));
			 $this->getMassactionBlock()->addItem('status', array(
				 'label'=> Mage::helper('purchaseorder')->__('Change status'),
				 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
				 'additional' => array(
						'visibility' => array(
							 'name' => 'status',
							 'type' => 'select',
							 'class' => 'required-entry',
							 'label' => Mage::helper('purchaseorder')->__('Status'),
							 'values' => $statuses
			 )
			 )
			 ));
			return $this;
		}
			

}