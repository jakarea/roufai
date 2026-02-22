<!-- header section start -->
<header class="w-full pt-5 lg:pt-10 relative z-[9999]">
    <div class="container-x">
        <div class="w-full grid grid-cols-12 relative bg-[#000]/40 rounded-md p-2 lg:p-2.5 lg:rounded-[14px] lg:items-center lg:px-5">
            <!-- logo -->
            <div class="text-start col-span-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('website-images/logo.png') }}" alt="logo" class="max-w-20 md:max-w-[95px] lg:max-w-[110px]">
                </a>
            </div>
            <!-- logo -->

            <div class="navbar flex flex-col gap-y-4 justify-center items-center col-span-10 lg:flex-row">
                <!-- menu -->
                <div class="w-full absolute left-0 top-10 min-h-[130px] bg-card z-50 flex justify-center p-4 rounded-md hidden lg:!flex lg:relative lg:bg-transparent lg:min-h-auto lg:left-auto lg:top-auto min-w-[75%]" id="mobile-menu">
                    <ul class="flex flex-col lg:flex-row gap-y-3 lg:gap-y-0 lg:gap-x-[30px] text-center">
                        <li>
                            <a href="{{ route('home') }}" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('home') ? 'text-[#fff]' : '' }}">
                                হোম
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                কোর্সসমূহ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff]">
                                এক্সপার্ট কানেকশন
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff]">
                                AI আপডেট
                            </a>
                        </li> 
                    </ul>
                </div>
                <!-- menu -->

                <!-- actions -->
                <div class="w-full lg:min-w-[25%]">
                    <ul class="flex gap-x-3 lg:gap-x-[30px] text-center items-center justify-end">
                        {{-- Search Icon --}}
                        <li>
                            <button type="button" id="search-toggle" class="block text-[#ABABAB] hover:text-[#fff] anim cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 lg:w-6 lg:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </li>
                        
                        @if (auth()->user() && auth()->user()->user_role == 'instructor')
                            <li>
                                <a href="{{ route('instructor.dashboard') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                    প্রশিক্ষক প্যানেল
                                </a>
                            </li>
                        @elseif (auth()->user() && auth()->user()->user_role == 'student')
                            <li>
                                <a href="{{ route('student.dashboard') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                    ড্যাশবোর্ড
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim hover:!bg-lime md:text-base px-3 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5 lg:pr-4">
                                    লগইন করুন
                                    <svg class="w-5 lg:w-8" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="29.5" width="29" height="29" rx="14.5" transform="rotate(-90 0.5 29.5)" stroke="white" />
                                        <path d="M18.3154 16.9887L18.3154 11.6854M18.3154 11.6854L13.0121 11.6854M18.3154 11.6854L11.6862 18.3146" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                        @endif
                        <li class="lg:hidden">
                            <button type="button" id="mobile-menu-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#fff]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
                <!-- actions -->
            </div>
        </div>
    </div>
</header>
<!-- header section end -->

<!-- Search Overlay -->
<div id="search-overlay" class="fixed inset-0 w-full h-full bg-[#0A0C19]/70 backdrop-blur-md z-[99999] hidden opacity-0 transition-opacity duration-300">
    <div class="w-full h-full flex items-center justify-center p-4">
        <div class="w-full max-w-3xl">
            <!-- Close Button -->
            <div class="flex justify-end mb-8">
                <button type="button" id="search-close" class="text-[#fff] hover:text-[#E850FF] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('courses') }}" method="GET" class="w-full">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        id="search-input"
                        placeholder="কোর্স খুঁজুন..." 
                        class="w-full bg-[#131620] border-2 border-[#E850FF]/30 rounded-lg lg:rounded-2xl py-4 lg:py-6 px-6 lg:px-8 text-[#fff] text-lg lg:text-2xl placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        class="absolute cursor-pointer right-4 lg:right-6 top-1/2 -translate-y-1/2 bg-[#E850FF] hover:bg-[#4941C8] text-[#fff] rounded-lg px-6 lg:px-8 py-2 lg:py-3 font-medium text-base lg:text-lg transition-all duration-300"
                    >
                        খুঁজুন
                    </button>
                </div>
            </form>
            
            <!-- Popular Searches (Optional) -->
            <div class="mt-8 lg:mt-12">
                <p class="text-[#ABABAB] text-sm lg:text-base mb-4">জনপ্রিয় সার্চ:</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('courses') }}?search=AI" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        AI
                    </a>
                    <a href="{{ route('courses') }}?search=ভিডিও" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        ভিডিও এডিটিং
                    </a>
                    <a href="{{ route('courses') }}?search=ইমেজ" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        ইমেজ জেনারেশন
                    </a>
                    <a href="{{ route('courses') }}?search=মিউজিক" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        মিউজিক
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Search overlay toggle
    const searchToggle = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    function openSearch() {
        searchOverlay.classList.remove('hidden');
        // Trigger reflow to enable transition
        searchOverlay.offsetHeight;
        searchOverlay.classList.remove('opacity-0');
        searchOverlay.classList.add('opacity-100');
        // Focus on input after animation
        setTimeout(() => {
            searchInput.focus();
        }, 300);
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeSearch() {
        searchOverlay.classList.remove('opacity-100');
        searchOverlay.classList.add('opacity-0');
        setTimeout(() => {
            searchOverlay.classList.add('hidden');
        }, 300);
        // Restore body scroll
        document.body.style.overflow = '';
    }

    if (searchToggle && searchOverlay && searchClose) {
        searchToggle.addEventListener('click', openSearch);
        searchClose.addEventListener('click', closeSearch);
        
        // Close on overlay click (outside search box)
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !searchOverlay.classList.contains('hidden')) {
                closeSearch();
            }
        });
    }
});
</script>
