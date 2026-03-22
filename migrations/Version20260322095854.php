<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260322095854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, tutor_name VARCHAR(150) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE internship (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, remarks LONGTEXT DEFAULT NULL, student_id INT NOT NULL, company_id INT NOT NULL, tracking_teacher_id INT DEFAULT NULL, visiting_teacher_id INT DEFAULT NULL, INDEX IDX_10D1B00C979B1AD6 (company_id), INDEX IDX_10D1B00C3C0AC0DC (tracking_teacher_id), INDEX IDX_10D1B00CBCFE061F (visiting_teacher_id), INDEX idx_internship_teachers (tracking_teacher_id, visiting_teacher_id), INDEX idx_internship_student (student_id), INDEX idx_internship_dates (start_date, end_date), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE major (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, is_archived TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, code VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, major_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_B723AF33E93695C7 (major_id), INDEX IDX_B723AF33139DF194 (promotion_id), INDEX idx_student_promotion_major (promotion_id, major_id), INDEX idx_student_name (last_name, first_name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, role_id INT DEFAULT NULL, INDEX IDX_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C3C0AC0DC FOREIGN KEY (tracking_teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00CBCFE061F FOREIGN KEY (visiting_teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33E93695C7 FOREIGN KEY (major_id) REFERENCES major (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00CCB944F1A');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C979B1AD6');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C3C0AC0DC');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00CBCFE061F');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33E93695C7');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33139DF194');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE internship');
        $this->addSql('DROP TABLE major');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
    }
}
