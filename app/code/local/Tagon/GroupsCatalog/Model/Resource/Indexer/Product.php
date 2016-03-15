<?php


class Tagon_GroupsCatalog_Model_Resource_Indexer_Product
    extends Tagon_GroupsCatalog_Model_Resource_Indexer_Abstract
{
    /**
     * Initialize with table name and id field
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('tagon_groupscatalog/product_index', 'id');
    }

    /**
     * Handle reindexing of single entity save events
     *
     * @param Mage_Index_Model_Event $event
     * @return Tagon_GroupsCatalog_Model_Resource_Indexer_Product
     * @see Tagon_GroupsCatalog_Model_Indexer_Abstract::_processEvent()
     */
    public function catalogProductSave(Mage_Index_Model_Event $event)
    {
        $this->_reindexEntity($event);
        return $this;
    }

    /**
     * Handle reindexing of entity mass action events
     *
     * @param Mage_Index_Model_Event $event
     * @return Tagon_GroupsCatalog_Model_Resource_Indexer_Product
     * @see Tagon_GroupsCatalog_Model_Indexer_Abstract::_processEvent()
     */
    public function catalogProductMassAction(Mage_Index_Model_Event $event)
    {
        $this->_reindexEntity($event);
        return $this;
    }

    /**
     * Return this indexers entity type code
     *
     * @return string
     */
    protected function _getEntityTypeCode()
    {
        return Mage_Catalog_Model_Product::ENTITY;
    }
}
