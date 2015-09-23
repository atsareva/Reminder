<?php

/**
 * Reminder group collection
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Resource_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Group user relation table
     *
     * @var string
     */
    protected $_groupUserTable;

    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('olts_reminder/group');

        $this->_groupUserTable = $this->getResource()->getTable('olts_reminder/group_user_relation');
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return parent::_toOptionArray('group_id', 'group_name');
    }

    /**
     * Retrieve option hash
     *
     * @return array
     */
    public function toOptionHash()
    {
        return parent::_toOptionHash('group_id', 'group_name');
    }

    /**
     * Retrieve all groups tah has been assigned to user
     *
     * @param Mage_Admin_Model_User $user
     * @return array
     */
    public function getGroupsByUser(Mage_Admin_Model_User $user)
    {
        $connection = $this->getResource()
            ->getReadConnection();

        $select = $connection->select()
            ->from($this->_groupUserTable, array('group_id'))
            ->where('user_id = :user_id');

        $bind = array('user_id' => (int)$user->getId());

        return $connection->fetchAssoc($select, $bind);
    }
}
