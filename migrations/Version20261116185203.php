<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261116185203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF453C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4BCF5E72D');
    $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4D5E86FF');
    $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF453C59D72');
    $this->addSql('DROP TABLE responsable');
    }
}
