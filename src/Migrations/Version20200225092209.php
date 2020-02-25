<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add Movie <> Person manyToMany relation
 */
final class Version20200225092209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Movie <> Person manyToMany relation';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE imdb_person_imdb_movie (imdb_person_id INT NOT NULL, imdb_movie_id INT NOT NULL, INDEX IDX_61C7548D166EB92C (imdb_person_id), INDEX IDX_61C7548D42AA2D17 (imdb_movie_id), PRIMARY KEY(imdb_person_id, imdb_movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE imdb_person_imdb_movie ADD CONSTRAINT FK_61C7548D166EB92C FOREIGN KEY (imdb_person_id) REFERENCES mf_person (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE imdb_person_imdb_movie ADD CONSTRAINT FK_61C7548D42AA2D17 FOREIGN KEY (imdb_movie_id) REFERENCES mf_movie (id) ON DELETE CASCADE'
        );
        $this->addSql('ALTER TABLE mf_person DROP movie');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE imdb_person_imdb_movie');
        $this->addSql(
            'ALTER TABLE mf_person ADD movie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`'
        );
    }
}
