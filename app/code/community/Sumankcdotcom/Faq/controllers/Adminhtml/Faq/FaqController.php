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
 * Faq admin controller
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Adminhtml_Faq_FaqController extends Sumankcdotcom_Faq_Controller_Adminhtml_Faq
{
    /**
     * init the faq
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Faq
     */
    protected function _initFaq()
    {
        $faqId  = (int) $this->getRequest()->getParam('id');
        $faq    = Mage::getModel('sumankcdotcom_faq/faq');
        if ($faqId) {
            $faq->load($faqId);
        }
        Mage::register('current_faq', $faq);
        return $faq;
    }

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
        $this->_title(Mage::helper('sumankcdotcom_faq')->__('FAQ'))
             ->_title(Mage::helper('sumankcdotcom_faq')->__('Faqs'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit faq - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function editAction()
    {
        $faqId    = $this->getRequest()->getParam('id');
        $faq      = $this->_initFaq();
        if ($faqId && !$faq->getId()) {
            $this->_getSession()->addError(
                Mage::helper('sumankcdotcom_faq')->__('This faq no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getFaqData(true);
        if (!empty($data)) {
            $faq->setData($data);
        }
        Mage::register('faq_data', $faq);
        $this->loadLayout();
        $this->_title(Mage::helper('sumankcdotcom_faq')->__('FAQ'))
             ->_title(Mage::helper('sumankcdotcom_faq')->__('Faqs'));
        if ($faq->getId()) {
            $this->_title($faq->getQuestion());
        } else {
            $this->_title(Mage::helper('sumankcdotcom_faq')->__('Add faq'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new faq action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save faq - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('faq')) {
            try {
                $faq = $this->_initFaq();
                $faq->addData($data);
                $faq->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Faq was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $faq->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFaqData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was a problem saving the faq.')
                );
                Mage::getSingleton('adminhtml/session')->setFaqData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('sumankcdotcom_faq')->__('Unable to find faq to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete faq - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $faq = Mage::getModel('sumankcdotcom_faq/faq');
                $faq->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Faq was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error deleting faq.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('sumankcdotcom_faq')->__('Could not find faq to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete faq - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function massDeleteAction()
    {
        $faqIds = $this->getRequest()->getParam('faq');
        if (!is_array($faqIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('sumankcdotcom_faq')->__('Please select faqs to delete.')
            );
        } else {
            try {
                foreach ($faqIds as $faqId) {
                    $faq = Mage::getModel('sumankcdotcom_faq/faq');
                    $faq->setId($faqId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Total of %d faqs were successfully deleted.', count($faqIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error deleting faqs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function massStatusAction()
    {
        $faqIds = $this->getRequest()->getParam('faq');
        if (!is_array($faqIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('sumankcdotcom_faq')->__('Please select faqs.')
            );
        } else {
            try {
                foreach ($faqIds as $faqId) {
                $faq = Mage::getSingleton('sumankcdotcom_faq/faq')->load($faqId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d faqs were successfully updated.', count($faqIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error updating faqs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass category change - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function massCategoryIdAction()
    {
        $faqIds = $this->getRequest()->getParam('faq');
        if (!is_array($faqIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('sumankcdotcom_faq')->__('Please select faqs.')
            );
        } else {
            try {
                foreach ($faqIds as $faqId) {
                $faq = Mage::getSingleton('sumankcdotcom_faq/faq')->load($faqId)
                    ->setCategoryId($this->getRequest()->getParam('flag_category_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d faqs were successfully updated.', count($faqIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error updating faqs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function exportCsvAction()
    {
        $fileName   = 'faq.csv';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_faq_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function exportExcelAction()
    {
        $fileName   = 'faq.xls';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_faq_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function exportXmlAction()
    {
        $fileName   = 'faq.xml';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_faq_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sumankcdotcom_faq/faq');
    }
}
