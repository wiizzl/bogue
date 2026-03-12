<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260312191047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, contact_name VARCHAR(150) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE history_log (id INT AUTO_INCREMENT NOT NULL, old_value LONGTEXT DEFAULT NULL, new_value LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, action_type_id INT NOT NULL, author_id INT NOT NULL, internship_id INT DEFAULT NULL, INDEX IDX_6190350A1FEE0472 (action_type_id), INDEX IDX_6190350AF675F31B (author_id), INDEX IDX_6190350A7A4A70BE (internship_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE internship (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, remarks LONGTEXT DEFAULT NULL, student_id INT NOT NULL, company_id INT NOT NULL, tracking_teacher_id INT DEFAULT NULL, visiting_teacher_id INT DEFAULT NULL, INDEX IDX_10D1B00CCB944F1A (student_id), INDEX IDX_10D1B00C979B1AD6 (company_id), INDEX IDX_10D1B00C3C0AC0DC (tracking_teacher_id), INDEX IDX_10D1B00CBCFE061F (visiting_teacher_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE internship_milestone (id INT AUTO_INCREMENT NOT NULL, validated_at DATE DEFAULT NULL, comment LONGTEXT DEFAULT NULL, internship_id INT NOT NULL, status_id INT NOT NULL, milestone_id INT NOT NULL, INDEX IDX_FD01E8C07A4A70BE (internship_id), INDEX IDX_FD01E8C06BF700BD (status_id), INDEX IDX_FD01E8C04B3E2EDA (milestone_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE major (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE milestone (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE milestone_status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, is_archived TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, code VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, major_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_B723AF33E93695C7 (major_id), INDEX IDX_B723AF33139DF194 (promotion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY (user_id, role_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE history_log ADD CONSTRAINT FK_6190350A1FEE0472 FOREIGN KEY (action_type_id) REFERENCES action_type (id)');
        $this->addSql('ALTER TABLE history_log ADD CONSTRAINT FK_6190350AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history_log ADD CONSTRAINT FK_6190350A7A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C3C0AC0DC FOREIGN KEY (tracking_teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00CBCFE061F FOREIGN KEY (visiting_teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internship_milestone ADD CONSTRAINT FK_FD01E8C07A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('ALTER TABLE internship_milestone ADD CONSTRAINT FK_FD01E8C06BF700BD FOREIGN KEY (status_id) REFERENCES milestone_status (id)');
        $this->addSql('ALTER TABLE internship_milestone ADD CONSTRAINT FK_FD01E8C04B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33E93695C7 FOREIGN KEY (major_id) REFERENCES major (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history_log DROP FOREIGN KEY FK_6190350A1FEE0472');
        $this->addSql('ALTER TABLE history_log DROP FOREIGN KEY FK_6190350AF675F31B');
        $this->addSql('ALTER TABLE history_log DROP FOREIGN KEY FK_6190350A7A4A70BE');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00CCB944F1A');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C979B1AD6');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C3C0AC0DC');
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00CBCFE061F');
        $this->addSql('ALTER TABLE internship_milestone DROP FOREIGN KEY FK_FD01E8C07A4A70BE');
        $this->addSql('ALTER TABLE internship_milestone DROP FOREIGN KEY FK_FD01E8C06BF700BD');
        $this->addSql('ALTER TABLE internship_milestone DROP FOREIGN KEY FK_FD01E8C04B3E2EDA');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33E93695C7');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33139DF194');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('DROP TABLE action_type');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE history_log');
        $this->addSql('DROP TABLE internship');
        $this->addSql('DROP TABLE internship_milestone');
        $this->addSql('DROP TABLE major');
        $this->addSql('DROP TABLE milestone');
        $this->addSql('DROP TABLE milestone_status');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
    }
}
