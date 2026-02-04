<x-filament-panels::page>
    @if (filament()->hasLogin())
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        My Profile
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        View and manage your account information
                    </p>
                </div>
                <a href="{{ route('filament.admin.pages.edit-profile') }}"
                   class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profile
                </a>
            </div>
        </x-slot>
    @endif

    <div class="space-y-6">
        {{ \Filament\Infolists\Infolist::make()
            ->state($this->user)
            ->schema($this->infolist(\Filament\Infolists\Infolist::make())->getSchema())
        }}
    </div>

    <div class="mt-8 p-6 bg-gradient-to-r from-primary-500 to-purple-600 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
            <div class="text-white">
                <h3 class="text-xl font-bold">Need to update your information?</h3>
                <p class="mt-1 text-primary-100">
                    Keep your profile up to date to get the most out of the platform.
                </p>
            </div>
            <a href="{{ route('filament.admin.pages.edit-profile') }}"
               class="inline-flex items-center px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Now
            </a>
        </div>
    </div>
</x-filament-panels::page>
