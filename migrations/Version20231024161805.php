<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024161805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lists_items (lists_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_FAEB94179D26499B (lists_id), INDEX IDX_FAEB94176BB0AE84 (items_id), PRIMARY KEY(lists_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lists_items ADD CONSTRAINT FK_FAEB94179D26499B FOREIGN KEY (lists_id) REFERENCES lists (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lists_items ADD CONSTRAINT FK_FAEB94176BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lists_items DROP FOREIGN KEY FK_FAEB94179D26499B');
        $this->addSql('ALTER TABLE lists_items DROP FOREIGN KEY FK_FAEB94176BB0AE84');
        $this->addSql('DROP TABLE lists_items');
    }
}
