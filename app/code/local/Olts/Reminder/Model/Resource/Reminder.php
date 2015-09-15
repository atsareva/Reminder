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

        return $this;
    }
}
