<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913201929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE antecedent (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dossier_id INT NOT NULL, type VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3166BE7CA76ED395 (user_id), INDEX IDX_3166BE7C611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dossier_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', motif VARCHAR(255) NOT NULL, traitant VARCHAR(50) NOT NULL, INDEX IDX_964685A6A76ED395 (user_id), INDEX IDX_964685A6611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, clinique VARCHAR(50) NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, age INT NOT NULL, sexe VARCHAR(15) NOT NULL, email VARCHAR(50) DEFAULT NULL, adresse VARCHAR(50) NOT NULL, phone VARCHAR(12) NOT NULL, profession VARCHAR(45) NOT NULL, taille DOUBLE PRECISION NOT NULL, poids DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3D48E03767B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dossier_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(40) NOT NULL, resultat LONGTEXT NOT NULL, INDEX IDX_514C8FECA76ED395 (user_id), INDEX IDX_514C8FEC611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dossier_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(35) NOT NULL, medicament VARCHAR(50) NOT NULL, quantite INT NOT NULL, debut DATE DEFAULT NULL, fin DATE DEFAULT NULL, INDEX IDX_924B326CA76ED395 (user_id), INDEX IDX_924B326C611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dossier_id INT NOT NULL, date DATE NOT NULL, motif VARCHAR(255) NOT NULL, INDEX IDX_10C31F86A76ED395 (user_id), INDEX IDX_10C31F86611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, sexe VARCHAR(25) NOT NULL, phone VARCHAR(12) NOT NULL, fonction VARCHAR(45) NOT NULL, title VARCHAR(45) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE antecedent ADD CONSTRAINT FK_3166BE7CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE antecedent ADD CONSTRAINT FK_3166BE7C611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E03767B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FEC611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE antecedent DROP FOREIGN KEY FK_3166BE7CA76ED395');
        $this->addSql('ALTER TABLE antecedent DROP FOREIGN KEY FK_3166BE7C611C0C56');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6A76ED395');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6611C0C56');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E03767B3B43D');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECA76ED395');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FEC611C0C56');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CA76ED395');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C611C0C56');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86A76ED395');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86611C0C56');
        $this->addSql('DROP TABLE antecedent');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
