<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131084155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E0E9118A76ED395 (user_id), INDEX IDX_6E0E9118F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_987306D8F77D927C (panier_id), INDEX IDX_987306D8F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, note VARCHAR(255) NOT NULL, INDEX IDX_761C961AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, INDEX IDX_24CC0DF2A76ED395 (user_id), INDEX IDX_24CC0DF2D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE noter ADD CONSTRAINT FK_761C961AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE etat ADD libelle VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118A76ED395');
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118F77D927C');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F77D927C');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F347EFB');
        $this->addSql('ALTER TABLE noter DROP FOREIGN KEY FK_761C961AA76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2D5E86FF');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE noter');
        $this->addSql('DROP TABLE panier');
        $this->addSql('ALTER TABLE etat DROP libelle');
    }
}
