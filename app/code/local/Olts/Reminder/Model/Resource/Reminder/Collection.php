<?php

/**
 * Reminder collection
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Resource_Reminder_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('olts_reminder/reminder');
    }

    /**
     * Prepare collection for reminder grid
     *
     * @return Olts_Reminder_Model_Resource_Reminder_Collection $this
     */
    public function prepareForGrid()
    {
        $this->_joinUserAndGroup();
        $this->_joinOrderAndCustomer();

        //join reminder statuses
        $this->getSelect()->joinLeft(
            array('reminder_status' => $this->getTable('olts_reminder/statuses')),
            "reminder_status.status_id = main_table.status_id",
            array("status_name" => "reminder_status.status_name", 'status_code' => 'reminder_status.code')
        );

        return $this;
    }

    /**
     * Get collection size
     *
     * @return int
     */
    public function getSize()
    {
        if (is_null($this->_totalRecords)) {
            $query = $this->getSelect()->__toString();
            $sql = "SELECT count(*) from ($query) a";
            $this->_totalRecords = $this->getConnection()->fetchOne($sql, $this->_bindParams);
        }
        return intval($this->_totalRecords);
    }

    /**
     * Add User Name and Group Name to reminder collection
     */
    protected function _joinUserAndGroup()
    {
        //join user
        $this->getSelect()->joinLeft(
            array('admin_user' => $this->getTable('admin/user')),
            "admin_user.user_id = main_table.user_id",
            array("user_name" => "CONCAT_WS(' ', admin_user.firstname, admin_user.lastname)")
        );

        //join group
        $this->getSelect()->joinLeft(
            array('user_group' => $this->getTable('olts_reminder/group')),
            "user_group.group_id = main_table.group_id",
            array("group_name" => "user_group.group_name")
        );
    }

    /**
     * Add Order Increment ID and Customer Email to reminder collection
     */
    protected function _joinOrderAndCustomer()
    {
        //join order
        $this->getSelect()->joinLeft(
            array('o' => $this->getTable('sales/order')),
            "o.entity_id = main_table.order_id",
            array("order_increment_id" => "o.increment_id")
        );

        //join customer
        $this->getSelect()->joinLeft(
            array('c' => $this->getTable('customer/entity')),
            "c.entity_id = main_table.customer_id",
            array("customer_email" => "c.email")
        );
    }
}
