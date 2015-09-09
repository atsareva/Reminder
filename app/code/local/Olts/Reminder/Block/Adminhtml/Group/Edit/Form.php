<?php

/**
 * Group Edit Form Block
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Group_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Retrieve group object
     *
     * @return Olts_Reminder_Model_Group
     */
    public function getModel()
    {
        return Mage::registry('current_group');
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Olts_Reminder_Block_Adminhtml_Group_Edit_Form
     */
    protected function _prepareForm()
    {
        $model = $this->getModel();

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('olts_reminder')->__('Group Information'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('group_id', 'hidden',
            array(
                'name' => 'group_id',
                'id' => 'group_id',
            )
        );

        $fieldset->addField('group_name', 'text',
            array(
                'name' => 'group_name',
                'label' => Mage::helper('olts_reminder')->__('Group Name'),
                'id' => 'group_name',
                'class' => 'required-entry',
                'required' => true,
            )
        );

        $fieldset->addField('in_group_user', 'hidden',
            array(
                'name' => 'in_group_user',
                'id' => 'in_group_user',
            )
        );

        $fieldset->addField('in_group_user_old', 'hidden', array('name' => 'in_group_user_old'));

        $form->setAction($this->getUrl('*/*/saveGroup'));
        $form->setUseContainer(true);
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
