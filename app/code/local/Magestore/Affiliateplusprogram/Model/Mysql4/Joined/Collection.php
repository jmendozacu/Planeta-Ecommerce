<?php

class Magestore_Affiliateplusprogram_Model_Mysql4_Joined_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct(){
        parent::_construct();
        $this->_init('affiliateplusprogram/joined');
    }
}
