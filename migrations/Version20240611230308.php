<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611230308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE llan_registration (id INT AUTO_INCREMENT NOT NULL, is_alone TINYINT(1) NOT NULL, user_id INT NOT NULL, team_id INT DEFAULT NULL, INDEX IDX_3A755783A76ED395 (user_id), UNIQUE INDEX UNIQ_3A755783296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tag VARCHAR(3) NOT NULL, creator_id INT NOT NULL, partner_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C4E0A61F61220EA6 (creator_id), UNIQUE INDEX UNIQ_C4E0A61F9393F8FE (partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE llan_registration ADD CONSTRAINT FK_3A755783A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE llan_registration ADD CONSTRAINT FK_3A755783296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F9393F8FE FOREIGN KEY (partner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE llan_registration DROP FOREIGN KEY FK_3A755783A76ED395');
        $this->addSql('ALTER TABLE llan_registration DROP FOREIGN KEY FK_3A755783296CD8AE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F61220EA6');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F9393F8FE');
        $this->addSql('DROP TABLE llan_registration');
        $this->addSql('DROP TABLE team');
    }
}
