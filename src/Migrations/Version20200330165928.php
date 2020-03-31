<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330165928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('CREATE TABLE user_user_networks (id UUID NOT NULL, user_id UUID NOT NULL, network VARCHAR(32) DEFAULT NULL, identity VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D7BAFD7BA76ED395 ON user_user_networks (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7BAFD7B608487BC6A95E9C4 ON user_user_networks (network, identity)');
        $this->addSql('CREATE TABLE user_users (id UUID NOT NULL, email VARCHAR(255) DEFAULT NULL, password_hash VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, confirm_token VARCHAR(255) DEFAULT NULL, status VARCHAR(16) NOT NULL, role VARCHAR(255) NOT NULL, reset_token_token VARCHAR(255) DEFAULT NULL, reset_token_expires TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1E7927C74 ON user_users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB186EC69F0 ON user_users (reset_token_token)');
        $this->addSql('COMMENT ON COLUMN user_users.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.reset_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_user_networks ADD CONSTRAINT FK_D7BAFD7BA76ED395 FOREIGN KEY (user_id) REFERENCES user_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE user_user_networks DROP CONSTRAINT FK_D7BAFD7BA76ED395');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON users (email)');
        $this->addSql('DROP TABLE user_user_networks');
        $this->addSql('DROP TABLE user_users');
    }
}
