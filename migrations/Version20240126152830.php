<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126152830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, id_pan_id INT DEFAULT NULL, id_pro_id INT DEFAULT NULL, quantité INT NOT NULL, INDEX IDX_987306D87A7CDB60 (id_pan_id), INDEX IDX_987306D8E5805157 (id_pro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D87A7CDB60 FOREIGN KEY (id_pan_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8E5805157 FOREIGN KEY (id_pro_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D87A7CDB60');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8E5805157');
        $this->addSql('DROP TABLE composer');
    }
}
