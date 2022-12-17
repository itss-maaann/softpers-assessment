<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_file_data', function (Blueprint $table) {
            $table->id();
            $table->index('column_id');
            $table->unsignedBigInteger('column_id')->comment = 'Id of Columns which is related to specific file';
            $table->foreign('column_id')
            ->references('id')
            ->on('file_columns')
            ->onDelete('cascade');
            $table->string('value')->default('')->comment = 'Value on particular column of a file';
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excel_file_data');
    }
};
