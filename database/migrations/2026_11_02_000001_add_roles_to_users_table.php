<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('role');
        });

        // Inisialisasi data awal roles berdasarkan role eksisting
        $users = DB::table('users')->get();
        foreach ($users as $u) {
            $initialRole = $u->role;
            if ($initialRole === 'dosen') {
                $rolesList = ['peneliti'];
            } elseif ($initialRole === 'admin') {
                $rolesList = ['admin'];
            } elseif ($initialRole === 'reviewer') {
                $rolesList = ['reviewer'];
            } else {
                $rolesList = [$initialRole ?: 'peneliti'];
            }

            DB::table('users')->where('id', $u->id)->update([
                'roles' => json_encode($rolesList),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
