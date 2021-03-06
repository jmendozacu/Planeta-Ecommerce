<?php
class Devinc_Ajaxcartx_Block_Product_List_Upsell extends Mage_Catalog_Block_Product_List_Upsell
{    
    protected function _construct()
    {
    	$this->_itemLimits['upsell'] = Mage::getStoreConfig('ajaxcartx/popup_configuration/product_number');
        parent::_construct();
    }

    public function getAdditionalContentType() {
    	return Mage::getStoreConfig('ajaxcartx/popup_configuration/additional_content');
    }

    public function getAdditionalContent() {
    	return $this->getItemCollection()->getItems();
    }

    public function getAcAddToCartUrl($_product) {      
        $params = Mage::helper('ajaxcartx')->getUrlParams($this->getAddToCartUrl($_product)); 
        unset($params['uenc']);
        $url = Mage::getUrl('ajaxcartx/index/init', $params);

        return "ajaxcartx.initAjaxcartx('".$url."', this, 'success');";
    }

    public function getAcAddToWishlistUrl($_product) {        
        $url = str_replace('wishlist/index/add/','ajaxcartx/wishlist/add/', $this->helper('wishlist')->getAddUrl($_product));

        if (Mage::helper('customer')->isLoggedIn()) {
            return "javascript:ajaxcartx.addToWishlist('".$url."', 'success')";
        } else {
            return "javascript:ajaxcartxLogin.loadLoginPopup('".$url."', 'success');";
        }
    }

    public function getAcAddToCompareUrl($_compareUrl) {        
        $url = str_replace('catalog/product_compare/add', 'ajaxcartx/product_compare/add', $_compareUrl);

        return "javascript:ajaxcartx.addToCompare('".$url."', 'success')";
    }

}