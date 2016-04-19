<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160419094123 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, magical_capability_id INT DEFAULT NULL, tradition_id INT DEFAULT NULL, totem_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, occupation VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, reputation INT NOT NULL, good_karma INT NOT NULL, karmapool INT NOT NULL, type INT NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, INDEX IDX_3A29410EA297DE50 (magical_capability_id), INDEX IDX_3A29410E649E4584 (tradition_id), INDEX IDX_3A29410EA1EBF819 (totem_id), INDEX IDX_3A29410EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, title VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magical_tradition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE totem (id INT AUTO_INCREMENT NOT NULL, tradition_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, rule_text LONGTEXT NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, INDEX IDX_D14414CC649E4584 (tradition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equip_item (id INT AUTO_INCREMENT NOT NULL, character_id INT DEFAULT NULL, amount INT NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, INDEX IDX_463C49CF1136BE75 (character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specalization (id INT AUTO_INCREMENT NOT NULL, skill_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, INDEX IDX_FEF7195585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magical_capability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EA297DE50 FOREIGN KEY (magical_capability_id) REFERENCES magical_capability (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E649E4584 FOREIGN KEY (tradition_id) REFERENCES magical_tradition (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EA1EBF819 FOREIGN KEY (totem_id) REFERENCES totem (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE totem ADD CONSTRAINT FK_D14414CC649E4584 FOREIGN KEY (tradition_id) REFERENCES magical_tradition (id)');
        $this->addSql('ALTER TABLE equip_item ADD CONSTRAINT FK_463C49CF1136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE specalization ADD CONSTRAINT FK_FEF7195585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('DROP TABLE person');
        $this->addSql('ALTER TABLE connection_not_in_d_b ADD owner_id INT DEFAULT NULL, ADD target VARCHAR(255) NOT NULL, ADD level INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE connection_not_in_d_b ADD CONSTRAINT FK_CBD5FB1B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_CBD5FB1B7E3C61F9 ON connection_not_in_d_b (owner_id)');
        $this->addSql('ALTER TABLE skill ADD skill_id INT DEFAULT NULL, ADD name VARCHAR(45) NOT NULL, ADD type INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4775585C142 FOREIGN KEY (skill_id) REFERENCES attribute (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E3DE4775E237E06 ON skill (name)');
        $this->addSql('CREATE INDEX IDX_5E3DE4775585C142 ON skill (skill_id)');
        $this->addSql('ALTER TABLE connection_in_d_b ADD target_id INT DEFAULT NULL, ADD owner_id INT DEFAULT NULL, ADD level INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE connection_in_d_b ADD CONSTRAINT FK_41D98630158E0B66 FOREIGN KEY (target_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE connection_in_d_b ADD CONSTRAINT FK_41D986307E3C61F9 FOREIGN KEY (owner_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_41D98630158E0B66 ON connection_in_d_b (target_id)');
        $this->addSql('CREATE INDEX IDX_41D986307E3C61F9 ON connection_in_d_b (owner_id)');
        $this->addSql('ALTER TABLE character_to_attribute ADD character_id INT DEFAULT NULL, ADD attribute_id INT DEFAULT NULL, ADD level INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE character_to_attribute ADD CONSTRAINT FK_14BDBDE31136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE character_to_attribute ADD CONSTRAINT FK_14BDBDE3B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('CREATE INDEX IDX_14BDBDE31136BE75 ON character_to_attribute (character_id)');
        $this->addSql('CREATE INDEX IDX_14BDBDE3B6E62EFA ON character_to_attribute (attribute_id)');
        $this->addSql('ALTER TABLE character_to_skill ADD character_id INT DEFAULT NULL, ADD skill_id INT DEFAULT NULL, ADD level INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE character_to_skill ADD CONSTRAINT FK_D003CD61136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE character_to_skill ADD CONSTRAINT FK_D003CD65585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('CREATE INDEX IDX_D003CD61136BE75 ON character_to_skill (character_id)');
        $this->addSql('CREATE INDEX IDX_D003CD65585C142 ON character_to_skill (skill_id)');
        $this->addSql('ALTER TABLE character_skill_to_specialization ADD charskill_id INT DEFAULT NULL, ADD specialization_id INT DEFAULT NULL, ADD level INT NOT NULL, ADD updated DATETIME NOT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('ALTER TABLE character_skill_to_specialization ADD CONSTRAINT FK_CCB6E8461ED995DC FOREIGN KEY (charskill_id) REFERENCES character_to_skill (id)');
        $this->addSql('ALTER TABLE character_skill_to_specialization ADD CONSTRAINT FK_CCB6E846FA846217 FOREIGN KEY (specialization_id) REFERENCES specalization (id)');
        $this->addSql('CREATE INDEX IDX_CCB6E8461ED995DC ON character_skill_to_specialization (charskill_id)');
        $this->addSql('CREATE INDEX IDX_CCB6E846FA846217 ON character_skill_to_specialization (specialization_id)');
        $this->addSql('ALTER TABLE attribute ADD name VARCHAR(45) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EA76ED395');
        $this->addSql('ALTER TABLE connection_not_in_d_b DROP FOREIGN KEY FK_CBD5FB1B7E3C61F9');
        $this->addSql('ALTER TABLE connection_in_d_b DROP FOREIGN KEY FK_41D98630158E0B66');
        $this->addSql('ALTER TABLE connection_in_d_b DROP FOREIGN KEY FK_41D986307E3C61F9');
        $this->addSql('ALTER TABLE character_to_attribute DROP FOREIGN KEY FK_14BDBDE31136BE75');
        $this->addSql('ALTER TABLE character_to_skill DROP FOREIGN KEY FK_D003CD61136BE75');
        $this->addSql('ALTER TABLE equip_item DROP FOREIGN KEY FK_463C49CF1136BE75');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E649E4584');
        $this->addSql('ALTER TABLE totem DROP FOREIGN KEY FK_D14414CC649E4584');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EA1EBF819');
        $this->addSql('ALTER TABLE character_skill_to_specialization DROP FOREIGN KEY FK_CCB6E846FA846217');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EA297DE50');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE magical_tradition');
        $this->addSql('DROP TABLE totem');
        $this->addSql('DROP TABLE equip_item');
        $this->addSql('DROP TABLE specalization');
        $this->addSql('DROP TABLE magical_capability');
        $this->addSql('ALTER TABLE attribute DROP name');
        $this->addSql('DROP INDEX IDX_CCB6E8461ED995DC ON character_skill_to_specialization');
        $this->addSql('DROP INDEX IDX_CCB6E846FA846217 ON character_skill_to_specialization');
        $this->addSql('ALTER TABLE character_skill_to_specialization DROP charskill_id, DROP specialization_id, DROP level, DROP updated, DROP created');
        $this->addSql('DROP INDEX IDX_14BDBDE31136BE75 ON character_to_attribute');
        $this->addSql('DROP INDEX IDX_14BDBDE3B6E62EFA ON character_to_attribute');
        $this->addSql('ALTER TABLE character_to_attribute DROP character_id, DROP attribute_id, DROP level, DROP updated, DROP created');
        $this->addSql('DROP INDEX IDX_D003CD61136BE75 ON character_to_skill');
        $this->addSql('DROP INDEX IDX_D003CD65585C142 ON character_to_skill');
        $this->addSql('ALTER TABLE character_to_skill DROP character_id, DROP skill_id, DROP level, DROP updated, DROP created');
        $this->addSql('DROP INDEX IDX_41D98630158E0B66 ON connection_in_d_b');
        $this->addSql('DROP INDEX IDX_41D986307E3C61F9 ON connection_in_d_b');
        $this->addSql('ALTER TABLE connection_in_d_b DROP target_id, DROP owner_id, DROP level, DROP updated, DROP created');
        $this->addSql('DROP INDEX IDX_CBD5FB1B7E3C61F9 ON connection_not_in_d_b');
        $this->addSql('ALTER TABLE connection_not_in_d_b DROP owner_id, DROP target, DROP level, DROP updated, DROP created');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4775585C142');
        $this->addSql('DROP INDEX UNIQ_5E3DE4775E237E06 ON skill');
        $this->addSql('DROP INDEX IDX_5E3DE4775585C142 ON skill');
        $this->addSql('ALTER TABLE skill DROP skill_id, DROP name, DROP type, DROP updated, DROP created');
    }
}
