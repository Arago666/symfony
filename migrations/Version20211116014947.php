<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211116014947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблиц movie, movie_session, ticket';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE movie (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                name VARCHAR(255) NOT NULL, 
                duration_in_minutes INT NOT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE movie_session (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                movie_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                start_time DATETIME NOT NULL, 
                quantity_tickets INT NOT NULL, 
                INDEX IDX_F0D297FA8F93B6FC (movie_id), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE ticket (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                movie_session_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
                first_name VARCHAR(100) NOT NULL, 
                phone VARCHAR(30) NOT NULL, INDEX IDX_97A0ADA388CF9CE3 (movie_session_id), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE movie_session ADD CONSTRAINT FK_F0D297FA8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA388CF9CE3 FOREIGN KEY (movie_session_id) REFERENCES movie_session (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movie_session DROP FOREIGN KEY FK_F0D297FA8F93B6FC');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA388CF9CE3');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_session');
        $this->addSql('DROP TABLE ticket');
    }
}
