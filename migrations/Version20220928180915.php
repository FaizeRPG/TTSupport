<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928180915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jdr (id INT AUTO_INCREMENT NOT NULL, admin_id INT NOT NULL, players_id INT DEFAULT NULL, name VARCHAR(31) NOT NULL, date_add DATETIME NOT NULL, date_upd DATETIME NOT NULL, INDEX IDX_59B2957642B8210 (admin_id), INDEX IDX_59B2957F1849495 (players_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jdr_player (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(15) NOT NULL, picture VARCHAR(255) DEFAULT NULL, dices VARCHAR(255) DEFAULT NULL, dice_count INT NOT NULL, token VARCHAR(10) DEFAULT NULL, result VARCHAR(255) DEFAULT NULL, date_add DATETIME NOT NULL, date_upd DATETIME NOT NULL, INDEX IDX_36F3F8127E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jdr ADD CONSTRAINT FK_59B2957642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE jdr ADD CONSTRAINT FK_59B2957F1849495 FOREIGN KEY (players_id) REFERENCES jdr_player (id)');
        $this->addSql('ALTER TABLE jdr_player ADD CONSTRAINT FK_36F3F8127E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jdr DROP FOREIGN KEY FK_59B2957642B8210');
        $this->addSql('ALTER TABLE jdr DROP FOREIGN KEY FK_59B2957F1849495');
        $this->addSql('ALTER TABLE jdr_player DROP FOREIGN KEY FK_36F3F8127E3C61F9');
        $this->addSql('DROP TABLE jdr');
        $this->addSql('DROP TABLE jdr_player');
    }
}
