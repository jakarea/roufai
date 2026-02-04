<?php

namespace App\Filament\Instructor\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class InstructorProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.instructor.pages.profile';

    protected static bool $isGloballySearchable = false;

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

                \Filament\Forms\Components\Section::make('Instructor Information')
                    ->description('Details visible to students')
                    ->schema([
                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(3)
                            ->placeholder('Tell students about yourself, your experience, and expertise...')
                            ->columnSpanFull(),
                        Textarea::make('payment_details')
                            ->label('Payment Details')
                            ->rows(2)
                            ->placeholder('Your Bkash/Nagad number for receiving payments')
                            ->helperText('This information is only shown to admin')
                            ->columnSpanFull(),
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
        $user->save();

        Notification::make()
            ->title('Profile Updated')
            ->success()
            ->send();

        $this->mount();
    }
}
