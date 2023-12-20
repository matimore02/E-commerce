<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220085826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD ville_adr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pays ADD nom_pay VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user ADD telephone_use INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP telephone_use');
        $this->addSql('ALTER TABLE pays DROP nom_pay');
        $this->addSql('ALTER TABLE adresse DROP ville_adr');
    }
}
