<?php

namespace Database\Seeders;

use Database\Seeders\TblEnrollmentsTableSeeder;
use Database\Seeders\TblGradesTableSeeder;
use Database\Seeders\TblMessagesTableSeeder;
use Database\Seeders\TblModulesTableSeeder;
use Database\Seeders\TblParentsTableSeeder;
use Database\Seeders\TblReportCardDetailsTableSeeder;
use Database\Seeders\TblReportCardsTableSeeder;
use Database\Seeders\TblStudentsTableSeeder;
use Database\Seeders\TblSubmissionsTableSeeder;
use Database\Seeders\TblTeachersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TblClassesTableSeeder::class);
        $this->call(TblStudentsTableSeeder::class);
        $this->call(TblClassHistoriesTableSeeder::class);
        $this->call(TblTeachersTableSeeder::class);
        $this->call(TblParentsTableSeeder::class);
        $this->call(TblAttendanceTableSeeder::class);
        $this->call(TblGradesTableSeeder::class);
        $this->call(TblCoursesTableSeeder::class);
        $this->call(TblModulesTableSeeder::class);
        $this->call(TblEnrollmentsTableSeeder::class);
        $this->call(TblAssignmentsTableSeeder::class);
        $this->call(TblSubmissionsTableSeeder::class);
        $this->call(TblMessagesTableSeeder::class);
        $this->call(TblReportCardsTableSeeder::class);
        $this->call(TblReportCardDetailsTableSeeder::class);
    }
}