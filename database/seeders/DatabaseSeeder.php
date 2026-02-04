<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@roufai.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Test Instructor
        User::create([
            'name' => 'Test Instructor',
            'email' => 'instructor@roufai.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'bio' => 'Experienced instructor in web development and programming.',
            'payment_details' => 'Bkash: 01712345678',
        ]);

        // Create Test Student
        User::create([
            'name' => 'Test Student',
            'email' => 'student@roufai.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create predefined categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Data Science', 'slug' => 'data-science'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Business', 'slug' => 'business'],
            ['name' => 'Marketing', 'slug' => 'marketing'],
            ['name' => 'Photography', 'slug' => 'photography'],
            ['name' => 'Music', 'slug' => 'music'],
            ['name' => 'Health & Fitness', 'slug' => 'health-fitness'],
            ['name' => 'Personal Development', 'slug' => 'personal-development'],
            ['name' => 'IT & Software', 'slug' => 'it-software'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📧 Admin Login: admin@roufai.com / password');
        $this->command->info('📧 Instructor Login: instructor@roufai.com / password');
        $this->command->info('📧 Student Login: student@roufai.com / password');
    }
}
