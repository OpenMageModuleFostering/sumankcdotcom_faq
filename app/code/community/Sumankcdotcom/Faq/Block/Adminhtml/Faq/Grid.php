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
 * Faq admin grid block
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Faq_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('faqGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sumankcdotcom_faq/faq')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('sumankcdotcom_faq')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'category_id',
            array(
                'header'    => Mage::helper('sumankcdotcom_faq')->__('Category'),
                'index'     => 'category_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('sumankcdotcom_faq/category_collection')
                    ->toOptionHash(),
                'renderer'  => 'sumankcdotcom_faq/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'id'    => 'getCategoryId'
                ),
                'base_link' => 'adminhtml/faq_category/edit'
            )
        );
        $this->addColumn(
            'question',
            array(
                'header'    => Mage::helper('sumankcdotcom_faq')->__('Question'),
                'align'     => 'left',
                'index'     => 'question',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('sumankcdotcom_faq')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('sumankcdotcom_faq')->__('Enabled'),
                    '0' => Mage::helper('sumankcdotcom_faq')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'url_key',
            array(
                'header' => Mage::helper('sumankcdotcom_faq')->__('URL key'),
                'index'  => 'url_key',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('sumankcdotcom_faq')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header'    => Mage::helper('sumankcdotcom_faq')->__('Updated at'),
                'index'     => 'updated_at',
                'width'     => '120px',
                'type'      => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('sumankcdotcom_faq')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('sumankcdotcom_faq')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('sumankcdotcom_faq')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sumankcdotcom_faq')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('sumankcdotcom_faq')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('faq');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('sumankcdotcom_faq')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('sumankcdotcom_faq')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('sumankcdotcom_faq')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('sumankcdotcom_faq')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('sumankcdotcom_faq')->__('Enabled'),
                            '0' => Mage::helper('sumankcdotcom_faq')->__('Disabled'),
                        )
                    )
                )
            )
        );
        $values = Mage::getResourceModel('sumankcdotcom_faq/category_collection')->toOptionHash();
        $values = array_reverse($values, true);
        $values[''] = '';
        $values = array_reverse($values, true);
        $this->getMassactionBlock()->addItem(
            'category_id',
            array(
                'label'      => Mage::helper('sumankcdotcom_faq')->__('Change Category'),
                'url'        => $this->getUrl('*/*/massCategoryId', array('_current'=>true)),
                'additional' => array(
                    'flag_category_id' => array(
                        'name'   => 'flag_category_id',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('sumankcdotcom_faq')->__('Category'),
                        'values' => $values
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Sumankcdotcom_Faq_Model_Faq
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Faq_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
