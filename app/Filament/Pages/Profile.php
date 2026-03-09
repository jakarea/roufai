<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.profile';

    protected static bool $isNavigationDisabled = true;

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'bio' => $user->bio,
            'payment_details' => $user->payment_details,
        ]);
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();

        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Personal Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignorable: Auth::user())
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('e.g., 01712345678')
                            ->columnSpan(2),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(2)
                            ->placeholder('Your address')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                \Filament\Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(3)
                            ->placeholder('Brief biography...')
                            ->columnSpanFull(),
                        Textarea::make('payment_details')
                            ->label('Payment Details')
                            ->rows(2)
                            ->placeholder('Payment information (if applicable)')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                \Filament\Forms\Components\Section::make('Change Password')
                    ->description('Leave empty if you don\'t want to change your password')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->required(fn ($get) => filled($get('new_password')))
                            ->rules(fn ($get) => [
                                function ($attribute, $value, $fail) use ($get) {
                                    if (filled($get('new_password')) && !Hash::check($value, Auth::user()->password)) {
                                        $fail('The current password is incorrect.');
                                    }
                                },
                            ]),
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->rules([Password::defaults()])
                            ->dehydrated(fn ($state) => filled($state))
                            ->columnSpanFull()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('current_password', null)),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(false)
                            ->same('new_password')
                            ->columnSpanFull()
                            ->required(fn ($get) => filled($get('new_password'))),
                    ])
                    ->columns(1),
            ])
            ->statePath('data')
            ->model(Auth::user());
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save Changes')
                ->color('primary')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->bio = $data['bio'];
        $user->payment_details = $data['payment_details'];

        // Update password if provided
        if (filled($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        Notification::make()
            ->title('Profile Updated')
            ->success()
            ->send();

        // Redirect to login to force re-authentication after password change
        if (filled($data['new_password'])) {
            Auth::logout();
            Notification::make()
                ->title('Password Changed')
                ->body('Please log in again with your new password.')
                ->warning()
                ->send();

            redirect()->route('login');
            return;
        }

        $this->mount();
    }
}
