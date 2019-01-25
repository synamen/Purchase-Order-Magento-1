<?php
class Synamen_Purchaseorder_Block_Adminhtml_Widget_Grid_Column_Renderer_Inline
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $html = parent::render($row);

        $url = "'".$this->getUrl("*/*/download/id/".$row->getId())."'";
 
        $html .= '<style>input[name="action"]{display: none;}</style><button onclick="setLocation('.$url.')">' . Mage::helper('purchaseorder')->__('Download') . '</button>';
 
        return $html;
    }
 
}