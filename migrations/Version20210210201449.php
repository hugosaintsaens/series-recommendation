<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210201449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contains (id INT AUTO_INCREMENT NOT NULL, series_id INT NOT NULL, words_id INT NOT NULL, appearance DOUBLE PRECISION NOT NULL, INDEX IDX_8EFA6A7E5278319C (series_id), INDEX IDX_8EFA6A7E749B15FB (words_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, series_id INT NOT NULL, favorite TINYINT(1) NOT NULL, counter SMALLINT DEFAULT NULL, INDEX IDX_49CA4E7D67B3B43D (users_id), INDEX IDX_49CA4E7D5278319C (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_3A10012D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_1483A5E95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE words (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_717D1E8CA4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7E5278319C FOREIGN KEY (series_id) REFERENCES series (id)');
        $this->addSql('ALTER TABLE contains ADD CONSTRAINT FK_8EFA6A7E749B15FB FOREIGN KEY (words_id) REFERENCES words (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D5278319C FOREIGN KEY (series_id) REFERENCES series (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7E5278319C');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D5278319C');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D67B3B43D');
        $this->addSql('ALTER TABLE contains DROP FOREIGN KEY FK_8EFA6A7E749B15FB');
        $this->addSql('DROP TABLE contains');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE series');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE words');
    }
}
