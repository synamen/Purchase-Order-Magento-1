<?php
class Synamen_Purchaseorder_Adminhtml_PurchaseorderbackendController extends Mage_Adminhtml_Controller_Action
{
	protected function _isAllowed()
    {
       // return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseorderbackend');
       // return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseorders');
       // return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseorderstatus');
       // return Mage::getSingleton('admin/session')->isAllowed('synamen/purchaseorder/purchaseordervendor');  
       return true;     
    }
    
	public function indexAction()
    {
		$obj = Mage::getModel('catalog/product');
		$_product = $obj->load(Mage::app()->getRequest()->getParam('productid'));
		$product_dimension = $_product->getResource()->getAttribute('product_dimension');

		if($product_dimension){
			$product_dimension = $_product->getResource()->getAttribute('product_dimension')->getFrontend()->getValue($_product);
		}
		
		$htmlform = '<form action="'.$this->getUrl('*/*/create').'" method="post" name="purchaseorder" id="purchaseorder">';
		$htmlform .= '<table class="purchaseordertable">';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Product Code';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input required type="text" name= "code" value="'.$_product->getSku().'" readonly />';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Product Name';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input required type="text" name= "product_name" value="'.$_product->getName().'" readonly />';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Quantity Ordered';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input required type="text" name= "qty" value="'.Mage::app()->getRequest()->getParam('qty').'" />';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';

		if($product_dimension){
			$htmlform .= '<tr>';
			$htmlform .= '<td>';
			$htmlform .= 'Dimension';
			$htmlform .= '</td>';
			$htmlform .= '<td>';
			$htmlform .= '<input type="text" name= "dimension" value="'.$product_dimension.'" />';
			$htmlform .= '</td>';
			$htmlform .= '</tr>';
		}
		
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Colour';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input type="text" name= "colour" />';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Additional Note';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<textarea name= "note"></textarea>';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Choose Vendor';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<select required name="vendor">';
		$htmlform .= '<option value="">Choose Vendor</option>';
		$read= Mage::getSingleton('core/resource')->getConnection('core_read');
		$value=$read->query("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor'));

		while ($row = $value->fetch()){
			$htmlform .= '<option value="'.$row['id_synamen_purchase_order_vendor'].'">'.$row['name'].'</option>';
		};
	   
		$htmlform .= '</select>';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Order EDOD';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input type="date" name ="orderedod">';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= 'Supplier EDOD';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input type="date" name ="supplieredod">';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '<td>';
		$htmlform .= '</td>';
		$htmlform .= '<td>';
		$htmlform .= '<input type="submit" name= "create" value="Create" />';
		$htmlform .= '</td>';
		$htmlform .= '</tr>';
		$htmlform .= '<tr>';
		$htmlform .= '</table>';
		$htmlform .= '<input type="hidden" name="form_key" value="'.Mage::getSingleton('core/session')->getFormKey().'" />';
		$htmlform .= '<input type="hidden" name="orderid" value="'.Mage::app()->getRequest()->getParam('orderid').'" />';
		$htmlform .= '<input type="hidden" name="status" value="'.Mage::app()->getRequest()->getParam('status').'" />';
		$htmlform .= '</form>';
		$htmlform .= '<style>table.purchaseordertable {width: 100%;}table.purchaseordertable td {padding: 10px;}table.purchaseordertable input[type="text"] {padding: 5px;}table.purchaseordertable select {padding: 5px;}table.purchaseordertable input[type="submit"] {padding: 5px 20px;cursor: pointer;border-radius: 5px;}table.purchaseordertable textarea {padding: 5px;width: 300px;height: 150px !important;}</style>';

		Mage::app()->getResponse()->setBody($htmlform);
    }
	
	public function createAction()
    {
		$order = Mage::getModel('sales/order')->load(Mage::app()->getRequest()->getParam('orderid'));

		$read = Mage::getSingleton('core/resource')->getConnection('core_read'); 
		
		$results = $read->fetchAll("select * from ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor')." where id_synamen_purchase_order_vendor = '".Mage::app()->getRequest()->getParam('vendor')."'");

		$vname = $results[0]['name'];
		
		$order->addStatusHistoryComment("<strong>Purchase Order Created</strong><br/>Vendor : ".$vname." Product Code : ".Mage::app()->getRequest()->getParam('code')." Product Name : ".Mage::app()->getRequest()->getParam('product_name')." Qty : ".Mage::app()->getRequest()->getParam('qty')." Dimension : ".Mage::app()->getRequest()->getParam('dimension')." Colour : ".Mage::app()->getRequest()->getParam('colour')." Note : ".Mage::app()->getRequest()->getParam('note')." Date : ".date('Y-m-d H:i:s')." Order EDOD : ".date("Y-m-d H:i:s",strtotime(Mage::app()->getRequest()->getParam('orderedod')))." Supplier EDOD : ".date("Y-m-d H:i:s",strtotime(Mage::app()->getRequest()->getParam('supplieredod'))), Mage::app()->getRequest()->getParam('status'))
		->setIsVisibleOnFront(0);
		
		$order->save();		
		
		$storeId = Mage::app()->getStore()->getStoreId();
		
		$configValue = Mage::getStoreConfig('purchaseorder/settings/default_status', $storeId);
		
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		
		$write->insert(
				Mage::getSingleton('core/resource')->getTableName('synamen_purchase_orders'), 
				array("vendor_id" => Mage::app()->getRequest()->getParam('vendor'), "order_id" => Mage::app()->getRequest()->getParam('orderid'), "product_code" => Mage::app()->getRequest()->getParam('code'), "product_name" => Mage::app()->getRequest()->getParam('product_name'), "qty" => Mage::app()->getRequest()->getParam('qty'), "dimension" => Mage::app()->getRequest()->getParam('dimension'), "colour" => Mage::app()->getRequest()->getParam('colour'), "note" => Mage::app()->getRequest()->getParam('note'), "status" => $configValue, "date" => date('Y-m-d H:i:s'), "orderedod" => date("Y-m-d H:i:s",strtotime(Mage::app()->getRequest()->getParam('orderedod'))), "supplieredod" => date("Y-m-d H:i:s",strtotime(Mage::app()->getRequest()->getParam('supplieredod'))))
		);
		
		$phone = $results[0]['mobilenumber'];
		
		$enable = Mage::getStoreConfig('purchaseorder/settings/enabled');
		
		$api = Mage::getStoreConfig('purchaseorder/settings/sms_api'); 
		
		$userid = Mage::getStoreConfig('purchaseorder/settings/sms_userid');
		
		$message_to_be_sent = Mage::getStoreConfig('purchaseorder/settings/sms_message');	

		$message_to_be_sent = str_replace('[purchase_order_id]', $order->getIncrementId(), $message_to_be_sent);
		
		$message_to_be_sent = str_replace(' ', '+', $message_to_be_sent);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://alerts.solutionsinfini.com/api/web2sms.php?workingkey=".$api."&to=".$phone."&sender=".$userid."&message=".$message_to_be_sent);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$response = curl_exec($ch);
		$status = curl_getinfo($ch);
		
		curl_close($ch);
		
		$log_txt = "Synamen SMS Request : http://alerts.solutionsinfini.com/api/web2sms.php?workingkey=".$api."&to=".$phone."&sender=".$userid."&message=".$message_to_be_sent." Response: ".$response."\n";

		Mage::log($log_txt);
		
		Mage::app()->getResponse()->setBody("<div class='purchase-order-created'><div class='msg'>Purchase Order Created Successfully.</div></div> <style>.purchase-order-created {margin: 40% 0px;}.purchase-order-created .msg {text-align: center;font-size: 20px;color: #3d6611;text-transform: uppercase;font-weight: bold;font-family: Arial, Helvetica, sans-serif;}</style>");
	}
}