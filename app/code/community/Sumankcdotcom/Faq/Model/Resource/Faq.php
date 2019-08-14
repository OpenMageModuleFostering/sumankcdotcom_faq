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
 * Faq resource model
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Model_Resource_Faq extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function _construct()
    {
        $this->_init('sumankcdotcom_faq/faq', 'entity_id');
    }

    /**
     * check url key
     *
     * @access public
     * @param string $urlKey
     * @param int $storeId
     * @param bool $active
     * @return mixed
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function checkUrlKey($urlKey, $storeId, $active = true)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_initCheckUrlKeySelect($urlKey, $stores);
        if ($active) {
            $select->where('e.status = ?', $active);
        }
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('e.entity_id')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    /**
     * Check for unique URL key
     *
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getIsUniqueUrlKey(Mage_Core_Model_Abstract $object)
    {
        if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        } else {
            $stores = (array)$object->getData('stores');
        }
        $select = $this->_initCheckUrlKeySelect($object->getData('url_key'), $stores);
        if ($object->getId()) {
            $select->where('e.entity_id <> ?', $object->getId());
        }
        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }
        return true;
    }

    /**
     * Check if the URL key is numeric
     *
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function isNumericUrlKey(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('url_key'));
    }

    /**
     * Check if the URL key is valid
     *
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function isValidUrlKey(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
    }

    /**
     * format string as url key
     *
     * @access public
     * @param string $str
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function formatUrlKey($str)
    {
        $urlKey = preg_replace('#[^0-9a-z]+#i', '-', Mage::helper('catalog/product_url')->format($str));
        $urlKey = strtolower($urlKey);
        $urlKey = trim($urlKey, '-');
        return $urlKey;
    }

    /**
     * init the check select
     *
     * @access protected
     * @param string $urlKey
     * @param array $store
     * @return Zend_Db_Select
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _initCheckUrlKeySelect($urlKey, $store)
    {
        $select = $this->_getReadAdapter()->select()
            ->from(array('e' => $this->getMainTable()))
            ->where('e.url_key = ?', $urlKey);
        return $select;
    }

    /**
     * validate before saving
     *
     * @access protected
     * @param $object
     * @return Sumankcdotcom_Faq_Model_Resource_Faq
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $urlKey = $object->getData('url_key');
        if ($urlKey == '') {
            $urlKey = $object->getQuestion();
        }
        $urlKey = $this->formatUrlKey($urlKey);
        $validKey = false;
        while (!$validKey) {
            $entityId = $this->checkUrlKey($urlKey, $object->getStoreId(), false);
            if ($entityId == $object->getId() || empty($entityId)) {
                $validKey = true;
            } else {
                $parts = explode('-', $urlKey);
                $last = $parts[count($parts) - 1];
                if (!is_numeric($last)) {
                    $urlKey = $urlKey.'-1';
                } else {
                    $suffix = '-'.($last + 1);
                    unset($parts[count($parts) - 1]);
                    $urlKey = implode('-', $parts).$suffix;
                }
            }
        }
        $object->setData('url_key', $urlKey);
        return parent::_beforeSave($object);
    }
}
