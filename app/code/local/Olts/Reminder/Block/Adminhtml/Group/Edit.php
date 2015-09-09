<?php

/**
 * Group Edit Block
 *
 * @category    Olts
 * @package     Olts_Reminder
 * @author      Olena Tsareva <olts@ciklum.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Olts_Reminder_Block_Adminhtml_Group_Edit extends Mage_Adminhtml_Block_Widget
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
     * Preparing block layout
     *
     * @return Olts_Reminder_Block_Adminhtml_Group_Edit
     */
    protected function _prepareLayout()
    {
        $this->setChild('backButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('olts_reminder')->__('Back'),
                    'onclick' => 'window.location.href=\'' . $this->getUrl('*/*/groups') . '\'',
                    'class' => 'back'
                ))
        );

        $this->setChild('resetButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('olts_reminder')->__('Reset'),
                    'onclick' => 'window.location.reload()'
                ))
        );

        $this->setChild('saveButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('olts_reminder')->__('Save Group'),
                    'onclick' => 'group_edit_form.submit();return false;',
                    'class' => 'save'
                ))
        );

        $this->setChild('saveAndContinueButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('olts_reminder')->__('Save and Continue Edit'),
                    'onclick' => "group_edit_form.submit($('group_edit_form').action='" . $this->getSaveUrl(array('back' => true)) . "');return false;",
                    'class' => 'save'
                ))
        );

        $this->setChild('deleteButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('olts_reminder')->__('Delete Group'),
                    'onclick' => 'deleteConfirm(\''
                        . MAge::helper('core')->jsQuoteEscape(
                            Mage::helper('olts_reminder')->__('Are you sure you want to do this?')
                        )
                        . '\', \''
                        . $this->getUrl('*/*/deleteGroup', array('gid' => $this->getRequest()->getParam('gid')))
                        . '\')',
                    'class' => 'delete'
                ))
        );

        return parent::_prepareLayout();
    }

    /**
     * Retrieve Back Button HTML
     *
     * @return string
     */
    public function getBackButtonHtml()
    {
        return $this->getChildHtml('backButton');
    }

    /**
     * Retrieve Reset Button HTML
     *
     * @return string
     */
    public function getResetButtonHtml()
    {
        return $this->getChildHtml('resetButton');
    }

    /**
     * Retrieve Save Button HTML
     *
     * @return string
     */
    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('saveButton');
    }

    /**
     * Retrieve Save and Continue Button HTML
     *
     * @return string
     */
    public function getSaveAndContinueButtonHtml()
    {
        return $this->getChildHtml('saveAndContinueButton');
    }
    /**
     * Retrieve Delete Button HTML
     *
     * @return string
     */
    public function getDeleteButtonHtml()
    {
        if (intval($this->getRequest()->getParam('gid')) == 0) {
            return;
        }
        return $this->getChildHtml('deleteButton');
    }

    /**
     * Return header text for form
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->getModel()->getId()) {
            return Mage::helper('olts_reminder')->__('Edit Group');
        }

        return Mage::helper('olts_reminder')->__('New Group');
    }

    /**
     * Return form block HTML
     *
     * @return string
     */
    public function getForm()
    {
        return $this->getLayout()
            ->createBlock('olts_reminder/adminhtml_group_edit_form')
            ->toHtml();
    }

    /**
     * Return action url for form
     *
     * @param array
     * @return string
     */
    public function getSaveUrl($data = array())
    {
        return $this->getUrl('*/*/saveGroup', $data);
    }
}
