<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        try {
            Schema::create('note', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->bigInteger('issue_id');
                $table->foreign('issue_id')->references('id')->on('issue')->onDelete('CASCADE');
                $table->text('body')->nullable();
                $table->bigInteger('author_id');
                $table->timestamp('gitlab_created_at')->nullable();
                $table->timestamp('gitlab_updated_at')->nullable();
                $table->timestamps();
            });

            DB::statement('CREATE INDEX ON note (LOWER(body));');
            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note');
    }
}
