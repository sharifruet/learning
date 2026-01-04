<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJavaScriptCourses extends Migration
{
    public function up()
    {
        // JavaScript Programming course already exists (created by MasterDataSeeder)
        // JavaScript subcourses are handled by JavaScriptSubcoursesSeeder
        // This migration is no longer needed, so we skip it
        // The migration exists for historical reasons but does nothing
        return;
    }

    public function down()
    {
        // This migration doesn't create anything, so nothing to roll back
        return;
    }
}

