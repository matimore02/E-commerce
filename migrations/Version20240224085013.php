<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224085013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, panier_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E0E9118A76ED395 (user_id), INDEX IDX_6E0E9118F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, pays_id INT NOT NULL, user_id INT NOT NULL, ville_adr VARCHAR(255) DEFAULT NULL, cp_adr INT NOT NULL, complement_adr VARCHAR(255) DEFAULT NULL, rue_adr VARCHAR(255) NOT NULL, INDEX IDX_C35F0816A6E44244 (pays_id), INDEX IDX_C35F0816A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cat_produit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commenter (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT NOT NULL, commentaire VARCHAR(1000) NOT NULL, date_commentaire DATETIME NOT NULL, INDEX IDX_AB751D0AA76ED395 (user_id), INDEX IDX_AB751D0AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_987306D8F77D927C (panier_id), INDEX IDX_987306D8F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noter (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, note VARCHAR(255) NOT NULL, INDEX IDX_761C961AA76ED395 (user_id), INDEX IDX_761C961AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, etat_id INT DEFAULT NULL, INDEX IDX_24CC0DF2A76ED395 (user_id), INDEX IDX_24CC0DF2D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom_pay VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, cat_id INT NOT NULL, nom_pro VARCHAR(255) NOT NULL, prix_pro INT NOT NULL, quantite_pro INT NOT NULL, img_pro VARCHAR(255) NOT NULL, description_pro VARCHAR(511) NOT NULL, INDEX IDX_29A5EC27E6ADA943 (cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, date_naissance_use DATE NOT NULL, nom_use VARCHAR(30) NOT NULL, prenom_use VARCHAR(30) NOT NULL, telephone_use INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE acheter ADD CONSTRAINT FK_6E0E9118F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE noter ADD CONSTRAINT FK_761C961AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE noter ADD CONSTRAINT FK_761C961AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat_produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118A76ED395');
        $this->addSql('ALTER TABLE acheter DROP FOREIGN KEY FK_6E0E9118F77D927C');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A6E44244');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A76ED395');
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AA76ED395');
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AF347EFB');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F77D927C');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F347EFB');
        $this->addSql('ALTER TABLE noter DROP FOREIGN KEY FK_761C961AA76ED395');
        $this->addSql('ALTER TABLE noter DROP FOREIGN KEY FK_761C961AF347EFB');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2D5E86FF');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E6ADA943');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE cat_produit');
        $this->addSql('DROP TABLE commenter');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE noter');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
