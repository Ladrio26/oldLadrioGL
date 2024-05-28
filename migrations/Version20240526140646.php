<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526140646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE jeux_joueurs DROP FOREIGN KEY FK_22BFE1E4EC2AA9D2');
        $this->addSql('ALTER TABLE jeux_joueurs DROP FOREIGN KEY FK_22BFE1E4A3DC7281');
        $this->addSql('ALTER TABLE llan DROP FOREIGN KEY FK_C795B35A8C9E392E');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE joueurs');
        $this->addSql('DROP TABLE jeux_joueurs');
        $this->addSql('DROP TABLE llan');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, llan INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, llan INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE jeux_joueurs (jeux_id INT NOT NULL, joueurs_id INT NOT NULL, INDEX IDX_22BFE1E4EC2AA9D2 (jeux_id), INDEX IDX_22BFE1E4A3DC7281 (joueurs_id), PRIMARY KEY(jeux_id, joueurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE llan (id INT AUTO_INCREMENT NOT NULL, value INT NOT NULL, jeu_id INT DEFAULT NULL, INDEX IDX_C795B35A8C9E392E (jeu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE jeux_joueurs ADD CONSTRAINT FK_22BFE1E4EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_joueurs ADD CONSTRAINT FK_22BFE1E4A3DC7281 FOREIGN KEY (joueurs_id) REFERENCES joueurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE llan ADD CONSTRAINT FK_C795B35A8C9E392E FOREIGN KEY (jeu_id) REFERENCES jeux (id)');
        $this->addSql('DROP TABLE user');
    }
}
