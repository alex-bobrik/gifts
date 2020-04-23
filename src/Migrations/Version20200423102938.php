<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423102938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders ADD is_complete TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398126f525e TO IDX_E52FFDEE126F525E');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398c61a85e2 TO IDX_E52FFDEEC61A85E2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP is_complete');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdee126f525e TO IDX_F5299398126F525E');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeec61a85e2 TO IDX_F5299398C61A85E2');
    }
}
