<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217210913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses ADD work_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4CBB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4CBB3453DB ON courses (work_id)');
        $this->addSql('ALTER TABLE user ADD work_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BB3453DB ON user (work_id)');
        $this->addSql('ALTER TABLE work ADD course VARCHAR(255) NOT NULL, ADD added_by VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4CBB3453DB');
        $this->addSql('DROP INDEX IDX_A9A55A4CBB3453DB ON courses');
        $this->addSql('ALTER TABLE courses DROP work_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BB3453DB');
        $this->addSql('DROP INDEX IDX_8D93D649BB3453DB ON user');
        $this->addSql('ALTER TABLE user DROP work_id');
        $this->addSql('ALTER TABLE work DROP course, DROP added_by');
    }
}
