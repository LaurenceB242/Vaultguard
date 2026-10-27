<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261027155340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE credential (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, encrypted_password LONGTEXT NOT NULL, strength_score INT NOT NULL, user_id INT NOT NULL, INDEX IDX_57F1D4BA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE credential ADD CONSTRAINT FK_57F1D4BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credential DROP FOREIGN KEY FK_57F1D4BA76ED395');
        $this->addSql('DROP TABLE credential');
    }
}
