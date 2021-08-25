<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824212351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE git (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, repository_name VARCHAR(255) NOT NULL, base_url VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, last_scan_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', members LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', api_id INT DEFAULT NULL, branch VARCHAR(255) DEFAULT NULL, full_url VARCHAR(255) DEFAULT NULL, access_token VARCHAR(255) DEFAULT NULL, last_pipeline_status LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_518E617C166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE git ADD CONSTRAINT FK_518E617C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE git');
    }
}
