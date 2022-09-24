<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20220922114242_tbl_station extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            !is_a($this->connection->getDatabasePlatform(), PostgreSQLPlatform::class),
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql(/** @lang PostgreSQL */ <<<SQL
            create table station (
                station_id text not null unique,
                name text,
                description text not null default '',
                location point,
                created_at timestamptz not null default current_timestamp(0)
            )
        SQL);

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql(/** @lang PostgreSQL */<<<SQL
            drop table station
        SQL);

    }
}
