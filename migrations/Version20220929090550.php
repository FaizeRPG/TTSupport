<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220929090550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jdr DROP FOREIGN KEY FK_59B2957F1849495');
        $this->addSql('DROP INDEX IDX_59B2957F1849495 ON jdr');
        $this->addSql('ALTER TABLE jdr DROP players_id');
        $this->addSql('ALTER TABLE jdr_player ADD jdr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jdr_player ADD CONSTRAINT FK_36F3F8122C292827 FOREIGN KEY (jdr_id) REFERENCES jdr (id)');
        $this->addSql('CREATE INDEX IDX_36F3F8122C292827 ON jdr_player (jdr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jdr_player DROP FOREIGN KEY FK_36F3F8122C292827');
        $this->addSql('DROP INDEX IDX_36F3F8122C292827 ON jdr_player');
        $this->addSql('ALTER TABLE jdr_player DROP jdr_id');
        $this->addSql('ALTER TABLE jdr ADD players_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jdr ADD CONSTRAINT FK_59B2957F1849495 FOREIGN KEY (players_id) REFERENCES jdr_player (id)');
        $this->addSql('CREATE INDEX IDX_59B2957F1849495 ON jdr (players_id)');
    }
}
