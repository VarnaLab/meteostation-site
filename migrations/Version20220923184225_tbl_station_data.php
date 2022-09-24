<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923184225_tbl_station_data extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create base station data measurements';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            create table station_data (
                station_data_id uuid not null default gen_random_uuid(),
                station_id text not null references station (station_id),
                value jsonb not null,
                created_at timestamptz not null default current_timestamp(0),
                primary key (station_id, created_at, value)
            )
        SQL);

        $this->addSql('create index station_data_id_idx on station_data (station_data_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            drop table station_data
        SQL);
    }
}
