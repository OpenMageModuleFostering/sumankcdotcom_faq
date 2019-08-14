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
 * Category admin edit tabs
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Ultimate Module Creator
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('category_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sumankcdotcom_faq')->__('Category'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_category',
            array(
                'label'   => Mage::helper('sumankcdotcom_faq')->__('Category'),
                'title'   => Mage::helper('sumankcdotcom_faq')->__('Category'),
                'content' => $this->getLayout()->createBlock(
                    'sumankcdotcom_faq/adminhtml_category_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_category',
                array(
                    'label'   => Mage::helper('sumankcdotcom_faq')->__('Store views'),
                    'title'   => Mage::helper('sumankcdotcom_faq')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'sumankcdotcom_faq/adminhtml_category_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve category entity
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Category
     * @author Ultimate Module Creator
     */
    public function getCategory()
    {
        return Mage::registry('current_category');
    }
}
