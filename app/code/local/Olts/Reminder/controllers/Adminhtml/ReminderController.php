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
}
