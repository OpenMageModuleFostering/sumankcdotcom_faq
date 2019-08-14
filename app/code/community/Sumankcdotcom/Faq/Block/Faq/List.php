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
 * Faq list block
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Faq_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function _construct()
    {
        parent::_construct();
        $faqs = Mage::getResourceModel('sumankcdotcom_faq/faq_collection')
                         ->addFieldToFilter('status', 1);
        $faqs->setOrder('question', 'asc');
        $this->setFaqs($faqs);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Faq_List
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'sumankcdotcom_faq.faq.html.pager'
        )
        ->setCollection($this->getFaqs());
        $this->setChild('pager', $pager);
        $this->getFaqs()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
