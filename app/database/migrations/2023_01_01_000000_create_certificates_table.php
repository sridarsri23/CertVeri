<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->string('certificate_no');
                $table->string('student_name');
                $table->date('issue_date');
                $table->date('expire_date');
                $table->string('qualification');
                $table->string('accredited_by');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
