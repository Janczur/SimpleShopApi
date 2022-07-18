<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718154741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE research (uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', category_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, code INT NOT NULL, icd_code VARCHAR(7) NOT NULL, UNIQUE INDEX search_idx (slug, category_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE research');
    }
}
