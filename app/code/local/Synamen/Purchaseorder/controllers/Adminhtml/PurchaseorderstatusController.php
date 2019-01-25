<?php

class Synamen_Purchaseorder_Adminhtml_PurchaseorderstatusController extends Mage_Adminhtml_Controller_Action
{
	    protected function _isAllowed()
	    {
	       //return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseorderstatus');
	    	return true;
	    }
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("purchaseorder/purchaseorderstatus")->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorderstatus  Manager"),Mage::helper("adminhtml")->__("Purchaseorderstatus Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Purchaseorder"));
			    $this->_title($this->__("Manager Purchaseorderstatus"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Purchaseorder"));
				$this->_title($this->__("Purchaseorderstatus"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("purchaseorder/purchaseorderstatus")->load($id);
				if ($model->getId()) {
					Mage::register("purchaseorderstatus_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("purchaseorder/purchaseorderstatus");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorderstatus Manager"), Mage::helper("adminhtml")->__("Purchaseorderstatus Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorderstatus Description"), Mage::helper("adminhtml")->__("Purchaseorderstatus Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorderstatus_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorderstatus_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("purchaseorder")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Purchaseorder"));
		$this->_title($this->__("Purchaseorderstatus"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("purchaseorder/purchaseorderstatus")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("purchaseorderstatus_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("purchaseorder/purchaseorderstatus");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorderstatus Manager"), Mage::helper("adminhtml")->__("Purchaseorderstatus Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorderstatus Description"), Mage::helper("adminhtml")->__("Purchaseorderstatus Description"));


		$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorderstatus_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorderstatus_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("purchaseorder/purchaseorderstatus")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Purchaseorderstatus was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPurchaseorderstatusData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setPurchaseorderstatusData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$storeId = Mage::app()->getStore()->getStoreId();
						$configValue = Mage::getStoreConfig('purchaseorder/settings/default_status', $storeId);
						if($this->getRequest()->getParam("id") != $configValue){
							$model = Mage::getModel("purchaseorder/purchaseorderstatus");
							$model->setId($this->getRequest()->getParam("id"))->delete();
							Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
							$this->_redirect("*/*/");
						}
						else{
							Mage::getSingleton("adminhtml/session")->addError("Default status cannot be deleted.");
							$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
						}
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('id_synamen_purchase_order_statusess', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("purchaseorder/purchaseorderstatus");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'purchaseorderstatus.csv';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorderstatus_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'purchaseorderstatus.xml';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorderstatus_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
