<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126140758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FB96A1CA');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2FB96A1CA');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP INDEX IDX_24CC0DF2FB96A1CA ON panier');
        $this->addSql('ALTER TABLE panier ADD id_eta_id INT DEFAULT NULL, CHANGE acheter_id id_use_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2E7900930 FOREIGN KEY (id_use_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2D90440EC FOREIGN KEY (id_eta_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2E7900930 ON panier (id_use_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2D90440EC ON panier (id_eta_id)');
        $this->addSql('DROP INDEX IDX_8D93D649FB96A1CA ON user');
        $this->addSql('ALTER TABLE user DROP acheter_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD acheter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FB96A1CA ON user (acheter_id)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2E7900930');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2D90440EC');
        $this->addSql('DROP INDEX IDX_24CC0DF2E7900930 ON panier');
        $this->addSql('DROP INDEX IDX_24CC0DF2D90440EC ON panier');
        $this->addSql('ALTER TABLE panier ADD acheter_id INT DEFAULT NULL, DROP id_use_id, DROP id_eta_id');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2FB96A1CA ON panier (acheter_id)');
    }
}
