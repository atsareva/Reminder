<?php

/**
 * Adminhtml reminder grid
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Reminder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reminderGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('reminder_id');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('olts_reminder/reminder')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('reminder_id', array(
            'header' => Mage::helper('olts_reminder')->__('ID'),
            'index' => 'reminder_id',
            'align' => 'right',
            'width' => '50px'
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('olts_reminder')->__('Title'),
            'index' => 'title'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/reminderGrid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('rid' => $row->getId()));
    }
}
