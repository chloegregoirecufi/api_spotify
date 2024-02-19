<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219153225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_user (album_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E99860091137ABCF (album_id), INDEX IDX_E9986009A76ED395 (user_id), PRIMARY KEY(album_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE album_user ADD CONSTRAINT FK_E99860091137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_user ADD CONSTRAINT FK_E9986009A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_user DROP FOREIGN KEY FK_E99860091137ABCF');
        $this->addSql('ALTER TABLE album_user DROP FOREIGN KEY FK_E9986009A76ED395');
        $this->addSql('DROP TABLE album_user');
    }
}
