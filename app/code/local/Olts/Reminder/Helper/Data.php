<?php

/**
 * Data helper
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Retrieve admins option array
     *
     * @return array
     */
    public function getUsersOptionArray()
    {
        $options = array();
        $users = Mage::getResourceModel('admin/user_collection');
        foreach ($users as $user) {
            $options[$user->getId()] = $user->getName();
        }

        return $options;
    }

    /**
     * Retrieve reminder groups option array
     *
     * @return array
     */
    public function getGroupsOptionArray()
    {
        $options = Mage::getResourceModel('olts_reminder/group_collection')->toOptionHash();
        $options[null] = $this->__('-- Please Select --');
        ksort($options);

        return $options;
    }

    /**
     * Retrieve current status of reminder
     *
     * @param Olts_Reminder_Model_Reminder $reminder
     * @return string
     */
    public function getActualReminderStatus(Olts_Reminder_Model_Reminder $reminder)
    {
        if ($reminder->getIsComplete()) {
            return Olts_Reminder_Model_Statuses::STATUS_CODE_COMPLETED;
        }

        if (!$reminder->getIsActive()) {
            return Olts_Reminder_Model_Statuses::STATUS_CODE_DISABLED;
        }

        $dateTo = $this->_getTimestamp($reminder->getDateTo());
        $dateFrom = $this->_getTimestamp($reminder->getDateFrom());
        $currentDate = $this->_getTimestamp();

        if ($currentDate < $dateFrom) {
            return Olts_Reminder_Model_Statuses::STATUS_CODE_PENDING;
        } elseif ($currentDate >= $dateFrom && $currentDate <= $dateTo) {
            return Olts_Reminder_Model_Statuses::STATUS_CODE_PROCESSING;
        } else {
            return Olts_Reminder_Model_Statuses::STATUS_CODE_FAILED;
        }

    }

    /**
     * Retrieve GMT timestamp
     *
     * @param mixed $input
     * @return int
     */
    protected function _getTimestamp($input = null)
    {
        $dateModel = Mage::getSingleton('core/date');
        if ($input) {
            return $dateModel->gmtTimestamp($input);
        }

        return $dateModel->gmtTimestamp();
    }
}