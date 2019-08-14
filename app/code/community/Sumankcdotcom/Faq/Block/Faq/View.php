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
 * Faq view block
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Faq_View extends Mage_Core_Block_Template
{
    /**
     * get the current faq
     *
     * @access public
     * @return mixed (Sumankcdotcom_Faq_Model_Faq|null)
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getCurrentFaq()
    {
        return Mage::registry('current_faq');
    }
}
