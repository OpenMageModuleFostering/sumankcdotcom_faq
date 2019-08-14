<?php
/**
 * Sumankcdotcom_Faq extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Sumankcdotcom
 * @package        Sumankcdotcom_Faq
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Faq edit form tab
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Edit_Tab_Form
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('faq_');
        $form->setFieldNameSuffix('faq');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'faq_form',
            array('legend' => Mage::helper('sumankcdotcom_faq')->__('Faq'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $values = Mage::getResourceModel('sumankcdotcom_faq/category_collection')
            ->toOptionArray();
        array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="faq_category_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeCategoryIdLink() {
                if ($(\'faq_category_id\').value == \'\') {
                    $(\'faq_category_id_link\').hide();
                } else {
                    $(\'faq_category_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/faq_category/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'faq_category_id\').value);
                    $(\'faq_category_id_link\').href = realUrl;
                    $(\'faq_category_id_link\').innerHTML = text.replace(\'{#name}\', $(\'faq_category_id\').options[$(\'faq_category_id\').selectedIndex].innerHTML);
                }
            }
            $(\'faq_category_id\').observe(\'change\', changeCategoryIdLink);
            changeCategoryIdLink();
            </script>';

        $fieldset->addField(
            'category_id',
            'select',
            array(
                'label'     => Mage::helper('sumankcdotcom_faq')->__('Category'),
                'name'      => 'category_id',
                'required'  => false,
                'values'    => $values,
                'after_element_html' => $html
            )
        );

        $fieldset->addField(
            'question',
            'text',
            array(
                'label' => Mage::helper('sumankcdotcom_faq')->__('Question'),
                'name'  => 'question',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'answer',
            'editor',
            array(
                'label' => Mage::helper('sumankcdotcom_faq')->__('Answer'),
                'name'  => 'answer',
            'config' => $wysiwygConfig,
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('sumankcdotcom_faq')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('sumankcdotcom_faq')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('sumankcdotcom_faq')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_faq')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getFaqData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getFaqData());
            Mage::getSingleton('adminhtml/session')->setFaqData(null);
        } elseif (Mage::registry('current_faq')) {
            $formValues = array_merge($formValues, Mage::registry('current_faq')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
