<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class VersionInitial extends AbstractMigration implements ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE imagetypes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observationstatuses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reviews_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tags_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, locked BOOLEAN NOT NULL, expired BOOLEAN NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, credentials_expired BOOLEAN NOT NULL, credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE observations (id INT NOT NULL, organism_id INT NOT NULL, status_id INT NOT NULL, type_id INT DEFAULT NULL, user_id INT NOT NULL, datum VARCHAR(50) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, geom geometry(GEOMETRY, 0) DEFAULT NULL, locationdetail TEXT DEFAULT NULL, date_observed DATE DEFAULT NULL, date_added TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBC15BA864180A36 ON observations (organism_id)');
        $this->addSql('CREATE INDEX IDX_BBC15BA86BF700BD ON observations (status_id)');
        $this->addSql('CREATE INDEX IDX_BBC15BA8C54C8C93 ON observations (type_id)');
        $this->addSql('CREATE INDEX IDX_BBC15BA8A76ED395 ON observations (user_id)');
        $this->addSql('CREATE TABLE characters (id INT NOT NULL, type_id INT DEFAULT NULL, is_numeric BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A29410EC54C8C93 ON characters (type_id)');
        $this->addSql('CREATE TABLE charactertypes (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE images (id INT NOT NULL, observation_id INT DEFAULT NULL, imagetype_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, photographer TEXT DEFAULT NULL, comments TEXT DEFAULT NULL, copyright TEXT DEFAULT NULL, infodisplay TEXT DEFAULT NULL, charactertype_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E01FBE6A1409DD88 ON images (observation_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A936235D8 ON images (imagetype_id)');
        $this->addSql('CREATE TABLE images_tags (image_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(image_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_55B2A5D93DA5256D ON images_tags (image_id)');
        $this->addSql('CREATE INDEX IDX_55B2A5D9BAD26311 ON images_tags (tag_id)');
        $this->addSql('CREATE TABLE imagetypes (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE observationstatuses (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE observationtypes (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE organisms (id INT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE organismgadms (id INT NOT NULL, organism_id INT NOT NULL, gadm_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_65AAE04864180A36 ON organismgadms (organism_id)');
        $this->addSql('CREATE INDEX IDX_65AAE0482C2B939B ON organismgadms (gadm_id)');
        $this->addSql('CREATE TABLE organismstates (id INT NOT NULL, organism_id INT NOT NULL, state_id INT NOT NULL, low_value DOUBLE PRECISION DEFAULT NULL, high_value DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6B9A292C64180A36 ON organismstates (organism_id)');
        $this->addSql('CREATE INDEX IDX_6B9A292C5D83CC1 ON organismstates (state_id)');
        $this->addSql('CREATE TABLE reviews (id INT NOT NULL, observation_id INT NOT NULL, comments TEXT DEFAULT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6970EB0F1409DD88 ON reviews (observation_id)');
        $this->addSql('CREATE TABLE states (id INT NOT NULL, character_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31C2774D1136BE75 ON states (character_id)');
        $this->addSql('CREATE TABLE tags (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE observations ADD CONSTRAINT FK_BBC15BA864180A36 FOREIGN KEY (organism_id) REFERENCES organisms (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE observations ADD CONSTRAINT FK_BBC15BA86BF700BD FOREIGN KEY (status_id) REFERENCES observationstatuses (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE observations ADD CONSTRAINT FK_BBC15BA8C54C8C93 FOREIGN KEY (type_id) REFERENCES observationtypes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE observations ADD CONSTRAINT FK_BBC15BA8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EC54C8C93 FOREIGN KEY (type_id) REFERENCES charactertypes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A1409DD88 FOREIGN KEY (observation_id) REFERENCES observations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A936235D8 FOREIGN KEY (imagetype_id) REFERENCES imagetypes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images_tags ADD CONSTRAINT FK_55B2A5D93DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images_tags ADD CONSTRAINT FK_55B2A5D9BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organismgadms ADD CONSTRAINT FK_65AAE04864180A36 FOREIGN KEY (organism_id) REFERENCES organisms (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organismgadms ADD CONSTRAINT FK_65AAE0482C2B939B FOREIGN KEY (gadm_id) REFERENCES gadm (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organismstates ADD CONSTRAINT FK_6B9A292C64180A36 FOREIGN KEY (organism_id) REFERENCES organisms (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organismstates ADD CONSTRAINT FK_6B9A292C5D83CC1 FOREIGN KEY (state_id) REFERENCES states (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F1409DD88 FOREIGN KEY (observation_id) REFERENCES observations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE states ADD CONSTRAINT FK_31C2774D1136BE75 FOREIGN KEY (character_id) REFERENCES characters (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        
    }
    
    public function postUp(Schema $schema)
    {
        // here you have to define fixtures dir
        $this->loadFixtures('src/AppBundle/DataFixtures/ORM/iCViburnum/LoadInitialData.php');
    }
    
    public function loadFixtures($dir, $append = true)
    {
        $kernel = $this->container->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);
    
        //Loading Fixtures
        $options = array('command' => 'doctrine:fixtures:load', "--fixtures" => $dir, "--append" => (boolean) $append);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE images_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE imagetypes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observationstatuses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reviews_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tags_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE observations DROP CONSTRAINT FK_BBC15BA8A76ED395');
        $this->addSql('ALTER TABLE images DROP CONSTRAINT FK_E01FBE6A1409DD88');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0F1409DD88');
        $this->addSql('ALTER TABLE states DROP CONSTRAINT FK_31C2774D1136BE75');
        $this->addSql('ALTER TABLE characters DROP CONSTRAINT FK_3A29410EC54C8C93');
        $this->addSql('ALTER TABLE images_tags DROP CONSTRAINT FK_55B2A5D93DA5256D');
        $this->addSql('ALTER TABLE images DROP CONSTRAINT FK_E01FBE6A936235D8');
        $this->addSql('ALTER TABLE observations DROP CONSTRAINT FK_BBC15BA86BF700BD');
        $this->addSql('ALTER TABLE observations DROP CONSTRAINT FK_BBC15BA8C54C8C93');
        $this->addSql('ALTER TABLE observations DROP CONSTRAINT FK_BBC15BA864180A36');
        $this->addSql('ALTER TABLE organismgadms DROP CONSTRAINT FK_65AAE04864180A36');
        $this->addSql('ALTER TABLE organismgadms DROP CONSTRAINT FK_65AAE0482C2B939B');
        $this->addSql('ALTER TABLE organismstates DROP CONSTRAINT FK_6B9A292C64180A36');
        $this->addSql('ALTER TABLE organismstates DROP CONSTRAINT FK_6B9A292C5D83CC1');
        $this->addSql('ALTER TABLE images_tags DROP CONSTRAINT FK_55B2A5D9BAD26311');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE observations');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE charactertypes');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_tags');
        $this->addSql('DROP TABLE imagetypes');
        $this->addSql('DROP TABLE observationstatuses');
        $this->addSql('DROP TABLE observationtypes');
        $this->addSql('DROP TABLE organisms');
        $this->addSql('DROP TABLE organismgadms');
        $this->addSql('DROP TABLE organismstates');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE states');
        $this->addSql('DROP TABLE tags');
    }
}
