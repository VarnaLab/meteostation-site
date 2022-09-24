<?php

declare(strict_types = 1);

namespace <namespace>;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class <className> extends AbstractMigration
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

        SQL);
<up>
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

        SQL);
<down>
    }
}
