<?php

/**
 * Reminder statuses model
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Statuses extends Mage_Core_Model_Abstract
{

    const STATUS_CODE_DISABLED = 'disabled';
    const STATUS_CODE_PENDING = 'pending';
    const STATUS_CODE_PROCESSING = 'processing';
    const STATUS_CODE_COMPLETED = 'completed';
    const STATUS_CODE_FAILED = 'failed';

    protected function _construct()
    {
        $this->_init('olts_reminder/statuses');
    }
}
