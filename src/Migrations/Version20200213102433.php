<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213102433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, etape_id_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, coordinates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, type_transport VARCHAR(255) NOT NULL, INDEX IDX_B8755515CFDE1A29 (etape_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, voyage_id_id INT NOT NULL, message LONGTEXT NOT NULL, date_publication DATETIME NOT NULL, INDEX IDX_D9BEC0C49D86650F (user_id_id), INDEX IDX_D9BEC0C475D4A2B8 (voyage_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, voyage_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) DEFAULT NULL, coordinates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, photo VARCHAR(255) DEFAULT NULL, budget DOUBLE PRECISION DEFAULT NULL, INDEX IDX_285F75DD75D4A2B8 (voyage_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, photo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_voyage (user_id INT NOT NULL, voyage_id INT NOT NULL, INDEX IDX_5ACF9268A76ED395 (user_id), INDEX IDX_5ACF926868C9E5AF (voyage_id), PRIMARY KEY(user_id, voyage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, budget DOUBLE PRECISION DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, date_publication DATETIME DEFAULT NULL, priorite INT DEFAULT NULL, is_deleted TINYINT(1) NOT NULL, is_public TINYINT(1) NOT NULL, INDEX IDX_3F9D89559D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515CFDE1A29 FOREIGN KEY (etape_id_id) REFERENCES etape (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C475D4A2B8 FOREIGN KEY (voyage_id_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD75D4A2B8 FOREIGN KEY (voyage_id_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_voyage ADD CONSTRAINT FK_5ACF9268A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_voyage ADD CONSTRAINT FK_5ACF926868C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D89559D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515CFDE1A29');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C49D86650F');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('ALTER TABLE user_voyage DROP FOREIGN KEY FK_5ACF9268A76ED395');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D89559D86650F');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C475D4A2B8');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD75D4A2B8');
        $this->addSql('ALTER TABLE user_voyage DROP FOREIGN KEY FK_5ACF926868C9E5AF');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE user_voyage');
        $this->addSql('DROP TABLE voyage');
    }
}
