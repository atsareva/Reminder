<?php

/**
 * Reminder manage controller
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Adminhtml_ReminderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Olts_Reminder_Adminhtml_ReminderController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('reminders')
            ->_addBreadcrumb(Mage::helper('olts_reminder')->__('Reminders'), Mage::helper('olts_reminder')->__('Reminders'));
        return $this;
    }

    /**
     * Initialize group model by passed parameter in request
     *
     * @return Olts_Reminder_Model_Group
     */
    protected function _initGroup($requestVariable = 'gid')
    {
        $this->_title($this->__('Reminders'))
            ->_title($this->__('Manage Groups'));

        $group = Mage::getModel('olts_reminder/group')->load($this->getRequest()->getParam($requestVariable));

        Mage::register('current_group', $group);
        return Mage::registry('current_group');
    }

    /**
     * Manage Groups action
     */
    public function groupsAction()
    {
        $this->_title($this->__('Reminders'))->_title($this->__('Manage Groups'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Action for ajax request from group grid
     *
     */
    public function groupGridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->getBlock('reminder_group_grid')->toHtml());
    }

    /**
     * Edit group action
     *
     */
    public function editGroupAction()
    {
        $group = $this->_initGroup();
        $this->_initAction();

        if ($group->getId()) {
            $breadCrumb = $this->__('Edit Group');
            $breadCrumbTitle = $this->__('Edit Group');
        } else {
            $breadCrumb = $this->__('Add New Group');
            $breadCrumbTitle = $this->__('Add New Group');
        }

        $this->_title($group->getId() ? $group->getGroupName() : $this->__('New Group'));

        $this->_addBreadcrumb($breadCrumb, $breadCrumbTitle);

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addJs(
            $this->getLayout()->createBlock('adminhtml/template')->setTemplate('reminder/group/group_users_grid_js.phtml')
        );

        $this->renderLayout();
    }

    /**
     * Action for ajax request from assigned users grid
     *
     */
    public function editGroupGridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('olts_reminder/adminhtml_group_edit_grid_user')->toHtml()
        );
    }

    /**
     * Group form submit action to save or create new group
     *
     */
    public function saveGroupAction()
    {
        $gid = $this->getRequest()->getParam('group_id', false);
        $group = $this->_initGroup('group_id');
        if (!$group->getId() && $gid) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('This Group no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $groupUsers = $this->getRequest()->getParam('in_group_user', null);
        parse_str($groupUsers, $groupUsers);

        $oldGroupUsers = $this->getRequest()->getParam('in_group_user_old');
        parse_str($oldGroupUsers, $oldGroupUsers);

        try {
            $groupName = $this->getRequest()->getParam('group_name', false);

            $group->setGroupName($groupName)
                ->setNewUsersRelation($groupUsers)
                ->setOldUsersRelation($oldGroupUsers);

            Mage::dispatchEvent(
                'reminder_group_prepare_save',
                array('object' => $group, 'request' => $this->getRequest())
            );
            $group->save();

            $gid = $group->getId();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The group has been successfully saved.'));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this group.'));
        }

        // check if 'Save and Continue'
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/editgroup', array('gid' => $gid));
            return;
        }
        // go to grid
        $this->_redirect('*/*/groups');
    }

    /**
     * Remove group action
     */
    public function deleteGroupAction()
    {
        try {
            $group = $this->_initGroup()->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The group has been deleted.'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while deleting this role.'));
        }

        $this->_redirect('*/*/groups');
    }

    /**
     * Mass delete group action
     */
    public function massDeleteGroupAction()
    {
        $groupIds = $this->getRequest()->getParam('group');
        if (!is_array($groupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select group(s).'));
        } else {
            try {
                $groupModel = Mage::getModel('olts_reminder/group');
                foreach ($groupIds as $groupId) {
                    $groupModel->load($groupId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('Total of %d record(s) were deleted.', count($groupIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/groups');
    }
}
