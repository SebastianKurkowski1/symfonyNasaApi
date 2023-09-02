<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902105551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mrp CHANGE id id VARCHAR(255) NOT NULL, CHANGE camera_id camera_id INT DEFAULT NULL, CHANGE img_src img_src LONGTEXT DEFAULT NULL, CHANGE earth_date earth_date DATE DEFAULT NULL, CHANGE rover_id rover_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mrp CHANGE id id INT NOT NULL, CHANGE camera_id camera_id INT NOT NULL, CHANGE img_src img_src LONGTEXT NOT NULL, CHANGE earth_date earth_date DATE NOT NULL, CHANGE rover_id rover_id INT NOT NULL');
    }
}
