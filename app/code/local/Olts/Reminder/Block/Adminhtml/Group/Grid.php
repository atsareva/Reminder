<?php

/**
 * Adminhtml reminder group grid
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('reminderGroupGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('group_id');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('olts_reminder/group')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('group_id', array(
            'header' => Mage::helper('olts_reminder')->__('ID'),
            'index' => 'group_id',
            'align' => 'right',
            'width' => '50px'
        ));

        $this->addColumn('group_name', array(
            'header' => Mage::helper('olts_reminder')->__('Group Name'),
            'index' => 'group_name'
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('olts_reminder')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('olts_reminder')->__('Edit'),
                        'url' => array('base' => '*/*/editgroup'),
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

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_id');
        $this->getMassactionBlock()->setFormFieldName('group');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('olts_reminder')->__('Delete'),
            'url' => $this->getUrl('*/*/massDeleteGroup'),
            'confirm' => Mage::helper('olts_reminder')->__('Are you sure?')
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/groupGrid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/editgroup', array('gid' => $row->getGroupId()));
    }
}
