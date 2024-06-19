<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visitor; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        Visitor::factory()->count(40)->create(); // Cambia "Visit" por "Visitor"
    }

    
}
