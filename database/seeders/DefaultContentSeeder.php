<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\FAQ;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // 1. CREATE USERS
        // ============================================

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

        $this->command->info('✅ Users created successfully!');


        // ============================================
        // 2. CREATE CATEGORIES
        // ============================================

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

        $this->command->info('✅ Categories created successfully!');


        // ============================================
        // 3. CREATE HERO SLIDES
        // ============================================

        $slides = [
            [
                'title' => 'ইন্ডাস্ট্রি এক্সপার্টদের গাইডলাইনে নিজেকে দক্ষ করে তুলুন',
                'description' => 'শুধু ভিডিও টিউটোরিয়াল নয়, পাচ্ছেন সরাসরি মেন্টরের সাপোর্ট এবং রিয়েল লাইফ প্রজেক্টের অভিজ্ঞতা।',
                'button_text' => 'এখনই ভর্তি হোন',
                'button_url' => '/courses',
                'background_image' => 'hero-1.webp',
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'AI - এর শক্তিতে গড়ুন আগামীর ক্যারিয়ার',
                'description' => 'সাধারণ দক্ষতা দিয়ে আর নয়, নিজেকে আপডেট করুন ফিউচার টেকনোলজির সাথে। আজই শুরু হোক আপনার AI জার্নি।',
                'button_text' => 'ফ্রি ক্লাস করুন',
                'button_url' => '/courses',
                'background_image' => 'hero-2.webp',
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'সঠিক সময়ে, সুবর্ণ সুযোগে - স্কিল ডেভেলপ হবে যেকোনো জায়গা থেকে।',
                'description' => 'পিসি বা ল্যাপটপে, ঘরে কিংবা বাইরে - স্মার্ট লার্নিং একটি প্ল্যাটফর্মে।',
                'button_text' => 'ফ্রি ক্লাস করুন',
                'button_url' => '/courses',
                'background_image' => 'hero-3.webp',
                'order_index' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }

        $this->command->info('✅ Hero slides created successfully!');


        // ============================================
        // 4. CREATE FAQs
        // ============================================

        $faqs = [
            [
                'question' => 'এই কোর্সে যোগ দেওয়ার জন্য কি কোনো বিশেষ যোগ্যতার প্রয়োজন আছে?',
                'answer' => 'আমি একজন ডিজাইনার। আগে ডিজাইন করতে ঘন্টার পর ঘন্টা লাগত, কিন্তু এআই শেখার পর কাজ অনেক সহজ হয়েছে। কালার প্যালেট, লেআউট আর ভিজ্যুয়াল তৈরিতে এখন আর ঝামেলা নেই। প্রতিদিনের কাজের গতি বেড়েছে এবং মানও উন্নত হয়েছে। আমার ক্লায়েন্টরা এখন আগের চেয়ে অনেক বেশি সন্তুষ্ট।',
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'কোর্সের সময়কাল কতদিন এবং কীভাবে ক্লাসগুলো পরিচালিত হয়?',
                'answer' => 'এই কোর্সটি ৩ দিনের জন্য ডিজাইন করা হয়েছে। প্রতিদিন ২-৩ ঘন্টা করে লাইভ ক্লাস থাকবে। ক্লাসগুলো জুম প্ল্যাটফর্মে অনুষ্ঠিত হবে এবং সব ক্লাসের রেকর্ডিং পাবেন যাতে পরে আবার দেখতে পারেন।',
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'কোর্স কি কোনো লুকানো চার্জ আছে?',
                'answer' => 'কোনো লুকানো চার্জ নেই। একবার পেমেন্ট করলেই সমস্ত কন্টেন্ট, লাইভ ক্লাস, রেকর্ডেড ক্লাস, এবং সাপোর্ট পাবেন। তাছাড়া বিকাশ, নগদ পেমেন্ট সুবিধাও পাবেন।',
                'order_index' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'কোর্স শেষ করার পর কি কোনো সার্টিফিকেট পাওয়া যাবে?',
                'answer' => 'হ্যাঁ, কোর্স সম্পন্ন করার পর আপনার একটি ভেরিফাইড সার্টিফিকেট পাবেন যা আপনার LinkedIn এ শেয়ার করতে পারবেন অথবা চাকরির ইন্টারভিউতে দেখাতে পারবেন। তাছাড়া প্রজেক্ট পোর্টফোলিও পাবেন।',
                'order_index' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'কোর্সে কি কোনো প্রজেক্ট আছে?',
                'answer' => 'জি, কোর্সে বাস্তব জীবনের প্রজেক্ট আছে যা আপনি কোর্স শেষে আপনার পোর্টফোলিওতে যোগ করতে পারবেন। প্রতিটি মডিউলের শেষে ছোট ছোট অ্যাসাইনমেন্ট থাকবে এবং ফাইনাল প্রজেক্ট থাকবে।',
                'order_index' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }

        $this->command->info('✅ FAQs created successfully!');


        // ============================================
        // 5. CREATE SITE SETTINGS
        // ============================================

        SiteSetting::create([
            'company_tagline' => 'Learn AI from Industry Experts',
            'company_description' => 'Master AI and modern technologies with expert-led courses at Rouf AI Academy.',
            'contact_email' => 'giopioservice@gmail.com',
            'contact_phone' => '+8801700000000',
            'contact_address' => 'Dhaka, Bangladesh',
            'facebook_url' => 'https://facebook.com/roufai',
            'twitter_url' => 'https://twitter.com/roufai',
            'linkedin_url' => 'https://linkedin.com/company/roufai',
            'youtube_url' => 'https://youtube.com/@roufai',
            'copyright_text' => 'Rouf AI - সর্বস্বত্ব সংরক্ষিত।',
            'developer_credit_text' => 'Developed with ❤️ by Giopio',
        ]);

        $this->command->info('✅ Site settings created successfully!');


        // ============================================
        // FINAL MESSAGE
        // ============================================

        $this->command->newLine(2);
        $this->command->info('============================================');
        $this->command->info('✅ DEFAULT CONTENT SEEDING COMPLETED!');
        $this->command->info('============================================');
        $this->command->newLine();
        $this->command->info('📧 LOGIN CREDENTIALS:');
        $this->command->info('────────────────────────────────────────────');
        $this->command->info('🔑 Admin:    admin@roufai.com / password');
        $this->command->info('🔑 Instructor: instructor@roufai.com / password');
        $this->command->info('🔑 Student:  student@roufai.com / password');
        $this->command->newLine();
        $this->command->info('📊 CONTENT SUMMARY:');
        $this->command->info('────────────────────────────────────────────');
        $this->command->info('• Users: 3 (Admin, Instructor, Student)');
        $this->command->info('• Categories: 10');
        $this->command->info('• Hero Slides: 3');
        $this->command->info('• FAQs: 5');
        $this->command->info('• Site Settings: 1');
        $this->command->newLine();
    }
}
