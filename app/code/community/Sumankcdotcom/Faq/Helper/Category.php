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
 * Category helper
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Helper_Category extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the categories list page
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getCategoriesUrl()
    {
        if ($listKey = Mage::getStoreConfig('sumankcdotcom_faq/category/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('sumankcdotcom_faq/category/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('sumankcdotcom_faq/category/breadcrumbs');
    }
}
