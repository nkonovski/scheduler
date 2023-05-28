<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528160055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEA76ED395 ON project (user_id)');
        $this->addSql('ALTER TABLE timer ADD project_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE timer ADD CONSTRAINT FK_6AD0DE1A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE timer ADD CONSTRAINT FK_6AD0DE1AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6AD0DE1A166D1F9C ON timer (project_id)');
        $this->addSql('CREATE INDEX IDX_6AD0DE1AA76ED395 ON timer (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('DROP INDEX IDX_2FB3D0EEA76ED395 ON project');
        $this->addSql('ALTER TABLE project DROP user_id');
        $this->addSql('ALTER TABLE timer DROP FOREIGN KEY FK_6AD0DE1A166D1F9C');
        $this->addSql('ALTER TABLE timer DROP FOREIGN KEY FK_6AD0DE1AA76ED395');
        $this->addSql('DROP INDEX IDX_6AD0DE1A166D1F9C ON timer');
        $this->addSql('DROP INDEX IDX_6AD0DE1AA76ED395 ON timer');
        $this->addSql('ALTER TABLE timer DROP project_id, DROP user_id');
    }
}
