<?php
$installer = $this;
$installer->startSetup();
$sql="
DROP TABLE IF EXISTS `synamen_purchase_order_vendor`;
CREATE TABLE IF NOT EXISTS ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_vendor')." (
  `id_synamen_purchase_order_vendor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `mobilenumber` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id_synamen_purchase_order_vendor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `synamen_purchase_order_statuses`;
CREATE TABLE IF NOT EXISTS ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_statuses')." (
  `id_synamen_purchase_order_statuses` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id_synamen_purchase_order_statuses`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_order_statuses')." (`id_synamen_purchase_order_statuses`, `title`) VALUES
(1, 'Pending'),
(2, 'Complete'),
(3, 'Cancel');

DROP TABLE IF EXISTS `synamen_purchase_orders`;
CREATE TABLE IF NOT EXISTS ".Mage::getSingleton('core/resource')->getTableName('synamen_purchase_orders')." (
  `id_synamen_purchase_orders` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `dimension` varchar(255) NULL,
  `colour` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `orderedod` datetime NOT NULL,
  `supplieredod` datetime NOT NULL,
  PRIMARY KEY (`id_synamen_purchase_orders`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 