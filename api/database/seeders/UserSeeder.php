<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Actress;
use App\Models\Category;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::factory()->count(10)->create();

        foreach ($users as $user) {

            $user = User::create([
                'user_id' => $user->id,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'user_name' => $faker->userName,
                'photo_url' => $faker->imageUrl(),
                'bio' => $faker->text,
            ]);

            // Asignar categorías a las actrices
            $categories = Category::inRandomOrder()->limit(3)->get();
            $user->categories()->attach($categories);
        }
    }
}
