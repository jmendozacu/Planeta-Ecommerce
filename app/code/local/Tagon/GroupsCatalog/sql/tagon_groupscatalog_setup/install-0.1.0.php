<?php


/* @var $installer Tagon_GroupsCatalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Just to be sure the latest version of the attributes is installed
$installer->deleteTableRow(
    'eav/attribute', 'attribute_code', Tagon_GroupsCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE
);

// Add new attributes
$installer->addAttribute('catalog_product', Tagon_GroupsCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE, array(
    'label' => 'Hide/Show from Customer Groups',
    'group' => 'General',
    'type' => 'text',
    'input' => 'multiselect',
    'source' => 'tagon_groupscatalog/entity_attribute_source_customergroup_withdefault',
    'backend' => 'tagon_groupscatalog/entity_attribute_backend_customergroups',
    'frontend' => 'tagon_groupscatalog/entity_attribute_frontend_customergroups',
    'input_renderer' => 'tagon_groupscatalog/adminhtml_data_form_customergroup',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => 0,
    'default' => Tagon_GroupsCatalog_Helper_Data::USE_DEFAULT,
    'user_defined' => 0,
    'filterable_in_search' => 0,
    'is_configurable' => 0,
    'used_in_product_listing' => 1,
));

$installer->addAttribute('catalog_category', Tagon_GroupsCatalog_Helper_Data::HIDE_GROUPS_ATTRIBUTE, array(
    'label' => 'Hide/Show from Customer Groups',
    'group' => 'General Information',
    'type' => 'text',
    'input' => 'multiselect',
    'source' => 'tagon_groupscatalog/entity_attribute_source_customergroup_withdefault',
    'backend' => 'tagon_groupscatalog/entity_attribute_backend_customergroups',
    'input_renderer' => 'tagon_groupscatalog/adminhtml_data_form_customergroup',
    'frontend' => 'tagon_groupscatalog/entity_attribute_frontend_customergroups',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => 0,
    'default' => Tagon_GroupsCatalog_Helper_Data::USE_DEFAULT,
    'user_defined' => 0,
));

/*
 * Create product customer group index table
 */
$tableName = $installer->getTable('tagon_groupscatalog/product_index');

// Make reinstalls of this module possible, even if the db wasn't cleaned up completely
if ($installer->getConnection()->isTableExists($tableName)) {
    $installer->getConnection()->dropTable($tableName);
}

$table = $installer->getConnection()->newTable($tableName)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'identity' => true,
        ), 'ID')

        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Product ID')

        ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Customer Group Id')

        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Store ID')

        ->addIndex($installer->getIdxName($tableName, array('entity_id', 'group_id', 'store_id')),
            array('entity_id', 'group_id', 'store_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))

        ->addForeignKey(
            $installer->getFkName($tableName, 'entity_id', 'catalog/product', 'entity_id'),
            'entity_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey(
            $installer->getFkName($tableName, 'group_id', 'customer/customer_group', 'customer_group_id'),
            'group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey(
            $installer->getFkName($tableName, 'store_id', 'core/store', 'store_id'),
            'store_id', $installer->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->setComment('GroupsCatalog Product Customer Group Index Table');
$installer->getConnection()->createTable($table);


/*
 * Create category customer group index table
 */
$tableName = $installer->getTable('tagon_groupscatalog/category_index');

// Make reinstalls of this module possible, even if the db wasn't cleaned up completely
if ($installer->getConnection()->isTableExists($tableName)) {
    $installer->getConnection()->dropTable($tableName);
}

$table = $installer->getConnection()->newTable($tableName)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'identity' => true,
        ), 'ID')

        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Category ID')

        ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Customer Group Id')

        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Store ID')

        ->addIndex($installer->getIdxName($tableName, array('entity_id', 'group_id', 'store_id')),
            array('entity_id', 'group_id', 'store_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))

        ->addForeignKey(
            $installer->getFkName($tableName, 'entity_id', 'catalog/category', 'entity_id'),
            'entity_id', $installer->getTable('catalog/category'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey(
            $installer->getFkName($tableName, 'group_id', 'customer/customer_group', 'customer_group_id'),
            'group_id', $installer->getTable('customer/customer_group'), 'customer_group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->addForeignKey(
            $installer->getFkName($tableName, 'store_id', 'core/store', 'store_id'),
            'store_id', $installer->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

        ->setComment('GroupsCatalog Category Customer Group Index Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
