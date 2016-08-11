<?php
class Werules_Etiquetador_Adminhtml_EtiquetadorController extends Mage_Adminhtml_Controller_Action {

	public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Entiquetador'));
        $this->loadLayout();
        $this->_setActiveMenu('sales/sales');
        $this->_addContent($this->getLayout()->createBlock('werules_etiquetador/adminhtml_sales_order'));
        $this->renderLayout();
    }
 
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('werules_etiquetador/adminhtml_sales_order_grid')->toHtml()
        );
    }
	
	public function massPrintEtiquetaAction()
	{
		$data = $this->getRequest()->getParams();
		$count = 0;
		foreach($data["order_ids"] as $order_id){
			$order = Mage::getModel('sales/order')->load($order_id);
			$shippingAddress = $order->getShippingAddress();
			$shippingAdressdata = $order->getShippingAddress()->getData();
			$store = Mage::getModel('core/store')->load($order->getStoreId());
			$street = ucwords(strtolower($shippingAddress->getStreet(1)));
			$number = $shippingAddress->getStreet(2);
			$extra = ucwords(strtolower($shippingAddress->getStreet(3)));
			$neighborhood = ucwords(strtolower($shippingAddress->getStreet(4)));
			$fullName = ucwords(strtolower($shippingAdressdata["firstname"] . " " . $shippingAdressdata["lastname"]));
			$zipcode = str_replace('-', '', $shippingAdressdata["postcode"]);
			$barcode = Mage::getModel('werules_etiquetador/barcode')->phpCode128($zipcode);
			//$skinUrl = "/skin/adminhtml/default/default/images/etiquetador/";
			$skinUrl = Mage::getDesign()->getSkinUrl('images/etiquetador/');
			$origin = Mage::getStoreConfig('shipping/origin');
			if($count == 0 || $count % 3 == 0){
				echo '<div style="height: 275px; width: 810px;">';
			}
			echo '<div style="width: 250px; border: 1px solid; border-radius: 15px; padding: 5px 5px 0px 5px; float: left; margin-right: 5px;">';
			echo "<img src='" . $skinUrl . "destinatario.gif' alt='' /><img src='" . $skinUrl . "logo_correios.gif' alt='' style='width: 95px; float: right;' /><br />";
			echo "<div style='padding: 5px;'>";
			echo $fullName;
			echo "<br>";
			echo $street . ", " . $number;
			echo "<br>";
			if($extra != ""){
				echo $extra;				
			}			
			if($neighborhood != ""){
				if($extra != "") echo ", ";
				echo $neighborhood;
				echo "<br>";
			}
			echo $shippingAdressdata["city"] . " - " . $shippingAdressdata["region"];
			echo "<br>";
			echo "CEP: " . $zipcode;
			echo "</div>";
			foreach ($barcode as $bcode){
				echo "<img src='" . $skinUrl . $bcode['type'] . ".gif' width='" . $bcode['value'] . "' height='37' alt='' />";
			}
			echo "<hr>";
			echo '<p style="font-size: 11px;">';
			echo "<b>Remetente</b><br>";
			echo $store->getFrontendName();
			echo "<br>";
			echo $origin["street_line1"];
			echo "<br>";
			echo $origin["street_line2"];
			echo "<br>";
			echo $origin["city"] . " - " . Mage::getModel('directory/region')->load($origin["region_id"])->getName();
			echo "<br>";
			echo "CEP: " . $origin["postcode"];
			echo "</p>";
			echo "</div>";
			$count++;
			if($count % 3 == 0){
				echo "</div>";
			}			
		}
	}
}