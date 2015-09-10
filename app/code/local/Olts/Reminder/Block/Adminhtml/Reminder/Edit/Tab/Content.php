<?php
/**
 * Reminder edit form main tab
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Olts_Reminder_Block_Adminhtml_Reminder_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        /** @var $model Olts_Reminder_Model_Reminder */
        $model = Mage::registry('current_reminder');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('reminder_');

        $fieldset = $form->addFieldset('content_fieldset', array('legend'=>Mage::helper('olts_reminder')->__('Content'),'class'=>'fieldset-wide'));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId())
        );

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('olts_reminder')->__('Reminder Title'),
            'title'     => Mage::helper('olts_reminder')->__('Reminder Title'),
        ));

        $contentField = $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'style'     => 'height:36em;',
            'required'  => true,
            'config'    => $wysiwygConfig
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        Mage::dispatchEvent('reminder_edit_tab_content_prepare_form', array('form' => $form));

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('olts_reminder')->__('Content');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('olts_reminder')->__('Content');
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
