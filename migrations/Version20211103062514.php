<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103062514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, phone VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, duration_in_minutes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_session (id VARCHAR(100) NOT NULL, movie_id VARCHAR(100) NOT NULL, tickets_id VARCHAR(100) DEFAULT NULL, start_time DATETIME NOT NULL, quantity_tickets INT NOT NULL, INDEX IDX_F0D297FA8F93B6FC (movie_id), INDEX IDX_F0D297FA8FDC0E9A (tickets_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_session ADD CONSTRAINT FK_F0D297FA8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE movie_session ADD CONSTRAINT FK_F0D297FA8FDC0E9A FOREIGN KEY (tickets_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_session DROP FOREIGN KEY FK_F0D297FA8FDC0E9A');
        $this->addSql('ALTER TABLE movie_session DROP FOREIGN KEY FK_F0D297FA8F93B6FC');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_session');
    }
}
