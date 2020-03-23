<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200310095223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('CREATE TABLE tag_kind (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//        $this->addSql('ALTER TABLE tag ADD tag_kind_id INT DEFAULT NULL');
//        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7832510103 FOREIGN KEY (tag_kind_id) REFERENCES tag_kind (id)');
//        $this->addSql('CREATE INDEX IDX_389B7832510103 ON tag (tag_kind_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7832510103');
        $this->addSql('DROP TABLE tag_kind');
        $this->addSql('DROP INDEX IDX_389B7832510103 ON tag');
        $this->addSql('ALTER TABLE tag DROP tag_kind_id');
    }
}
