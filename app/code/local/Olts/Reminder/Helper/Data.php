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
}