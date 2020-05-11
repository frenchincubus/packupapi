<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511065037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image_voyage (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voyage ADD photo_id INT DEFAULT NULL, DROP photo');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D89557E9E4C8C FOREIGN KEY (photo_id) REFERENCES image_voyage (id)');
        $this->addSql('CREATE INDEX IDX_3F9D89557E9E4C8C ON voyage (photo_id)');
        $this->addSql('ALTER TABLE etape ADD photo_id INT DEFAULT NULL, DROP photo');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD7E9E4C8C FOREIGN KEY (photo_id) REFERENCES image_voyage (id)');
        $this->addSql('CREATE INDEX IDX_285F75DD7E9E4C8C ON etape (photo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D89557E9E4C8C');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD7E9E4C8C');
        $this->addSql('DROP TABLE image_voyage');
        $this->addSql('DROP INDEX IDX_285F75DD7E9E4C8C ON etape');
        $this->addSql('ALTER TABLE etape ADD photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP photo_id');
        $this->addSql('DROP INDEX IDX_3F9D89557E9E4C8C ON voyage');
        $this->addSql('ALTER TABLE voyage ADD photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP photo_id');
    }
}
