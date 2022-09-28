<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928150858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP playername, DROP token, DROP result, DROP dice, DROP picture, DROP count, CHANGE username username VARCHAR(180) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD playername VARCHAR(31) DEFAULT NULL, ADD token VARCHAR(10) DEFAULT NULL, ADD result VARCHAR(255) DEFAULT NULL, ADD dice VARCHAR(255) DEFAULT NULL, ADD picture VARCHAR(255) DEFAULT NULL, ADD count INT NOT NULL, CHANGE username username VARCHAR(31) NOT NULL, CHANGE roles roles VARCHAR(63) DEFAULT NULL');
    }
}
