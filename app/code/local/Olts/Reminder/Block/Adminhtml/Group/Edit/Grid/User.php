<?php

/**
 * Group user grid
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Group_Edit_Grid_User extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('group_user_id');
        $this->setDefaultDir('asc');
        $this->setId('groupUserGrid');
        $this->setDefaultFilter(array('in_group_users' => 1));
        $this->setUseAjax(true);
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_group_users') {
            $inGroupIds = $this->_getUsers();
            if (empty($inGroupIds)) {
                $inGroupIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('user_id', array('in' => $inGroupIds));
            } else {
                if ($inGroupIds) {
                    $this->getCollection()->addFieldToFilter('user_id', array('nin' => $inGroupIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {
        Mage::register('GID', $this->getRequest()->getParam('gid'));

        $collection = Mage::getModel('admin/user')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('in_group_users', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_role_users',
            'values' => $this->_getUsers(),
            'align' => 'center',
            'index' => 'user_id'
        ));

        $this->addColumn('group_user_id', array(
            'header' => Mage::helper('olts_reminder')->__('User ID'),
            'width' => 5,
            'align' => 'left',
            'sortable' => true,
            'index' => 'user_id'
        ));

        $this->addColumn('group_user_username', array(
            'header' => Mage::helper('olts_reminder')->__('User Name'),
            'align' => 'left',
            'index' => 'username'
        ));

        $this->addColumn('group_user_firstname', array(
            'header' => Mage::helper('olts_reminder')->__('First Name'),
            'align' => 'left',
            'index' => 'firstname'
        ));

        $this->addColumn('group_user_lastname', array(
            'header' => Mage::helper('olts_reminder')->__('Last Name'),
            'align' => 'left',
            'index' => 'lastname'
        ));

        $this->addColumn('group_user_email', array(
            'header' => Mage::helper('olts_reminder')->__('Email'),
            'width' => 40,
            'align' => 'left',
            'index' => 'email'
        ));

        $this->addColumn('group_user_is_active', array(
            'header' => Mage::helper('olts_reminder')->__('Status'),
            'index' => 'is_active',
            'align' => 'left',
            'type' => 'options',
            'options' => array('1' => Mage::helper('olts_reminder')->__('Active'), '0' => Mage::helper('olts_reminder')->__('Inactive')),
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        $groupId = $this->getRequest()->getParam('gid');
        return $this->getUrl('*/*/editgroupgrid', array('gid' => $groupId));
    }

    protected function _getUsers($json = false)
    {
        if ($this->getRequest()->getParam('in_group_user') != "") {
            return $this->getRequest()->getParam('in_group_user');
        }
        $groupId = ($this->getRequest()->getParam('gid') > 0) ? $this->getRequest()->getParam('gid') : Mage::registry('GID');
        $users = Mage::getModel('olts_reminder/group')->setId($groupId)->getGroupUsers();
        if (sizeof($users) > 0) {
            if ($json) {
                $jsonUsers = Array();
                foreach ($users as $usrid) $jsonUsers[$usrid['user_id']] = 0;
                return Mage::helper('core')->jsonEncode((object)$jsonUsers);
            } else {
                return array_keys($users);
            }
        } else {
            if ($json) {
                return '{}';
            } else {
                return array();
            }
        }
    }
}

