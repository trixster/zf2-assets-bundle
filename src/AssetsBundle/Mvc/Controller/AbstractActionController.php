<?php
namespace AssetsBundle\Mvc\Controller;
use \Zend\Mvc\Controller\AbstractActionController as OriginalAbstractActionController;
abstract class AbstractActionController extends OriginalAbstractActionController{
	public function onDispatch(\Zend\Mvc\MvcEvent $oEvent){
		$oReturn = parent::onDispatch($oEvent);

		if($this->params('action') !== 'jscustomAction'
		&& !$this->getRequest()->isXmlHttpRequest()
		&& method_exists($this, 'jscustomAction')
		&& $aJsFiles = $this->jsCustomAction($this->params('action'))){
			$aConfiguration = $this->getServiceLocator()->get('config');
			if(isset($aConfiguration['asset_bundle'])){
				if(!$aConfiguration['asset_bundle']['production'])$this->layout()->jsCustomFiles = array_merge(
					is_array($this->layout()->jsCustomFiles)?$this->layout()->jsCustomFiles:array(),
					array_map(function($sJsFile){
						if(file_exists($sJsFile))return $sJsFile;
						else throw new \Exception('File not found : '.$sJsFile);
					},$aJsFiles)
				);
				else $this->layout()->jsCustomUrl = $this->getEvent()->getRouter()->assemble(
					array('controller'=>$this->params('controller'),'js_action'=>$this->params('action')),
					array('name'=>'jscustom/definition')
				);
			}
		}
		$oEvent->setResult($oReturn);
		return $oReturn;
	}
}