<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261117111402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la contrainte unique sur le nom des états';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF7626C6E55B5 ON etat (nom)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_55CAF7626C6E55B5 ON etat (nom)');

    }
}
