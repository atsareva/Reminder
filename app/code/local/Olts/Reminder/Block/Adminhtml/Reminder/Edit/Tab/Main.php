<?php
/**
 * Reminder edit form main tab
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Olts_Reminder_Block_Adminhtml_Reminder_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model Olts_Reminder_Model_Reminder */
        $model = Mage::registry('current_reminder');
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('reminder_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('olts_reminder')->__('Reminder Information')));

        if ($model->getId()) {
            $fieldset->addField('reminder_id', 'hidden', array(
                'name' => 'reminder_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('olts_reminder')->__('Page Title'),
            'title'     => Mage::helper('olts_reminder')->__('Page Title'),
            'required'  => true,
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('olts_reminder')->__('Status'),
            'title'     => Mage::helper('olts_reminder')->__('Reminder Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array('yes', 'no'),//$model->getAvailableStatuses(),
        ));

        Mage::dispatchEvent('reminder_edit_tab_main_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('olts_reminder')->__('Reminder Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('olts_reminder')->__('Reminder Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
    
}
