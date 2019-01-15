<?php

namespace Sintra\POEmailAttachment\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
/**
 * Class InstallSchema
 * @package Sintra\POEmailAttachment\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        //Creating a custom table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('sintra_po_attachment')
        )->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            100,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity id'
        )->addColumn(
            'url',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Title'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Create date'
        )->addColumn(
            'quote_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Entity id'
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Entity id'
        )->addForeignKey(
            $installer->getFkName(
                'sintra_po_attachment',
                'quote_id',
                'quote',
                'entity_id'
            ),
            'quote_id',
            $installer->getTable('quote'),
            'entity_id',
            Table::ACTION_SET_NULL
        )->addForeignKey(
            $installer->getFkName(
                'sintra_po_attachment',
                'order_id',
                'sales_order',
                'entity_id'
            ),
            'order_id',
            $installer->getTable('sales_order'),
            'entity_id',
            Table::ACTION_SET_NULL
        )->setComment(
            'Sintra_POEmailAttachment table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
