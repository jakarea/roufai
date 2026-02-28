<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - AI কোর্স | আব্দুর রউফ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <!-- Logo -->
            <div class="text-center">
                <img src="{{ asset('website-images/logo.webp') }}" alt="Rouf AI Academy Logo" class="mx-auto h-16 w-auto mb-4">
            </div>

            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Forgot Password?
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    No worries! Enter your email address and we'll send you a reset link.
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" required
                            class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address"
                            value="{{ old('email') }}">
                    </div>
                </div>

                @error('email')
                    <div class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Send Password Reset Link
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 text-sm">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
