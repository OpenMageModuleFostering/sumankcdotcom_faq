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
 * Category admin edit form
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'sumankcdotcom_faq';
        $this->_controller = 'adminhtml_category';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('sumankcdotcom_faq')->__('Save Category')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('sumankcdotcom_faq')->__('Delete Category')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('sumankcdotcom_faq')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_category') && Mage::registry('current_category')->getId()) {
            return Mage::helper('sumankcdotcom_faq')->__(
                "Edit Category '%s'",
                $this->escapeHtml(Mage::registry('current_category')->getCategories())
            );
        } else {
            return Mage::helper('sumankcdotcom_faq')->__('Add Category');
        }
    }
}
