@extends('layouts.website')

@use('Illuminate\Support\Facades\Storage')

@section('title', 'এনরোল করুন - ' . $course->title . ' | আব্দুর রউফ')
@section('description', $course->title . ' কোর্সে এনরোল করুন। ' . ($course->type === 'FREE' ? 'ফ্রি কোর্স' : 'পেইড কোর্স') . ' - লাইভ ক্লাস, ভিডিও টিউটোরিয়াল এবং সার্টিফিকেট সহ কমপ্লিট লার্নিং।')
@section('keywords', $course->title . ', কোর্স এনরোলমেন্ট, AI কোর্স ভর্তি, ' . ($course->type === 'FREE' ? 'ফ্রি AI কোর্স' : 'পেইড AI কোর্স'))

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- Course Enrollment Section -->
<section class="w-full py-10 lg:py-16 relative min-h-screen">
    <div class="container-x">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-[#ABABAB] hover:text-white">হোম</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li><a href="{{ route('courses') }}" class="text-[#ABABAB] hover:text-white">কোর্সসমূহ</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li><a href="{{ route('courses.overview', ['slug' => $course->slug]) }}" class="text-[#ABABAB] hover:text-white">{{ $course->title }}</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li class="text-white">এনরোলমেন্ট</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Content -->
            <div class="lg:col-span-2">
                <h1 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] mb-4">
                    {{ $course->type === 'FREE' ? 'ফ্রি কোর্সে এনরোল করুন' : 'কোর্স এনরোলমেন্ট - পেমেন্ট তথ্য' }}
                </h1>

                @if($course->type === 'FREE')
                    <!-- Free Course Enrollment -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-8 text-center">
                        <div class="w-20 h-20 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="font-bold text-2xl text-[#E2E8F0] mb-4">{{ $course->title }}</h2>
                        <p class="text-[#ABABAB] mb-6">
                            এটি একটি ফ্রি কোর্স। নিচের বাটনে ক্লিক করে আপনি সাথে সাথে এনরোল করতে পারবেন এবং কোর্সের সকল কন্টেন্ট অ্যাক্সেস করতে পারবেন।
                        </p>

                        <form id="free-enroll-form" method="POST" action="{{ route('courses.enroll', $course->id) }}">
                            @csrf
                            <button type="submit" id="free-enroll-btn"
                                class="bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold text-lg py-4 px-8 rounded-lg transition-all duration-300">
                                এনরোল করুন
                            </button>
                        </form>

                        <!-- Message Container -->
                        <div id="free-enrollment-message" class="hidden mt-6 p-4 rounded-lg"></div>
                    </div>
                @else
                    <!-- Paid Course Enrollment Form -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6 mb-6">
                        <h2 class="font-semibold text-xl text-[#E2E8F0] mb-2">কোর্স ফি পরিশোধ করুন</h2>
                        <p class="text-[#ABABAB] mb-6">আপনার এনরোলমেন্ট সম্পন্ন করতে নিচের ধাপগুলো অনুসরণ করুন:</p>

                        <!-- Payment Instructions -->
                        <div class="bg-[#131620] rounded-lg p-5 mb-6">
                            <h3 class="font-semibold text-[#E2E8F0] mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                পেমেন্ট নির্দেশাবলী
                            </h3>
                            <ul class="space-y-3 text-sm text-[#ABABAB]">
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>কোর্সের মূল্য: <span class="text-[#E850FF] font-semibold">৳{{ number_format($course->price) }}</span></p>
                                </li>
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>আপনার পছন্দের মোবাইল ব্যাংকিং সার্ভিস নির্বাচন করুন</p>
                                </li>
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>Send Money অপশনে গিয়ে নির্দিষ্ট নম্বরে টাকা পাঠান</p>
                                </li>
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>পেমেন্ট সম্পন্ন হলে ট্রানজেকশন ID সহ নিচের ফর্মটি পূরণ করুন</p>
                                </li>
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>সফল পেমেন্টে SMS/ইমেইল পাবেন</p>
                                </li>
                                <li class="flex items-start gap-x-2">
                                    <span class="w-[2px] h-[2px] block bg-[#D9D9D9] mt-2 lg:w-[3px] lg:h-[3px]"></span>
                                    <p>টাকা ফেরতযোগ্য নয়, সমস্যায় <a href="#" class="text-[#E850FF] underline">সাপোর্টে যোগাযোগ করুন</a></p>
                                </li>
                            </ul>
                        </div>

                        <!-- Payment Form -->
                        <h5 class="font-medium text-base text-[#E2E8F0] text-center mb-2.5 lg:text-lg lg:text-start">
                            আপনার পেমেন্ট করা মাধ্যমটি বেছে নিন
                        </h5>

                        <form id="course-enrollment-form" method="POST"
                            class="block mt-5 lg:mt-3 lg:grid lg:grid-cols-12 lg:gap-x-5">
                            @csrf

                            <div class="flex w-full justify-center lg:justify-start items-center gap-x-2 lg:gap-x-5 lg:gap-x-6 lg:mb-[60px] lg:col-span-12">
                                <label for="nagad" class="flex items-center bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                                    <input type="radio" name="payment_method" id="nagad" value="nagad" checked>
                                    <img src="{{ asset('website-images/icons/nagad.svg') }}" alt="nagad" class="max-w-14 lg:max-w-20">
                                </label>
                                <label for="bkash" class="flex items-center bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                                    <input type="radio" name="payment_method" id="bkash" value="bkash">
                                    <img src="{{ asset('website-images/icons/bkash.svg') }}" alt="bkash" class="max-w-14 lg:max-w-20">
                                </label>
                                <label for="rocket" class="flex items-center bg-card anim cursor-pointer px-2 gap-x-2 w-24 h-12">
                                    <input type="radio" name="payment_method" id="rocket" value="rocket">
                                    <img src="{{ asset('website-images/icons/rocket.svg') }}" alt="rocket" class="max-w-10 lg:max-w-12.5">
                                </label>
                            </div>

                            <div class="w-full mt-5 lg:col-span-6">
                                <label for="payment_number" class="font-medium text-base text-[#E2E8F0] block w-full mb-2.5">
                                    আপনার পেমেন্ট নম্বর
                                </label>
                                <input type="text" name="payment_number" id="payment_number" placeholder="আপনার মোবাইল নম্বর"
                                    class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                    required>
                            </div>

                            <div class="w-full mt-5 lg:col-span-6">
                                <label for="paid_amount" class="font-medium text-base text-[#E2E8F0] block w-full mb-2.5">
                                    পেমেন্ট পরিমাণ (টাকা)
                                </label>
                                <input type="number" name="paid_amount" id="paid_amount" placeholder="{{ $course->price }}" value="{{ $course->price }}"
                                    class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                    required>
                            </div>

                            <div class="w-full mt-5 lg:col-span-12">
                                <label for="transaction_id" class="font-medium text-base text-[#E2E8F0] block w-full mb-2.5">
                                    পেমেন্ট ট্রানজেকশন ID
                                </label>
                                <input type="text" name="transaction_id" id="transaction_id" placeholder="ট্রানজেকশন ID"
                                    class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                    required>
                            </div>

                            <div class="w-full flex justify-center lg:col-span-12 lg:justify-end">
                                <button type="button" id="submit-enrollment-btn"
                                    class="bg-[#E850FF] hover:bg-[#4941C8] text-white font-medium text-base py-2 px-4 mt-5 anim cursor-pointer lg:text-xl lg:py-3.5 lg:px-6 rounded-[10px] transition-all duration-300">
                                    কনফার্ম করুন
                                </button>
                            </div>
                        </form>

                        <!-- Message Container -->
                        <div id="enrollment-message" class="hidden mt-5 p-4 rounded-lg"></div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Course Card -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6">
                        <!-- Course Thumbnail -->
                        <img src="{{ $course->thumbnail_path ? Storage::url($course->thumbnail_path) : asset('website-images/default-course-thumbnail.webp') }}"
                            alt="{{ $course->title }}"
                            class="w-full h-48 object-cover rounded-lg mb-4">

                        <!-- Course Title -->
                        <h3 class="font-bold text-lg text-[#E2E8F0] mb-3">{{ $course->title }}</h3>

                        <!-- Price -->
                        <div class="mb-4">
                            @if($course->type === 'FREE')
                                <span class="text-3xl font-bold text-[#E2E8F0]">ফ্রি</span>
                            @else
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl font-bold text-[#E2E8F0]">৳{{ number_format($course->price) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Course Info -->
                        <div class="space-y-3 text-sm text-[#ABABAB] border-t border-white/10 pt-4">
                            @if($course->category)
                            <div class="flex items-center gap-3">
                                <span>📁</span>
                                <span>{{ $course->category->name }}</span>
                            </div>
                            @endif
                            <div class="flex items-center gap-3">
                                <span>👨‍🏫</span>
                                <span>{{ $course->instructor->name ?? 'ইন্সট্রাক্টর' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Free course enrollment
        @if($course->type === 'FREE')
        const freeEnrollForm = document.getElementById('free-enroll-form');
        if (freeEnrollForm) {
            freeEnrollForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const submitBtn = document.getElementById('free-enroll-btn');
                const messageContainer = document.getElementById('free-enrollment-message');

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.textContent = 'প্রসেসিং হচ্ছে...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    messageContainer.classList.remove('hidden');

                    if (data.success) {
                        messageContainer.className = 'mt-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50';
                        messageContainer.innerHTML = `
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-green-400 font-medium text-lg">${data.message}</p>
                            </div>
                        `;

                        // Redirect after 2 seconds
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    } else {
                        messageContainer.className = 'mt-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50';
                        messageContainer.innerHTML = `
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-red-400 font-medium text-lg">${data.message || 'দুঃখিত, এনরোলমেন্ট সম্ভব হয়নি।'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageContainer.classList.remove('hidden');
                    messageContainer.className = 'mt-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50';
                    messageContainer.innerHTML = `
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-red-400 font-medium text-lg">দুঃখিত, একটি ত্রুটি হয়েছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।</p>
                        </div>
                    `;
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'এনরোল করুন';
                });
            });
        }
        @else
        // Paid course enrollment
        function showMessage(message, isSuccess) {
            const messageContainer = document.getElementById('enrollment-message');
            if (!messageContainer) return;

            messageContainer.classList.remove('hidden');

            if (isSuccess) {
                messageContainer.className = 'mt-5 p-4 rounded-lg text-center bg-green-500/20 border border-green-500/50';
                messageContainer.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-400 font-medium text-lg">${message}</p>
                    </div>
                `;
            } else {
                messageContainer.className = 'mt-5 p-4 rounded-lg text-center bg-red-500/20 border border-red-500/50';
                messageContainer.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-red-400 font-medium text-lg">${message}</p>
                    </div>
                `;
            }

            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, 5000);
        }

        const submitEnrollmentBtn = document.getElementById('submit-enrollment-btn');
        if (submitEnrollmentBtn) {
            submitEnrollmentBtn.addEventListener('click', function(e) {
                e.preventDefault();

                const enrollmentMessage = document.getElementById('enrollment-message');
                if (enrollmentMessage) {
                    enrollmentMessage.classList.add('hidden');
                }

                const form = document.getElementById('course-enrollment-form');
                if (!form) return;

                const formData = new FormData(form);
                const submitBtn = this;

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethod) {
                    showMessage('অনুগ্রহ করে পেমেন্টের মাধ্যম নির্বাচন করুন', false);
                    return;
                }

                const paymentNumber = formData.get('payment_number');
                const transactionId = formData.get('transaction_id');
                const paidAmount = formData.get('paid_amount');

                if (!paymentNumber || !transactionId || !paidAmount) {
                    showMessage('অনুগ্রহ করে সকল তথ্য পূরণ করুন', false);
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.textContent = 'জমা হচ্ছে...';

                const data = {
                    payment_method: paymentMethod.value,
                    payment_number: paymentNumber,
                    transaction_id: transactionId,
                    paid_amount: paidAmount
                };

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showMessage(result.message, true);
                        form.reset();
                        const nagadRadio = document.getElementById('nagad');
                        if (nagadRadio) nagadRadio.checked = true;

                        setTimeout(() => {
                            window.location.href = result.redirect;
                        }, 2000);
                    } else {
                        showMessage(result.message || 'দুঃখিত, আপনার রিকোয়েস্ট জমা দেওয়া যায়নি।', false);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('দুঃখিত, একটি ত্রুটি হয়েছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।', false);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'কনফার্ম করুন';
                });
            });
        }
        @endif
    });
</script>
@endsection

@include('website.partials.footer')
@endsection
