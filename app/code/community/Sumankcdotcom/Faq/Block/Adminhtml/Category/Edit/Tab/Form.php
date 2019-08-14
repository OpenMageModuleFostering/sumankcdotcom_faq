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
 * Category edit form tab
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Edit_Tab_Form
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('category_');
        $form->setFieldNameSuffix('category');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'category_form',
            array('legend' => Mage::helper('sumankcdotcom_faq')->__('Category'))
        );

        $fieldset->addField(
            'categories',
            'text',
            array(
                'label' => Mage::helper('sumankcdotcom_faq')->__('category Name'),
                'name'  => 'categories',
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
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_category')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_category')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCategoryData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCategoryData());
            Mage::getSingleton('adminhtml/session')->setCategoryData(null);
        } elseif (Mage::registry('current_category')) {
            $formValues = array_merge($formValues, Mage::registry('current_category')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
