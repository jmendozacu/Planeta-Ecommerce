<?php
class Magestore_Affiliateplus_Block_Affiliateplus extends Mage_Core_Block_Template
{
	/**
	 * get Helper
	 *
	 * @return Magestore_Affiliateplus_Helper_Config
	 */
	public function _getHelper(){
		return Mage::helper('affiliateplus/config');
	}
	
	public function _prepareLayout(){
		return parent::_prepareLayout();
    }
    
    public function addFooterLink(){
    	$footerBlock = $this->getParentBlock();
        // Changed By Adam 28/07/2014
    	if ($footerBlock && $this->_getHelper()->getGeneralConfig('show_affiliate_link_on_frontend') && Mage::helper('affiliateplus')->isAffiliateModuleEnabled())
    		$footerBlock->addLink(
    			$this->__('Affiliates'),
    			'affiliateplus',
    			'affiliateplus',
    			true,
    			array(),
    			10
    		);
    	return $this;
    }
}