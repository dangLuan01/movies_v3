<?php

use PragmaRX\Tracker\Support\Migration;

class CreateTrackerAgentsTable extends Migration
{
    /**
     * Table related to this migration.
     *
     * @var string
     */
    private $table = 'tracker_agents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function migrateUp()
    {
        $this->builder->create(
            $this->table,
            function ($table) {
                $table->engine = "InnoDB";
                $table->bigIncrements('id');

                $table->string('name')->unique();
                $table->string('browser')->index();
                $table->string('browser_version');

                $table->timestamps();
                $table->index('created_at');
                $table->index('updated_at');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function migrateDown()
    {
        $this->drop($this->table);
    }
}
