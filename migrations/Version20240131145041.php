<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131145041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commenter ADD user_id INT NOT NULL, ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_AB751D0AA76ED395 ON commenter (user_id)');
        $this->addSql('CREATE INDEX IDX_AB751D0AF347EFB ON commenter (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AA76ED395');
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0AF347EFB');
        $this->addSql('DROP INDEX IDX_AB751D0AA76ED395 ON commenter');
        $this->addSql('DROP INDEX IDX_AB751D0AF347EFB ON commenter');
        $this->addSql('ALTER TABLE commenter DROP user_id, DROP produit_id');
    }
}
