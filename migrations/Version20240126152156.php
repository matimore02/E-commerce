<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126152156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, id_use_id INT DEFAULT NULL, id_pan_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E0E9118E7900930 (id_use_id), INDEX IDX_6E0E91187A7CDB60 (id_pan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118E7900930 FOREIGN KEY (id_use_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E91187A7CDB60 FOREIGN KEY (id_pan_id) REFERENCES panier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118E7900930');
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E91187A7CDB60');
        $this->addSql('DROP TABLE acheter');
    }
}
