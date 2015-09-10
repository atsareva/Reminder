<?php

/**
 * Adminhtml reminder grid block item renderer by status.
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Reminder_Grid_Renderer_Status
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Renders status column in thr reminder grid
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $cssClass = '';
        switch ($row->getStatusCode()) {
            case Olts_Reminder_Model_Statuses::STATUS_CODE_DISABLED:
                $cssClass = 'reminder-disabled';
                break;
            case Olts_Reminder_Model_Statuses::STATUS_CODE_PENDING:
                $cssClass = 'reminder-pending';
                break;
            case Olts_Reminder_Model_Statuses::STATUS_CODE_PROCESSING:
                $cssClass = 'reminder-processing';
                break;
            case Olts_Reminder_Model_Statuses::STATUS_CODE_COMPLETED:
                $cssClass = 'reminder-completed';
                break;
            case Olts_Reminder_Model_Statuses::STATUS_CODE_FAILED:
                $cssClass = 'reminder-failed';
                break;
        }
        return "<div class='$cssClass'>" . $row->getStatusName() . '</div>';
    }

}
