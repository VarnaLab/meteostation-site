<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20221024180543_tbl_users extends AbstractMigration
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

        $this->addSql('
            CREATE TABLE app_user (
                user_id UUID NOT NULL DEFAULT gen_random_uuid(), 
                email VARCHAR(180) NOT NULL, 
                roles JSON NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                PRIMARY KEY(user_id)
            )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
        $this->addSql('COMMENT ON COLUMN app_user.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE app_user OWNER TO meteo');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            !is_a($this->connection->getDatabasePlatform(), PostgreSQLPlatform::class),
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP TABLE app_user');
    }
}
