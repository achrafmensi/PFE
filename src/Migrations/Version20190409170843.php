<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190409170843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, consultant_id INT DEFAULT NULL, chefdeprojet_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, datedebut DATE NOT NULL, datefinprevue DATE NOT NULL, datefinreel DATE DEFAULT NULL, nature VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_93872075C18272 (projet_id), INDEX IDX_9387207544F779A2 (consultant_id), INDEX IDX_93872075DEACA195 (chefdeprojet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207544F779A2 FOREIGN KEY (consultant_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075DEACA195 FOREIGN KEY (chefdeprojet_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tache');
    }
}
