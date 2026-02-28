<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
