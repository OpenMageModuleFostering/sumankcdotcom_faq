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
 * Faq collection resource model
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Model_Resource_Faq_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_joinedFields = array();

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('sumankcdotcom_faq/faq');
    }

    /**
     * get faqs as array
     *
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='question', $additional=array())
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }

    /**
     * get options hash
     *
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @return array
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _toOptionHash($valueField='entity_id', $labelField='question')
    {
        return parent::_toOptionHash($valueField, $labelField);
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @access public
     * @return Varien_Db_Select
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
