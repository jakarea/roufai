<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Users';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Select::make('role')
                            ->options([
                                'student' => 'Student',
                                'instructor' => 'Instructor',
                                'admin' => 'Admin',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(6)
                            ->same('passwordConfirmation')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->password()
                            ->dehydrated(false)
                            ->label('Confirm Password')
                            ->minLength(6)
                            ->required(fn (string $context): bool => $context === 'create')
                            ->columnSpan(2),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Bio (Instructor)')
                            ->rows(3)
                            ->placeholder('Brief biography for instructors')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('payment_details')
                            ->label('Payment Details (Instructor)')
                            ->rows(2)
                            ->placeholder('Bkash/Nagad number for receiving payments')
                            ->helperText('Only needed for instructors with paid courses')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->visible(fn (callable $get) => in_array($get('role'), ['instructor', 'admin'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email')
                    ->copyable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'success' => 'admin',
                        'warning' => 'instructor',
                        'primary' => 'student',
                    ])
                    ->sortable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('courses_count')
                    ->label('Courses')
                    ->counts('courses')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'instructor' => 'Instructor',
                        'admin' => 'Admin',
                    ])
                    ->label('Filter by Role'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
