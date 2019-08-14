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
 * Faq model
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Ultimate Module Creator
 */
class Sumankcdotcom_Faq_Model_Faq extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'sumankcdotcom_faq_faq';
    const CACHE_TAG = 'sumankcdotcom_faq_faq';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sumankcdotcom_faq_faq';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'faq';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('sumankcdotcom_faq/faq');
    }

    /**
     * before save faq
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Faq
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the url to the faq details page
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getFaqUrl()
    {
        if ($this->getUrlKey()) {
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('sumankcdotcom_faq/faq/url_prefix')) {
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('sumankcdotcom_faq/faq/url_suffix')) {
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('sumankcdotcom_faq/faq/view', array('id'=>$this->getId()));
    }

    /**
     * check URL key
     *
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function checkUrlKey($urlKey, $active = true)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * get the faq Answer
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getAnswer()
    {
        $answer = $this->getData('answer');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($answer);
        return $html;
    }

    /**
     * save faq relation
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Faq
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|Sumankcdotcom_Faq_Model_Category
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getParentCategory()
    {
        if (!$this->hasData('_parent_category')) {
            if (!$this->getCategoryId()) {
                return null;
            } else {
                $category = Mage::getModel('sumankcdotcom_faq/category')
                    ->load($this->getCategoryId());
                if ($category->getId()) {
                    $this->setData('_parent_category', $category);
                } else {
                    $this->setData('_parent_category', null);
                }
            }
        }
        return $this->getData('_parent_category');
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
