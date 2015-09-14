<?php

/**
 * Reminder model
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Reminder extends Mage_Core_Model_Abstract
{

    /**
     * Reminder's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init('olts_reminder/reminder');
    }

    /**
     * Prepare reminder's statuses.
     * Available event reminder_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('olts_reminder')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('olts_reminder')->__('Disabled'),
        ));

        Mage::dispatchEvent('reminder_get_available_statuses', array('statuses' => $statuses));

        return $statuses->getData();
    }
}
