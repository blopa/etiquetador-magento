<?php
class FabioSantos_EtiquetaEndereco_EtiquetaController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
		$this->loadLayout();
		$this->renderLayout();
    }

	public function massPrintEtiquetaAction()
	{
		$data = $this->getRequest()->getParams();
		
        $this->loadLayout();

		$layout = $this->getLayout();
		$layout->removeOutputBlock('root');
		
		$layout->addBlock('etiquetaendereco/printetiqueta','printetiqueta');
		$layout->addOutputBlock('printetiqueta');
		
		$layout->getBlock('printetiqueta')
						->setTemplate('etiquetaendereco/printEtiqueta' . $data['labels-page'] . '.phtml')
						->setData('order_ids',$data['order_ids'])
						->setData('labels_page',$data['labels-page']);

		$this->renderLayout();
	}
	
	public function massPrintARAction()
	{
		$data = $this->getRequest()->getParams();
		
        $this->loadLayout();

		$layout = $this->getLayout();
		$layout->removeOutputBlock('root');
		
		$layout->addBlock('etiquetaendereco/printetiqueta','printetiqueta');
		$layout->addOutputBlock('printetiqueta');

		$layout->getBlock('printetiqueta')
						->setTemplate('etiquetaendereco/printAR.phtml')
						->setData('order_ids',$data['order_ids'])
						->setData('mao_propria',array_key_exists('mao_propria',$data) ? $data['mao_propria'] : 0);

		$this->renderLayout();		
	}	
}
