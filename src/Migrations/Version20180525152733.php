<?php declare(strict_types=1);

namespace BalticRobo\Migrations;

use BalticRobo\Website\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema;

final class Version20180525152733 extends Migration
{
    public function getDescription(): string
    {
        return 'Modify Hackathon Team Member - add fields to keep info about presence at Event (Registration)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_members_hackathon
          ADD presence_checked_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\',
          ADD shirt_given_out_at INT DEFAULT NULL COMMENT \'(DC2Type:timestamp_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE registration_members_hackathon
          DROP presence_checked_at,
          DROP shirt_given_out_at');
    }
}
