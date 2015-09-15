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

// add 'is_complete' column to reminder table
$installer->getConnection()
    ->addColumn($installer->getTable('olts_reminder/reminder'), 'is_complete', array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => '0',
        'comment' => 'Is Reminder Complete.'
    ));

$installer->endSetup();