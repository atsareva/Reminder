<?php

/**
 * Adminhtml reminder group block
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'olts_reminder';
        $this->_controller = 'adminhtml_group';
        $this->_headerText = Mage::helper('olts_reminder')->__('Groups');
        $this->_addButtonLabel = Mage::helper('olts_reminder')->__('Add New Group');
        parent::__construct();

        $this->_updateButton('add', 'onclick', 'setLocation(\'' . $this->getUrl("*/*/editgroup") . '\')');
    }

}
