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
 * Category Faqs list block
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Category_Faq_List extends Sumankcdotcom_Faq_Block_Faq_List
{
    /**
     * initialize
     *
     * @access public
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function __construct()
    {
        parent::__construct();
        $category = $this->getCategory();
        if ($category) {
            $this->getFaqs()->addFieldToFilter('category_id', $category->getId());
        }
    }

    /**
     * prepare the layout - actually do nothing
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Category_Faq_List
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareLayout()
    {
        return $this;
    }

    /**
     * get the current category
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Category
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getCategory()
    {
        return Mage::registry('current_category');
    }
}
