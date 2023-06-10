<?php

declare(strict_types=1);

namespace Hutech\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610091729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        # product table
        $product = $schema->createTable('product');
        $product->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $product->addColumn('name', Types::STRING, ['length' => 255]);
        $product->addColumn('price', Types::DECIMAL, ['precision' => 10, 'scale' => 2]);
        $product->addColumn('image', Types::STRING, ['length' => 255]);
        $product->addColumn('description', Types::STRING, ['length' => 255]);
        $product->addColumn('category_id', Types::INTEGER);
        $product->setPrimaryKey(['id']);

        # category table
        $category = $schema->createTable('category');
        $category->addColumn('id', Types::INTEGER, ['autoincrement' => true]);
        $category->addColumn('name', Types::STRING, ['length' => 255]);
        $category->setPrimaryKey(['id']);

        # foreign key
        $product->addForeignKeyConstraint('category', ['category_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('product');
        $schema->dropTable('category');
    }
}
