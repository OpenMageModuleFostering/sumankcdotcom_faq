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
 * Category model
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'sumankcdotcom_faq_category';
    const CACHE_TAG = 'sumankcdotcom_faq_category';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sumankcdotcom_faq_category';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'category';

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
        $this->_init('sumankcdotcom_faq/category');
    }

    /**
     * before save category
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Model_Category
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
     * get the url to the category details page
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getCategoryUrl()
    {
        if ($this->getUrlKey()) {
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('sumankcdotcom_faq/category/url_prefix')) {
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('sumankcdotcom_faq/category/url_suffix')) {
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('sumankcdotcom_faq/category/view', array('id'=>$this->getId()));
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
     * save category relation
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Category
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve  collection
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Faq_Collection
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getSelectedFaqsCollection()
    {
        if (!$this->hasData('_faq_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('sumankcdotcom_faq/faq_collection')
                        ->addFieldToFilter('category_id', $this->getId());
                $this->setData('_faq_collection', $collection);
            }
        }
        return $this->getData('_faq_collection');
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
