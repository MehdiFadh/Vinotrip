<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->after('name');        // Ajouter le champ 'prenom'
            $table->date('date_naissance')->after('email'); // Ajouter le champ 'date_naissance'
            $table->string('telephone')->after('date_naissance'); // Ajouter le champ 'telephone'
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'date_naissance', 'telephone']);
        });
    }
}
