<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907061817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images_compare (id INT AUTO_INCREMENT NOT NULL, folder_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, local_path VARCHAR(255) NOT NULL, url_to_compare VARCHAR(255) NOT NULL, local_path_to_compare VARCHAR(255) NOT NULL, INDEX IDX_22B4163F162CB942 (folder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images_compare ADD CONSTRAINT FK_22B4163F162CB942 FOREIGN KEY (folder_id) REFERENCES folders (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE images_compare');
    }
}
