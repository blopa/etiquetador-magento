<?php

class Werules_Etiquetador_Block_Adminhtml_Sales_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'werules_etiquetador';
        $this->_controller = 'adminhtml_sales_order';
        $this->_headerText = Mage::helper('werules_etiquetador')->__('Orders');

        parent::__construct();
        $this->_removeButton('add');
    }
}