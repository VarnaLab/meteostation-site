<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20221106110824 extends AbstractMigration
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

        $this->addSql('ALTER TABLE station ALTER location TYPE Geometry(point) USING location::geometry');
        $this->addSql('COMMENT ON COLUMN station.created_at IS \'(DC2Type:datetimetz_immutable)\'');
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

        $this->addSql('ALTER TABLE station ALTER location TYPE point');
    }
}
