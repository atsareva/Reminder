<?php

/**
 * Reminder group mysql resource
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_userRelationTable;

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('olts_reminder/group', 'group_id');

        $this->_userRelationTable = $this->getTable('olts_reminder/group_user_relation');
    }

    /**
     * After model save
     *
     * @param Mage_Core_Model_Abstract $group
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterSave(Mage_Core_Model_Abstract $group)
    {
        $this->_saveGroupUserRelation($group);

        return parent::_afterSave($group);
    }

    /**
     * Save group-user relationships
     *
     * @param Olts_Reminder_Model_Group $group
     * @return Olts_Reminder_Model_Resource_Group $this
     */
    protected function _saveGroupUserRelation($group)
    {
        $groupId = (int)$group->getId();

        /**
         * new group-user relationships
         */
        $users = $group->getNewUsersRelation();

        if ($users === null) {
            return $this;
        }

        /**
         * old group-user relationships
         */
        $oldUsers = $group->getOldUsersRelation();

        $insert = array_diff_key($users, $oldUsers);
        $delete = array_diff_key($oldUsers, $users);

        $resource = Mage::getSingleton('core/resource');
        $adapter = $resource->getConnection('core_write');
        $groupRelationTable = $resource->getTableName('olts_reminder/group_user_relation');

        /**
         * Delete users from group
         */
        if (!empty($delete)) {
            $cond = array(
                'user_id IN(?)' => array_keys($delete),
                'group_id=?' => $groupId
            );
            $adapter->delete($groupRelationTable, $cond);
        }

        /**
         * Add users to group
         */
        if (!empty($insert) && key($insert)) {
            $data = array();
            foreach ($insert as $id => $value) {
                $data[] = array(
                    'user_id' => (int)$id,
                    'group_id' => $groupId,
                );
            }
            $adapter->insertMultiple($groupRelationTable, $data);
        }

        if (!empty($insert) || !empty($delete)) {
            $usersIds = array_unique(array_merge(array_keys($insert), array_keys($delete)));
            Mage::dispatchEvent('reminder_group_change_user_relation', array(
                'group' => $group,
                'user_ids' => $usersIds
            ));
        }

        return $this;
    }

    /**
     * Get group users
     *
     * @param Olts_Reminder_Model_Group $group
     * @return array|false
     */
    public function getGroupUsers(Olts_Reminder_Model_Group $group)
    {
        $read = $this->_getReadAdapter();

        $binds = array(
            'group_id' => $group->getId()
        );

        $select = $read->select()
            ->from($this->_userRelationTable, array('user_id'))
            ->where('group_id = :group_id');

        return $read->fetchAssoc($select, $binds);
    }
}
