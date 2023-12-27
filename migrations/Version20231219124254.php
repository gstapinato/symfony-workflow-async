<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219124254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, description VARCHAR(5000) DEFAULT NULL, id_product_supplier VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, product_category_tree VARCHAR(500) DEFAULT NULL, retail_price NUMERIC(10, 2) DEFAULT NULL, discounted_price NUMERIC(10, 2) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE catalog ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN catalog.id IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE catalog ALTER id TYPE UUID');
        $this->addSql('COMMENT ON COLUMN catalog.id IS \'(DC2Type:uuid)\'');
    }
}
