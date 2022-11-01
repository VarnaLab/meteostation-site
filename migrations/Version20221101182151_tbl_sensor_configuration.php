<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20221101182151_tbl_sensor_configuration extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf(
            !is_a($this->connection->getDatabasePlatform(), PostgreSQLPlatform::class),
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('
           CREATE TABLE sensor (
             code VARCHAR(255) NOT NULL,
             name VARCHAR(255) DEFAULT NULL,
             PRIMARY KEY(code)
           )');
        $this->addSql('
           CREATE TABLE sensor_color (
             code VARCHAR(255) NOT NULL REFERENCES sensor (code) ON DELETE CASCADE,
             value DOUBLE PRECISION NOT NULL,
             color VARCHAR(255) NOT NULL,
             PRIMARY KEY(code)
           )');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            'postgresql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP TABLE sensor_color');
        $this->addSql('DROP TABLE sensor');
    }
}
