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
 * Category admin grid block
 *
 * @category    Sumankcdotcom
 * @package     Sumankcdotcom_Faq
 * @author      Suman K.C [WWW.SUMANKC.COM]
 */
class Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('categoryGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sumankcdotcom_faq/category')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid
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
            'categories',
            array(
                'header'    => Mage::helper('sumankcdotcom_faq')->__('category Name'),
                'align'     => 'left',
                'index'     => 'categories',
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
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('sumankcdotcom_faq')->__('Store Views'),
                    'index'      => 'store_id',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                )
            );
        }
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
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('category');
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
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Sumankcdotcom_Faq_Model_Category
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
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     *
     * @access protected
     * @param Sumankcdotcom_Faq_Model_Resource_Category_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Sumankcdotcom_Faq_Block_Adminhtml_Category_Grid
     * @author Suman K.C [WWW.SUMANKC.COM]
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
