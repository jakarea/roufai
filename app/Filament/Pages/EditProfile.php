<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Edit Profile';

    protected static bool $isNavigationDisabled = true; // Hide from sidebar, only accessible from View Profile

    protected static string $view = 'filament.pages.edit-profile';

    protected static bool $isLazy = false;

    public static function getRoute(): string
    {
        return '/profile/edit';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $user->bio,
            'payment_details' => $user->payment_details,
        ]);
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();

        return $form
            ->schema([
                Section::make('Personal Information')
                    ->description('Update your personal details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->description('Extra details based on your role')
                    ->schema([
                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(4)
                            ->placeholder('Tell us about yourself...')
                            ->visible(fn () => $user->role === 'instructor' || $user->role === 'admin')
                            ->columnSpanFull(),
                        Textarea::make('payment_details')
                            ->label('Payment Details (Bkash/Nagad)')
                            ->rows(2)
                            ->placeholder('Enter your Bkash or Nagad number for receiving payments')
                            ->helperText('This information will be shown to students when they enroll in your paid courses')
                            ->visible(fn () => $user->role === 'instructor')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->visible(fn () => $user->role !== 'student'),

                Section::make('Change Password')
                    ->description('Leave empty if you don\'t want to change your password')
                    ->schema([
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->minLength(6)
                            ->dehydrated(fn ($state) => filled($state))
                            ->columnSpan(2),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->minLength(6)
                            ->same('new_password')
                            ->dehydrated(false)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        // Update basic info
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Update role-specific fields
        if ($user->role === 'instructor' || $user->role === 'admin') {
            $user->bio = $data['bio'] ?? null;
        }

        if ($user->role === 'instructor') {
            $user->payment_details = $data['payment_details'] ?? null;
        }

        // Update password if provided
        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        Notification::make()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.')
            ->success()
            ->send();

        redirect()->route('filament.admin.pages.view-profile');
    }
}
