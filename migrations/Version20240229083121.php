<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229083121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_to_diy (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, diy_id INT NOT NULL, INDEX IDX_8C17A0ACF347EFB (produit_id), INDEX IDX_8C17A0AC39B20AE7 (diy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_to_diy ADD CONSTRAINT FK_8C17A0ACF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit_to_diy ADD CONSTRAINT FK_8C17A0AC39B20AE7 FOREIGN KEY (diy_id) REFERENCES diy (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit_to_diy DROP FOREIGN KEY FK_8C17A0ACF347EFB');
        $this->addSql('ALTER TABLE produit_to_diy DROP FOREIGN KEY FK_8C17A0AC39B20AE7');
        $this->addSql('DROP TABLE produit_to_diy');
    }
}
