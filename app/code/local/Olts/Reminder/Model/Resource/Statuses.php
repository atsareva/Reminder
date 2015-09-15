<?php

/**
 * Reminder statuses mysql resource
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Model_Resource_Statuses extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('olts_reminder/statuses', 'status_id');
    }

    /**
     * Load status by code
     *
     * @param Olts_Reminder_Model_Statuses $status
     * @param string $code
     * @return Olts_Reminder_Model_Resource_Statuses
     */
    public function loadByCode(Olts_Reminder_Model_Statuses $status, $code)
    {
        $adapter = $this->_getReadAdapter();
        $bind = array('code' => $code);
        $select = $adapter->select()
            ->from($this->getMainTable(), array($this->getIdFieldName()))
            ->where('code = :code');

        $statusId = $adapter->fetchOne($select, $bind);
        if ($statusId) {
            $this->load($status, $statusId);
        } else {
            $status->setData(array());
        }

        return $this;
    }
}
