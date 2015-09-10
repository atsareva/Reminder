<?php

/**
 * Reminder left menu
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Reminder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reminder_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('olts_reminder')->__('Reminder Information'));
    }
}
