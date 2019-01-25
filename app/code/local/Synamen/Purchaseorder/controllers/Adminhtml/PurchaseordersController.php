<?php

class Synamen_Purchaseorder_Adminhtml_PurchaseordersController extends Mage_Adminhtml_Controller_Action
{		
	    protected function _isAllowed()
	    {
	       //return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseorders');
	    	return true;
	    }
    
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("purchaseorder/purchaseorders")->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorders  Manager"),Mage::helper("adminhtml")->__("Purchaseorders Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Purchaseorder"));
			    $this->_title($this->__("Manager Purchaseorders"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Purchaseorder"));
				$this->_title($this->__("Purchaseorders"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("purchaseorder/purchaseorders")->load($id);
				if ($model->getId()) {
					Mage::register("purchaseorders_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("purchaseorder/purchaseorders");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorders Manager"), Mage::helper("adminhtml")->__("Purchaseorders Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorders Description"), Mage::helper("adminhtml")->__("Purchaseorders Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorders_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorders_edit_tabs"));
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
		$this->_title($this->__("Purchaseorders"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("purchaseorder/purchaseorders")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("purchaseorders_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("purchaseorder/purchaseorders");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorders Manager"), Mage::helper("adminhtml")->__("Purchaseorders Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Purchaseorders Description"), Mage::helper("adminhtml")->__("Purchaseorders Description"));


		$this->_addContent($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorders_edit"))->_addLeft($this->getLayout()->createBlock("purchaseorder/adminhtml_purchaseorders_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						$post_data['date'] = date('Y-m-d H:i:s');

						$model = Mage::getModel("purchaseorder/purchaseorders")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						
						$read1 = Mage::getSingleton('core/resource')->getConnection('core_read'); 
		                $results1 = $read1->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_orders')." where id_synamen_purchase_orders = '".$model->getData('id_synamen_purchase_orders')."'");
		                $pos = $results1[0];

		                $results = $read1->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor')." where id_synamen_purchase_order_vendor = '".$model->getData('vendor_id')."'");

						$vname = $results[0]['name'];

						$order = Mage::getModel('sales/order')->load($pos['order_id']);

						$order->addStatusHistoryComment("<strong>Purchase Order Changed</strong><br/>Vendor : ".$vname." Product Code : ".$model->getData('product_code')." Product Name : ".$model->getData('product_name')." Qty : ".$model->getData('qty')." Dimension : ".$model->getData('dimension')." Colour : ".$model->getData('colour')." Note : ".$model->getData('note')." Date : ".date('Y-m-d H:i:s')." Order EDOD : ".date("Y-m-d H:i:s",strtotime($results1[0]['orderedod']))." Supplier EDOD : ".date("Y-m-d H:i:s",strtotime($results1[0]['supplieredod'])), $order->getStatusLabel())
						->setIsVisibleOnFront(0);
						
						$order->save();		

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Purchaseorders was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setPurchaseordersData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setPurchaseordersData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}

		/* Mass Status Update Action */
		public function massStatusAction()
		{
			$purchaseorderIds   = $this->getRequest()->getParam('id_synamen_purchase_orders',array());
			if(!is_array($purchaseorderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($purchaseorderIds as $purchaseorderId) {
                    $purchaseorder = Mage::getSingleton('purchaseorder/purchaseorders')
                        ->load($purchaseorderId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($purchaseorderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
		}

		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("purchaseorder/purchaseorders");
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
				$ids = $this->getRequest()->getPost('id_synamen_purchase_orderss', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("purchaseorder/purchaseorders");
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
			$fileName   = 'purchaseorders.csv';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorders_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'purchaseorders.xml';
			$grid       = $this->getLayout()->createBlock('purchaseorder/adminhtml_purchaseorders_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
		
		public function downloadAction()
		{
			$poid = $this->getRequest()->getParam('id');
			
			$read = Mage::getSingleton('core/resource')->getConnection('core_read'); 
			
			$purchase_orders = $read->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_orders')." where id_synamen_purchase_orders = '".$poid."'"); 
			
			$vendors = $read->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor')." where id_synamen_purchase_order_vendor = '".$purchase_orders[0]['vendor_id']."'");
			
			$statuses = $read->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_statuses')." where id_synamen_purchase_order_statuses = '".$purchase_orders[0]['status']."'");
			
			$pdf = new Zend_Pdf();
			$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 14);
			
			$page->drawText("Purchase Order : #1000".$poid, 30, $page->getHeight()-30, "UTF-8");
			
			$page->drawText("Date : ".$purchase_orders[0]['date'], 350, $page->getHeight()-30, "UTF-8");

			$sku = $purchase_orders[0]['product_code'];

			$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);

			$imageurl = Mage::getModel('catalog/product_media_config')
			->getMediaUrl( $_product->getImage() );

			$urlarray = explode("catalog", $imageurl);

			$imagePath = Mage::getBaseDir('media')."/catalog".$urlarray[1];
			
			if(!is_file($imagePath))
			{
			  $imagePath = Mage::getBaseDir('skin')."/frontend/base/default/images/catalog/product/placeholder/image.jpg";
			}

            $image = Zend_Pdf_Image::imageWithPath($imagePath);
            $x = 20;
            $y = 597;

           	list($iwidth, $iheight) = getimagesize($imagePath);
            $percentChange = 200 / $iheight;
			$newwidth = round( ( $percentChange * $iwidth ) );

            $page->drawImage($image, 30, $y, $x + $newwidth, $y + 200);
			
			$page->setFont($font, 12);
			
			$page->drawText("Vendor : ", 30, $page->getHeight()-275, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($vendors[0]['name'], 125, $page->getHeight()-275, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Product Code : ", 30, $page->getHeight()-305, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($purchase_orders[0]['product_code'], 125, $page->getHeight()-305, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Qty : ", 30, $page->getHeight()-335, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($purchase_orders[0]['qty'], 125, $page->getHeight()-335, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Dimension : ", 30, $page->getHeight()-365, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($purchase_orders[0]['dimension'], 125, $page->getHeight()-365, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Colour : ", 30, $page->getHeight()-395, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($purchase_orders[0]['colour'], 125, $page->getHeight()-395, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Note : ", 30, $page->getHeight()-425, "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$currentheight = $this->drawTextArea($page, $purchase_orders[0]['note'], 125, $page->getHeight()-425, 15, 85);
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);
			
			$page->drawText("Status : ", 30, $page->getHeight() - (($page->getHeight() - $currentheight) + 15), "UTF-8");
			
			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);
			
			$page->drawText($statuses[0]['title'], 125, $page->getHeight() - (($page->getHeight() - $currentheight) + 15), "UTF-8");

			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
			
			$page->setFont($font, 12);

			$page->drawText("Order ID : ", 30, $page->getHeight() - (($page->getHeight() - $currentheight) + 45), "UTF-8");

			$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
			
			$page->setFont($font, 12);

			$order = Mage::getModel('sales/order')->load($purchase_orders[0]['order_id']);
			$Incrementid = $order->getIncrementId();
			
			$page->drawText($Incrementid, 125, $page->getHeight() - (($page->getHeight() - $currentheight) + 45), "UTF-8");
			
			$page->drawText("© ".date('Y').". All Rights Reserved.", 225, $page->getHeight() - ($page->getHeight() - 30), "UTF-8");
			
			$pdf->pages[] = $page;
	 
			
			$content =  $pdf->render();
	 
			$fileName = 'purchaseorder.pdf';
			
			$this->_prepareDownloadResponse($fileName, $content);
		}
		
		public function drawTextArea($page, $text, $pos_x, $pos_y, $height, $length = 0, $offset_x = 0, $offset_y = 0)
		{
			$x = $pos_x + $offset_x;
			$y = $pos_y + $offset_y;

			if ($length != 0) {
				$text = wordwrap($text, $length, "\n", false);
			}
			$token = strtok($text, "\n");

			while ($token != false) {
				$page->drawText($token, $x, $y);
				$token = strtok("\n");
				$y -= $height;
			}
			
			return $y;
		}
}