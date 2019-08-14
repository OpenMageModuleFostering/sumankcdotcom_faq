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
 * Category front contrller
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_CategoryController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Suman K.C [WWW.SUMANKC.COM]
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('sumankcdotcom_faq/category')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'categories',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('FAQ'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('sumankcdotcom_faq/category')->getCategoriesUrl());
        }
        $this->renderLayout();
    }

    /**
     * init Category
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Category
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _initCategory()
    {
        $categoryId   = $this->getRequest()->getParam('id', 0);
        $category     = Mage::getModel('sumankcdotcom_faq/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);
        if (!$category->getId()) {
            return false;
        } elseif (!$category->getStatus()) {
            return false;
        }
        return $category;
    }

    /**
     * view category action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function viewAction()
    {
        $category = $this->_initCategory();
        if (!$category) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_category', $category);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('faq-category faq-category' . $category->getId());
        }
        if (Mage::helper('sumankcdotcom_faq/category')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('sumankcdotcom_faq')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'categories',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Categories'),
                        'link'  => Mage::helper('sumankcdotcom_faq/category')->getCategoriesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'category',
                    array(
                        'label' => $category->getCategories(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $category->getCategoryUrl());
        }
        $this->renderLayout();
    }
}
