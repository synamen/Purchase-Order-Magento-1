<?php
class Synamen_Purchaseorder_IndexController extends Mage_Core_Controller_Front_Action{
    
    protected function _isAllowed()
    {
       //return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder');
      return true;
    }

    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Purchaseorder"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("purchaseorder", array(
                "label" => $this->__("Purchaseorder"),
                "title" => $this->__("Purchaseorder")
		   ));

      $this->renderLayout(); 
	  
    }
}