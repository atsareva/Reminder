<?php

/**
 * Reminder page
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Reminder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize reminder edit block
     */
    public function __construct()
    {
        $this->_objectId = 'rid';
        $this->_blockGroup = 'olts_reminder';
        $this->_controller = 'adminhtml_reminder';

        parent::__construct();

            $this->_updateButton('save', 'label', Mage::helper('olts_reminder')->__('Save Page'));
            $this->_addButton('saveandcontinue', array(
                'label' => Mage::helper('olts_reminder')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                'class' => 'save',
            ), -100);

            $this->_updateButton('delete', 'label', Mage::helper('olts_reminder')->__('Delete Page'));

    }

    /**
     * Retrieve text for header element depending on loaded reminder
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_reminder')->getId()) {
            return Mage::helper('olts_reminder')->__("Edit Reminder '%s'", $this->escapeHtml(Mage::registry('current_reminder')->getTitle()));
        } else {
            return Mage::helper('olts_reminder')->__('New Reminder');
        }
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back' => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }

    /**
     * Prepare layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $tabsBlock = $this->getLayout()->getBlock('reminder_edit_tabs');
        if ($tabsBlock) {
            $tabsBlockJsObject = $tabsBlock->getJsObjectName();
            $tabsBlockPrefix = $tabsBlock->getId() . '_';
        } else {
            $tabsBlockJsObject = 'reminder_tabsJsTabs';
            $tabsBlockPrefix = 'reminder_tabs_';
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('reminder_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'reminder_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'reminder_content');
                }
            }

            function saveAndContinueEdit(urlTemplate) {
                var tabsIdValue = " . $tabsBlockJsObject . ".activeTab.id;
                var tabsBlockPrefix = '" . $tabsBlockPrefix . "';
                if (tabsIdValue.startsWith(tabsBlockPrefix)) {
                    tabsIdValue = tabsIdValue.substr(tabsBlockPrefix.length)
                }
                var template = new Template(urlTemplate, /(^|.|\\r|\\n)({{(\w+)}})/);
                var url = template.evaluate({tab_id:tabsIdValue});
                editForm.submit(url);
            }
        ";
        return parent::_prepareLayout();
    }
}
