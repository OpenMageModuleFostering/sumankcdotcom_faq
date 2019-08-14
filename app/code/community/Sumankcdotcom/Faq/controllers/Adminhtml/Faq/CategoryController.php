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
 * Category admin controller
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Adminhtml_Faq_CategoryController extends Sumankcdotcom_Faq_Controller_Adminhtml_Faq
{
    /**
     * init the category
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Category
     */
    protected function _initCategory()
    {
        $categoryId  = (int) $this->getRequest()->getParam('id');
        $category    = Mage::getModel('sumankcdotcom_faq/category');
        if ($categoryId) {
            $category->load($categoryId);
        }
        Mage::register('current_category', $category);
        return $category;
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
             ->_title(Mage::helper('sumankcdotcom_faq')->__('Categories'));
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
     * edit category - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function editAction()
    {
        $categoryId    = $this->getRequest()->getParam('id');
        $category      = $this->_initCategory();
        if ($categoryId && !$category->getId()) {
            $this->_getSession()->addError(
                Mage::helper('sumankcdotcom_faq')->__('This category no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCategoryData(true);
        if (!empty($data)) {
            $category->setData($data);
        }
        Mage::register('category_data', $category);
        $this->loadLayout();
        $this->_title(Mage::helper('sumankcdotcom_faq')->__('FAQ'))
             ->_title(Mage::helper('sumankcdotcom_faq')->__('Categories'));
        if ($category->getId()) {
            $this->_title($category->getCategories());
        } else {
            $this->_title(Mage::helper('sumankcdotcom_faq')->__('Add category'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new category action
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
     * save category - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('category')) {
            try {
                $category = $this->_initCategory();
                $category->addData($data);
                $category->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Category was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $category->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCategoryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was a problem saving the category.')
                );
                Mage::getSingleton('adminhtml/session')->setCategoryData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('sumankcdotcom_faq')->__('Unable to find category to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete category - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $category = Mage::getModel('sumankcdotcom_faq/category');
                $category->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Category was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error deleting category.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('sumankcdotcom_faq')->__('Could not find category to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete category - action
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function massDeleteAction()
    {
        $categoryIds = $this->getRequest()->getParam('category');
        if (!is_array($categoryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('sumankcdotcom_faq')->__('Please select categories to delete.')
            );
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                    $category = Mage::getModel('sumankcdotcom_faq/category');
                    $category->setId($categoryId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('sumankcdotcom_faq')->__('Total of %d categories were successfully deleted.', count($categoryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error deleting categories.')
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
        $categoryIds = $this->getRequest()->getParam('category');
        if (!is_array($categoryIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('sumankcdotcom_faq')->__('Please select categories.')
            );
        } else {
            try {
                foreach ($categoryIds as $categoryId) {
                $category = Mage::getSingleton('sumankcdotcom_faq/category')->load($categoryId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d categories were successfully updated.', count($categoryIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sumankcdotcom_faq')->__('There was an error updating categories.')
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
        $fileName   = 'category.csv';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_category_grid')
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
        $fileName   = 'category.xls';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_category_grid')
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
        $fileName   = 'category.xml';
        $content    = $this->getLayout()->createBlock('sumankcdotcom_faq/adminhtml_category_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('sumankcdotcom_faq/category');
    }
}
