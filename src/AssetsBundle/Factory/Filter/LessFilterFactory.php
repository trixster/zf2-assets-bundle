<?php
namespace AssetsBundle\Factory\Filter;
class LessFilterFactory implements \Zend\ServiceManager\FactoryInterface{

	/**
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 * @throws \Exception
	 * @return \AssetsBundle\Service\Filter\LessFilter
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator){
		$aConfiguration = $oServiceLocator->get('Config');
		if(!isset($aConfiguration['asset_bundle']))throw new \Exception('AssetsBundle configuration is undefined');
		return new \AssetsBundle\Service\Filter\LessFilter($aConfiguration['asset_bundle']);
	}
}