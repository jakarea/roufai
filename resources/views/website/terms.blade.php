@extends('layouts.website')

@section('title', 'শর্তাবলী ও শর্তাবলী - AI কোর্স | আব্দুর রউফ')
@section('description', 'Rouf AI Academy এর শর্তাবলী ও শর্তাবলী সম্পর্কে জানুন। কোর্স এনরোলমেন্ট এবং ব্যবহারের শর্তাবলী।')

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- Terms Section -->
<section class="w-full py-10 lg:py-16 relative bg-[#131620]">
    <div class="container-x">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-[#E2E8F0] mb-4">
                শর্তাবলী ও শর্তাবলী
            </h1>
            <p class="text-[#ABABAB] text-lg">
                Rouf AI Academy এর সেবা ব্যবহারের শর্তাবলী ও শর্তাবলী
            </p>
            <p class="text-sm text-[#E850FF] mt-2">
                সর্বশেষ আপডেট: {{ date('d F, Y') }}
            </p>
        </div>

        <!-- Terms Content -->
        <div class="max-w-4xl mx-auto bg-white/5 border border-white/10 rounded-lg p-8 lg:p-12">
            <div class="prose prose-invert max-w-none text-[#ABABAB]">

                <!-- Introduction -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">১. স্বাগতিকা</h2>
                    <p class="leading-relaxed">
                        Rouf AI Academy (এর পরে "আমরা", "আমাদের", "প্ল্যাটফর্ম") এ স্বাগত কোর্স, বুটক্যাম্প এবং অন্য সেবাগুলো ব্যবহার করার মাধ্যমে আপনি এই শর্তাবলী ও শর্তাবলী গ্রহণ করছেন। দয়া করে এই শর্তাবলী সাবধানভাবে পড়ুন করুন।
                    </p>
                </div>

                <!-- Account Registration -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">২. অ্যাকাউন্ট রেজিস্ট্রেশন</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>আপনার অ্যাকাউন্ট নিবন্ধনের জন্য আপনাকে সঠিক, বর্তমান এবং সম্পূর্ণ তথ্য প্রদান করতে হবে।</li>
                        <li>আপনাকে একটি সুরক্ষিত পাসওয়ার্ড তৈরি করতে হবে এবং এটি গোপন রাখতে হবে।</li>
                        <li>আপনার অ্যাকাউন্টের নিরাপত্তা ও ব্যবহারের দায়িত্ব সম্পূর্ণভাবে আপনার।</li>
                        <li>ভুল তথ্য প্রদান করলে আপনার অ্যাকাউন্ট সাসপেন্ড বা বাতিল করা হতে পারে।</li>
                    </ul>
                </div>

                <!-- Course Enrollment -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৩. কোর্স এনরোলমেন্ট</h2>
                    <h3 class="text-xl font-semibold text-[#E2E8F0] mb-2 mt-4">৩.১ ফ্রি কোর্স</h3>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>ফ্রি কোর্সগুলোতে সরাসরি এনরোলমেন্ট করা যাবে।</li>
                        <li>এনরোলমেন্টের পর আপনি সাথে সাথে কোর্সের সমস্ত কন্টেন্ট অ্যাক্সেস করতে পারবেন।</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-[#E2E8F0] mb-2 mt-4">৩.২ পেইড কোর্স</h3>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>পেইড কোর্সে এনরোল করার জন্য পেমেন্ট সম্পন্ন করতে হবে।</li>
                        <li>পেমেন্ট নিশ্চিত হওয়া পর্যন্ত কোর্সের কন্টেন্ট অ্যাক্সেস করা যাবে না।</li>
                        <li>পেমেন্ট পদ্ধতি: বিকাশ, নগদ, রকেট।</li>
                        <li>পেমেন্ট যাচাইয় সময় নিতে হতে পারে (২৪-৪৮ ঘন্টা)।</li>
                    </ul>
                </div>

                <!-- Refund Policy -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৪. রিফান্ড নীতি</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li><strong>কোর্স শুরুর আগে:</strong> ১০০% রিফান্ড</li>
                        <li><strong>কোর্স শুরুর ২৪ ঘন্টার মধ্যে:</strong> ৫০% রিফান্ড</li>
                        <li><strong>কোর্স শুরুর পরে:</strong> কোনো রিফান্ড নেই</li>
                        <li>রিফান্ড পেতে আবেদন করতে giopioservice@gmail.com এ ইমেইল পাঠান।</li>
                        <li>রিফান্ড প্রসেস করতে ৭-১৪ কার্যদিবস লাগতে পারে।</li>
                    </ul>
                </div>

                <!-- User Conduct -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৫. ব্যবহারকারীর আচরণ</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>প্ল্যাটফর্মে অন্য ব্যবহারকারীর সাথে সম্মানজনক আচরণ করতে হবে।</li>
                        <li>কোনো অবৈধ, অশ্লীল বা আপত্তিক কন্টেন্ট শেয়ার করা যাবে না।</li>
                        <li>কোর্সের কন্টেন্ট অননুমোদিত বা রেকর্ড করা নিষিদ্ধ।</li>
                        <li>অন্যের একাউন্টে অননুমতি ছাড়া প্রবেশ করা যাবে না।</li>
                        <li>শিক্ষাদান বা ব্যবসায়ি উদ্দেশ্যে প্ল্যাটফর্ম ব্যবহার করতে হবে।</li>
                    </ul>
                </div>

                <!-- Intellectual Property -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৬. বৌদ্ধিক সম্পদ</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>প্ল্যাটফর্মের সমস্ত কন্টেন্ট (ভিডিও, টেক্সট, গ্রাফিক্স, লোগো) Rouf AI Academy এর সম্পদ।</li>
                        <li>কোর্স মেটারিয়াল অননুমোদিত ছাড়া কপি, বিতরণ বা বিক্রি করা যাবে না।</li>
                        <li>লঙ্ঘন্তের পর কোর্সে অ্যাক্সেস থাকলেও কন্টেন্ট ব্যবহার করা যাবে না।</li>
                    </ul>
                </div>

                <!-- Certificates -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৭. সার্টিফিকেট</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>সার্টিফিকেট পেতে কোর্স সম্পূর্ণ করতে হবে।</li>
                        <li>সমস্ত মডিউল ও অ্যাসাইনমেন্ট সম্পন্ন করতে হবে।</li>
                        <li>সার্টিফিকেট ব্যক্তিগত ও অ-হস্তান্তরযোগ্য।</li>
                        <li>সার্টিফিকেট বাণিজ্যিক উদ্দেশ্যে ব্যবহার করা যাবে।</li>
                    </ul>
                </div>

                <!-- Privacy -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৮. গোপনীয়তা</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>আপনার ব্যক্তিগত তথ্য আমরা সংরক্ষণ করি এবং গোপন রাখি।</li>
                        <li>আপনার তথ্য কখনো তৃতীয় পক্ষে বিক্রি করা হবে না।</li>
                        <li>আমরা কুকিজ ব্যবহার করি যা আমাদের সেবা উন্নত করতে সাহায্য করে।</li>
                        <li>বিস্তারিত জানতে আমাদের গোপনীয়তা নীতি দেখুন।</li>
                    </ul>
                </div>

                <!-- Termination -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">৯. অ্যাকাউন্ট সাসপেনশন বা বাতিল</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>শর্তাবলী লঙ্ঘন করলে আমরা আপনার অ্যাকাউন্ট সাসপেন্ড করতে পারি।</li>
                        <li>অ্যাকাউন্ট সাসপেন্ড করলে চলমান কোর্সে অ্যাক্সেস হারাতে পারেন।</li>
                        <li>অ্যাকাউন্ট যেকোনো সময় বাতিল করতে পারেন।</li>
                    </ul>
                </div>

                <!-- Changes to Terms -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">১০. শর্তাবলী পরিবর্তন</h2>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li>আমরা যেকোনো সময় এই শর্তাবলী পরিবর্তন করতে পারি।</li>
                        <li>পরিবর্তন প্ল্যাটফর্মে পোস্ট করা হলে কার্যকর হবে।</li>
                        <li>গুরুতর পরিবর্তন হলে ইমেইলের মাধ্যমে জানানো হবে।</li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#E2E8F0] mb-4">১১. যোগাযোগ</h2>
                    <p class="leading-relaxed">
                        এই শর্তাবলী সম্পর্কে কোনো প্রশ্ন থাকলে আমাদের সাথে যোগাযোগ করুন:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 leading-relaxed">
                        <li><strong>ইমেইল:</strong> giopioservice@gmail.com</li>
                        <li><strong>ওয়েবসাইট:</strong> <a href="{{ url('/') }}" class="text-[#E850FF] hover:underline">{{ url('/') }}</a></li>
                    </ul>
                </div>

                <!-- Agreement -->
                <div class="bg-[#E850FF]/10 border border-[#E850FF]/30 rounded-lg p-6 mt-8">
                    <p class="text-[#E2E8F0] font-semibold text-lg">
                        ✅ কোর্সে এনরোল করার মাধ্যমে আপনি এই শর্তাবলী ও শর্তাবলী মেনে নিচ্ছেন বলে গণ্য করা হবে।
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('website.partials.footer')

@endsection
