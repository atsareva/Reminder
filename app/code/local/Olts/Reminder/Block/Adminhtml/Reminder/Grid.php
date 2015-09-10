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
        $collection = Mage::getResourceModel('olts_reminder/reminder_collection')
            ->prepareForGrid();

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
            'header' => Mage::helper('olts_reminder')->__('Reminder Title'),
            'index' => 'title'
        ));

        $this->addColumn('user_name', array(
            'header' => Mage::helper('olts_reminder')->__('Assigned to User'),
            'index' => 'user_name',
            'filter_condition_callback' => array($this, '_customFilter'),
        ));

        $this->addColumn('group_name', array(
            'header' => Mage::helper('olts_reminder')->__('Assigned to Group'),
            'index' => 'group_name',
        ));

        $this->addColumn('order_increment_id', array(
            'header' => Mage::helper('olts_reminder')->__('Reminder for Order #'),
            'index' => 'order_increment_id',
            'width' => '100px',
            'filter_condition_callback' => array($this, '_customFilter'),
        ));

        $this->addColumn('customer_email', array(
            'header' => Mage::helper('olts_reminder')->__('Reminder for Customer'),
            'index' => 'customer_email',
            'width' => '150px',
            'filter_condition_callback' => array($this, '_customFilter'),
        ));

        $this->addColumn('date_from', array(
            'header' => Mage::helper('olts_reminder')->__('Active Date From'),
            'index' => 'date_from',
            'type' => 'datetime',
            'width' => '150px',
            'gmtoffset' => true
        ));

        $this->addColumn('date_to', array(
            'header' => Mage::helper('olts_reminder')->__('Active Date To'),
            'index' => 'date_to',
            'type' => 'datetime',
            'width' => '150px',
            'gmtoffset' => true
        ));

        $statuses = Mage::getResourceModel('olts_reminder/statuses_collection')
            ->load()
            ->toOptionHash();

        $this->addColumn('status_name', array(
            'header' => Mage::helper('olts_reminder')->__('Status'),
            'width' => '150',
            'index' => 'status_id',
            'align' => 'center',
            'type' => 'options',
            'options' => $statuses,
            'renderer' => 'olts_reminder/adminhtml_reminder_grid_renderer_status',
            'filter_condition_callback' => array($this, '_customFilter'),
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('olts_reminder')->__('Action'),
                'width' => '70',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('olts_reminder')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'gid'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
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

    protected function _customFilter(Olts_Reminder_Model_Resource_Reminder_Collection $collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $index = $column->getIndex();
        $value = $column->getFilter()->getValue();
        $collection->getSelect()->having(new Zend_Db_Expr("$index like '%$value%'"));

        return $this;
    }
}
