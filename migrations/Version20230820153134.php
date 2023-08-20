<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820153134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE camera (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, full_name VARCHAR(255) NOT NULL, rover_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mrp (id INT AUTO_INCREMENT NOT NULL, sol INT NOT NULL, camera_id INT NOT NULL, img_src LONGTEXT NOT NULL, earth_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rover (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, landing_date DATE NOT NULL, launch_date DATE NOT NULL, status VARCHAR(30) NOT NULL, max_sol INT NOT NULL, max_date DATE NOT NULL, total_photos INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE camera');
        $this->addSql('DROP TABLE mrp');
        $this->addSql('DROP TABLE rover');
    }
}
