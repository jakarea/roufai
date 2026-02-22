<!-- footer section start -->
<footer class="w-full pt-10 lg:pt-20 pb-3 lg:pb-5">
    <div class="container-x">

        <div class="w-full grid grid-cols-2 lg:grid-cols-12 gap-y-10 gap-x-5 lg:gap-x-16 mb-5 lg:mb-10">
            <!-- card -->
            <div class="w-full lg:col-span-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('website-images/logo.svg') }}" alt="logo white" class="w-full max-w-[108px]">
                </a>
                <p class="text-[#ABABAB] font-normal text-base mt-5 mb-3 lg:mt-[30px] lg:mb-5">বাংলাদেশের শীর্ষ এআই
                    ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম</p>

                <p class="text-[#ABABAB] mt-[20px] lg:mt-7 font-normal text-sm font-golos">আমাদের সাথে যুক্ত হন</p>

                <ul class="flex items-center justify-center gap-x-2.5 mt-2.5 lg:justify-start">
                    <li>
                        <a href="#" class="block w-[30px] h-[30px] rounded-full">
                            <img src="{{ asset('website-images/icons/call.svg') }}" alt="call" class="w-full">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block w-[30px] h-[30px] rounded-full">
                            <img src="{{ asset('website-images/icons/mail.svg') }}" alt="call" class="w-full">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block w-[30px] h-[30px] rounded-full">
                            <img src="{{ asset('website-images/icons/linkedin.svg') }}" alt="call" class="w-full">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block w-[30px] h-[30px] rounded-full">
                            <img src="{{ asset('website-images/icons/facebook.svg') }}" alt="call" class="w-full">
                        </a>
                    </li>
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-2">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">কুইক লিঙ্কস</h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    <li><a href="{{ route('home') }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">হোম</a>
                    </li>
                    <li><a href="{{ route('courses') }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">কোর্স
                            সমূহ </a></li>
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">আমাদের
                            সম্পর্কে</a></li>
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-3">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">যোগাযোগ করুন</h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">ঢাকা,
                            বাংলাদেশ</a>
                    </li>
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">+880
                            1712-345678</a></li>
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">info@roufai.com</a>
                    </li>
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-3">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">কোর্স সমূহ </h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                            Creative Mastery</a>
                    </li>
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">Prompt
                            Engineering Pro</a></li>
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                            Video & Content Lab</a></li>
                </ul>
            </div>
            <!-- card -->
        </div>

        <div
            class="w-full border-t border-[#232323] flex justify-center flex-col items-center lg:flex-row lg:justify-between lg:items-center gap-y-4 lg:gap-x-4 lg:gap-y-0 mt-3 pt-3 lg:mt-4 lg:pt-4">
            <p class="font-normal text-sm lg:text-base text-[#ABABAB]">&copy; {{ date('Y') }} Rouf AI - সর্বস্বত্ব সংরক্ষিত।
            </p>
            <p class="font-normal text-sm lg:text-base text-[#ABABAB]">Developed with ❤️ by Giopio</p>
        </div>
    </div>
</footer>
<!-- footer section end -->
