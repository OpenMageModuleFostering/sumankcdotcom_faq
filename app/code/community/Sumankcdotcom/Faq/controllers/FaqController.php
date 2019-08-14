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
 * Faq front contrller
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_FaqController extends Mage_Core_Controller_Front_Action
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
        if (Mage::helper('sumankcdotcom_faq/faq')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'faqs',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Faqs'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('sumankcdotcom_faq/faq')->getFaqsUrl());
        }
        $this->renderLayout();
    }

    /**
     * init Faq
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Faq
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _initFaq()
    {
        $faqId   = $this->getRequest()->getParam('id', 0);
        $faq     = Mage::getModel('sumankcdotcom_faq/faq')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($faqId);
        if (!$faq->getId()) {
            return false;
        } elseif (!$faq->getStatus()) {
            return false;
        }
        return $faq;
    }

    /**
     * view faq action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function viewAction()
    {
        $faq = $this->_initFaq();
        if (!$faq) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_faq', $faq);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('faq-faq faq-faq' . $faq->getId());
        }
        if (Mage::helper('sumankcdotcom_faq/faq')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('sumankcdotcom_faq')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'faqs',
                    array(
                        'label' => Mage::helper('sumankcdotcom_faq')->__('Faqs'),
                        'link'  => Mage::helper('sumankcdotcom_faq/faq')->getFaqsUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'faq',
                    array(
                        'label' => $faq->getQuestion(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $faq->getFaqUrl());
        }
        $this->renderLayout();
    }
}
