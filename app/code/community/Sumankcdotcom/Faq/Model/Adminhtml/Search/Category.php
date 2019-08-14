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
 * Admin search model
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Model_Adminhtml_Search_Category extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Adminhtml_Search_Category
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('sumankcdotcom_faq/category_collection')
            ->addFieldToFilter('categories', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $category) {
            $arr[] = array(
                'id'          => 'category/1/'.$category->getId(),
                'type'        => Mage::helper('sumankcdotcom_faq')->__('Category'),
                'name'        => $category->getCategories(),
                'description' => $category->getCategories(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/faq_category/edit',
                    array('id'=>$category->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
