<?php

/**
 * Reminder group model
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Group extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('olts_reminder/group');
    }
}
