<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190513022642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE notifiable_entity (id INT AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifiable_notification (id INT AUTO_INCREMENT NOT NULL, notification_id INT DEFAULT NULL, notifiable_entity_id INT DEFAULT NULL, seen TINYINT(1) NOT NULL, INDEX IDX_ADCFE0FAEF1A9D84 (notification_id), INDEX IDX_ADCFE0FAC3A0A4F8 (notifiable_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, subject VARCHAR(4000) NOT NULL, message VARCHAR(4000) DEFAULT NULL, link VARCHAR(4000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notifiable_notification ADD CONSTRAINT FK_ADCFE0FAEF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE notifiable_notification ADD CONSTRAINT FK_ADCFE0FAC3A0A4F8 FOREIGN KEY (notifiable_entity_id) REFERENCES notifiable_entity (id)');
        $this->addSql('ALTER TABLE detailstache ADD saisiepar_id INT NOT NULL');
        $this->addSql('ALTER TABLE detailstache ADD CONSTRAINT FK_9E192E61BCEBF3E2 FOREIGN KEY (saisiepar_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_9E192E61BCEBF3E2 ON detailstache (saisiepar_id)');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207519EB6921');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075DEACA195');
        $this->addSql('DROP INDEX IDX_9387207519EB6921 ON tache');
        $this->addSql('DROP INDEX IDX_93872075DEACA195 ON tache');
        $this->addSql('ALTER TABLE tache DROP chefdeprojet_id, DROP client_id, DROP type');
        $this->addSql('ALTER TABLE fos_user_user_group DROP FOREIGN KEY FK_B3C77447FE54D947');
        $this->addSql('ALTER TABLE fos_user_user_group ADD CONSTRAINT FK_B3C77447FE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE notifiable_notification DROP FOREIGN KEY FK_ADCFE0FAC3A0A4F8');
        $this->addSql('ALTER TABLE notifiable_notification DROP FOREIGN KEY FK_ADCFE0FAEF1A9D84');
        $this->addSql('DROP TABLE notifiable_entity');
        $this->addSql('DROP TABLE notifiable_notification');
        $this->addSql('DROP TABLE notification');
        $this->addSql('ALTER TABLE detailstache DROP FOREIGN KEY FK_9E192E61BCEBF3E2');
        $this->addSql('DROP INDEX IDX_9E192E61BCEBF3E2 ON detailstache');
        $this->addSql('ALTER TABLE detailstache DROP saisiepar_id');
        $this->addSql('ALTER TABLE fos_user_user_group DROP FOREIGN KEY FK_B3C77447FE54D947');
        $this->addSql('ALTER TABLE fos_user_user_group ADD CONSTRAINT FK_B3C77447FE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache ADD chefdeprojet_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207519EB6921 FOREIGN KEY (client_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075DEACA195 FOREIGN KEY (chefdeprojet_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_9387207519EB6921 ON tache (client_id)');
        $this->addSql('CREATE INDEX IDX_93872075DEACA195 ON tache (chefdeprojet_id)');
    }
}
