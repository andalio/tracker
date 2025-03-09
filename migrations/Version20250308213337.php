<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250308213337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE allowed_domain (id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_2F62E5F7A7A91E0B (domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('INSERT INTO allowed_domain (domain, active, created) VALUES ("domain.com", 1, NOW())');

        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, page_url VARCHAR(255) NOT NULL, user_hash VARCHAR(255) NOT NULL, visit_date DATE NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX unique_visit (page_url, user_hash, visit_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE allowed_domain');
        $this->addSql('DROP TABLE visit');
    }
}
