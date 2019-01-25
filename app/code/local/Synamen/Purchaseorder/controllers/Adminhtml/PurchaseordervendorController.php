<?php

class Synamen_Purchaseorder_Adminhtml_PurchaseordervendorController extends Mage_Adminhtml_Controller_Action
{		
		protected function _isAllowed()
	    {
	       //return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseordervendor');
	    	return true;
	    }
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("purchaseorder/purchaseordervendor")->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseordervendor  Manager"),Mage::helper("adminhtml")->__("Purchaseordervendor Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Purchaseorder"));
			    $this->_title($this->__("Manager Purchaseordervendor"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Purchaseorder"));
				$this->_title($this->__("Purchaseordervendor"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("purchaseorder/purchaseordervendor")->load($id);
				if ($model->getId()) {
					Mage::register("purchaseordervendor_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("purchaseorder/purchaseordervendor");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseordervendor Manager"), Mage::helper("adminhtml")->__("Purchaseordervendor Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseordervendor Description"), Mage::helper("adminhtml")->__("Purchaseordervendor Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseordervendor_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseordervendor_edit_tabs"));
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
		$this->_title($this->__("Purchaseordervendor"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("purchaseorder/purchaseordervendor")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("purchaseordervendor_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("purchaseorder/purchaseordervendor");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseordervendor Manager"), Mage::helper("adminhtml")->__("Purchaseordervendor Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseordervendor Description"), Mage::helper("adminhtml")->__("Purchaseordervendor Description"));


		$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseordervendor_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseordervendor_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("purchaseorder/purchaseordervendor")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Purchaseordervendor was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPurchaseordervendorData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setPurchaseordervendorData($this->getRequest()->getPost());
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
						$model = Mage::getModel("purchaseorder/purchaseordervendor");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
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
				$ids = $this->getRequest()->getPost('id_synamen_purchase_order_vendors', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("purchaseorder/purchaseordervendor");
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
			$fileName   = 'purchaseordervendor.csv';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseordervendor_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'purchaseordervendor.xml';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseordervendor_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
