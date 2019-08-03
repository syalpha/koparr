<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190803180336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, identreprise_id INT DEFAULT NULL, numcompte INT NOT NULL, montant INT NOT NULL, INDEX IDX_CFF65260DD34B831 (identreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, idcompte_id INT DEFAULT NULL, iduser_id INT DEFAULT NULL, montant INT NOT NULL, datetrans DATETIME NOT NULL, INDEX IDX_723705D18CDECFD5 (idcompte_id), INDEX IDX_723705D1786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260DD34B831 FOREIGN KEY (identreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18CDECFD5 FOREIGN KEY (idcompte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D18CDECFD5');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE transaction');
    }
}
