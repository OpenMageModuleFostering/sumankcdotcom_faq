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
 * Faq admin edit tabs
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Faq_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sumankcdotcom_faq')->__('Faq'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Edit_Tabs
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_faq',
            array(
                'label'   => Mage::helper('sumankcdotcom_faq')->__('Faq'),
                'title'   => Mage::helper('sumankcdotcom_faq')->__('Faq'),
                'content' => $this->getLayout()->createBlock(
                    'sumankcdotcom_faq/adminhtml_faq_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve faq entity
     *
     * @access public
     * @return Sumankcdotcom_Faq_Model_Faq
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getFaq()
    {
        return Mage::registry('current_faq');
    }
}
