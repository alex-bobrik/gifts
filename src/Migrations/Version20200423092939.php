<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423092939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, order_kind_id INT DEFAULT NULL, order_date DATETIME DEFAULT NULL, phone_num VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, is_delivery TINYINT(1) DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, INDEX IDX_F5299398126F525E (item_id), INDEX IDX_F5299398C61A85E2 (order_kind_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_kind (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C61A85E2 FOREIGN KEY (order_kind_id) REFERENCES order_kind (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C61A85E2');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_kind');
    }
}
