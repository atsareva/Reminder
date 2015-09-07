<?php
/**
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$connection = $installer->getConnection();

/**
 * Create table 'olts_reminder/group'
 */
if (!$connection->isTableExists($installer->getTable('olts_reminder/group'))) {
    $table = $connection
        ->newTable($installer->getTable('olts_reminder/group'))
        ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Reminder Group ID')
        ->addColumn('group_name', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
            'nullable' => true,
            'default' => null,
        ), 'Group Name')
        ->setComment('Reminder Group Table');
    $connection->createTable($table);
}

/**
 * Create table 'olts_reminder/group_user_relation'
 */
if (!$connection->isTableExists($installer->getTable('olts_reminder/group_user_relation'))) {
    $table = $connection
        ->newTable($installer->getTable('olts_reminder/group_user_relation'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Entity ID')
        ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Group ID')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'User ID')
        ->addIndex($installer->getIdxName('olts_reminder/group_user_relation', array('group_id')),
            array('group_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/group_user_relation', 'group_id', 'olts_reminder/group', 'group_id'),
            'group_id', $installer->getTable('olts_reminder/group'), 'group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addIndex($installer->getIdxName('olts_reminder/group_user_relation', array('user_id')),
            array('user_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/group_user_relation', 'user_id', 'admin/user', 'user_id'),
            'user_id', $installer->getTable('admin/user'), 'user_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Group User Relation Table');
    $connection->createTable($table);
}

/**
 * Create table 'olts_reminder/reminder'
 */
if (!$connection->isTableExists($installer->getTable('olts_reminder/reminder'))) {
    $table = $connection
        ->newTable($installer->getTable('olts_reminder/reminder'))
        ->addColumn('reminder_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Reminder ID')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'User ID')
        ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => true,
        ), 'Group ID')
        ->addColumn('date_from', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
            'nullable' => true,
        ), 'Reminder From Date')
        ->addColumn('date_to', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
            'nullable' => true,
        ), 'Reminder To Date')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => false,
        ), 'Reminder Title')
        ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(), 'Reminder Content')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
            'default' => '1',
        ), 'Is Reminder Active')
        ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Status ID')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => true,
        ), 'Order ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => true,
        ), 'Customer ID')
        ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Block Creation Time')
        ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Block Modification Time')
        ->addIndex($installer->getIdxName('olts_reminder/reminder', array('user_id')),
            array('user_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/reminder', 'user_id', 'admin/user', 'user_id'),
            'user_id', $installer->getTable('admin/user'), 'user_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addIndex($installer->getIdxName('olts_reminder/reminder', array('group_id')),
            array('group_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/reminder', 'group_id', 'olts_reminder/group', 'group_id'),
            'group_id', $installer->getTable('olts_reminder/group'), 'group_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addIndex($installer->getIdxName('olts_reminder/reminder', array('order_id')),
            array('order_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/reminder', 'order_id', 'sales/order', 'entity_id'),
            'order_id', $installer->getTable('sales/order'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addIndex($installer->getIdxName('olts_reminder/reminder', array('customer_id')),
            array('customer_id'))
        ->addForeignKey($installer->getFkName('olts_reminder/reminder', 'customer_id', 'customer/entity', 'entity_id'),
            'customer_id', $installer->getTable('customer/entity'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Reminder Table');
    $connection->createTable($table);
}

/**
 * Create table 'olts_reminder/statuses'
 */
if (!$connection->isTableExists($installer->getTable('olts_reminder/statuses'))) {
    $statusesTable = $installer->getTable('olts_reminder/statuses');
    $table = $connection
        ->newTable($statusesTable)
        ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Reminder Status ID')
        ->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
            'nullable' => true,
            'default' => null,
        ), 'Status Code')
        ->addColumn('status_name', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
            'nullable' => true,
            'default' => null,
        ), 'Status Name')
        ->setComment('Reminder Status Table');
    $connection->createTable($table);

    /**
     * Insert values to 'olts_reminder/statuses' table
     */
    $connection->insert($statusesTable, array(
        'code' => 'disabled',
        'status_name' => 'Disabled'
    ));

    $connection->insert($statusesTable, array(
        'code' => 'pending',
        'status_name' => 'Pending'
    ));

    $connection->insert($statusesTable, array(
        'code' => 'processing',
        'status_name' => 'Processing'
    ));

    $connection->insert($statusesTable, array(
        'code' => 'completed',
        'status_name' => 'Completed'
    ));

    $connection->insert($statusesTable, array(
        'code' => 'failed',
        'status_name' => 'Failed'
    ));
}

$installer->endSetup();
