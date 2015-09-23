<?php

/**
 * Reminder mysql resource
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Resource_Reminder extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('olts_reminder/reminder', 'reminder_id');
    }

    /**
     * Perform operations before object save
     *
     * @param Olts_Reminder_Model_Reminder $object
     * @return Olts_Reminder_Model_Resource_Reminder
     */
    protected function _beforeSave(Olts_Reminder_Model_Reminder $object)
    {
        if (!$object->getId()) {
            $object->setCreationTime(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());
        $object->setStatusId((int)$this->_getReminderStatus($object)->getId());

        return $this;
    }

    /**
     * Retrieve actual reminder status
     *
     * @param Olts_Reminder_Model_Reminder $reminder
     * @return Olts_Reminder_Model_Statuses
     */
    protected function _getReminderStatus(Olts_Reminder_Model_Reminder $reminder)
    {
        return Mage::helper('olts_reminder')->getActualReminderStatus($reminder);
    }

    /**
     * Update reminder status
     *
     * @param Olts_Reminder_Model_Reminder $reminder
     * @return Olts_Reminder_Model_Resource_Reminder
     */
    public function updateStatus(Olts_Reminder_Model_Reminder $reminder)
    {
        //get actual status
        $status = $this->_getReminderStatus($reminder);
        if ($status->getId() != $reminder->getStatusId()) {
            $reminder->setStatusId($status->getId());

            $bind = array('status_id' => (int)$status->getId());
            $where = array('reminder_id = ?' => (int)$reminder->getId());

            $this->_getWriteAdapter()->update($this->getMainTable(), $bind, $where);
        }

        return $this;
    }


}
