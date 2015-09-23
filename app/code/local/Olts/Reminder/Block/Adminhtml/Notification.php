<?php

/**
 * Adminhtml notification
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Notification extends Mage_Adminhtml_Block_Template
{
    /**
     * Retrieve current admin
     *
     * @return Mage_Admin_Model_User
     */
    protected function _getUser()
    {
        return Mage::getSingleton('admin/session')->getUser();
    }

    /**
     * Retrieve groups by current user
     *
     * @return array
     */
    protected function _getUserGroups()
    {
        return Mage::getResourceModel('olts_reminder/group_collection')->getGroupsByUser($this->_getUser());
    }

    /**
     * Retrieve reminder collection
     *
     * @return Olts_Reminder_Model_Resource_Reminder_Collection
     */
    public function getReminders()
    {
        $collection = Mage::getResourceModel('olts_reminder/reminder_collection')
            ->addFieldToFilter(
                array('user_id', 'group_id'),
                array((int)$this->_getUser()->getId(), array('in' => array_keys($this->_getUserGroups())))
            )
            ->addFieldToFilter('is_active', true);

        return $collection->getItems();
    }
}
