<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219111154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE playlist_song (playlist_id INT NOT NULL, song_id INT NOT NULL, INDEX IDX_93F4D9C36BBD148 (playlist_id), INDEX IDX_93F4D9C3A0BDB2F3 (song_id), PRIMARY KEY(playlist_id, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, song_id INT DEFAULT NULL, album_id INT DEFAULT NULL, INDEX IDX_5D69B053A76ED395 (user_id), INDEX IDX_5D69B053A0BDB2F3 (song_id), INDEX IDX_5D69B0531137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C36BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C3A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B0531137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album ADD artist_id INT DEFAULT NULL, ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E434296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_39986E43B7970CF8 ON album (artist_id)');
        $this->addSql('CREATE INDEX IDX_39986E434296D31F ON album (genre_id)');
        $this->addSql('ALTER TABLE playlist ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D782112DA76ED395 ON playlist (user_id)');
        $this->addSql('ALTER TABLE user ADD playlist VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C36BBD148');
        $this->addSql('ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C3A0BDB2F3');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053A76ED395');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053A0BDB2F3');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B0531137ABCF');
        $this->addSql('DROP TABLE playlist_song');
        $this->addSql('DROP TABLE preference');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E434296D31F');
        $this->addSql('DROP INDEX IDX_39986E43B7970CF8 ON album');
        $this->addSql('DROP INDEX IDX_39986E434296D31F ON album');
        $this->addSql('ALTER TABLE album DROP artist_id, DROP genre_id');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('DROP INDEX IDX_D782112DA76ED395 ON playlist');
        $this->addSql('ALTER TABLE playlist DROP user_id');
        $this->addSql('ALTER TABLE user DROP playlist');
    }
}
