<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524174747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, jeu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, llan INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE jeux_joueurs (jeux_id INT NOT NULL, joueurs_id INT NOT NULL, INDEX IDX_22BFE1E4EC2AA9D2 (jeux_id), INDEX IDX_22BFE1E4A3DC7281 (joueurs_id), PRIMARY KEY(jeux_id, joueurs_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(32) NOT NULL, llan INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE llan (id INT AUTO_INCREMENT NOT NULL, value INT NOT NULL, jeu_id INT DEFAULT NULL, INDEX IDX_C795B35A8C9E392E (jeu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE jeux_joueurs ADD CONSTRAINT FK_22BFE1E4EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_joueurs ADD CONSTRAINT FK_22BFE1E4A3DC7281 FOREIGN KEY (joueurs_id) REFERENCES joueurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE llan ADD CONSTRAINT FK_C795B35A8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux_joueurs DROP FOREIGN KEY FK_22BFE1E4EC2AA9D2');
        $this->addSql('ALTER TABLE jeux_joueurs DROP FOREIGN KEY FK_22BFE1E4A3DC7281');
        $this->addSql('ALTER TABLE llan DROP FOREIGN KEY FK_C795B35A8C9E392E');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE jeux_joueurs');
        $this->addSql('DROP TABLE joueurs');
        $this->addSql('DROP TABLE llan');
    }
}
