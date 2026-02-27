<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentRequestResource\Pages;
use App\Filament\Resources\EnrollmentRequestResource\RelationManagers;
use App\Models\EnrollmentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentRequestResource extends Resource
{
    protected static ?string $model = EnrollmentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Enrollment Requests';

    protected static ?string $modelLabel = 'Enrollment Request';

    protected static ?int $navigationSort = 15;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Assign to User (Optional)')
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Assign this request to a registered user. Leave empty for guest enrollment.'),
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone/ Payment Number')
                            ->required()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Course & Payment Information')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship(name: 'course', titleAttribute: 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'nagad' => 'Nagad',
                                'bkash' => 'Bkash',
                                'rocket' => 'Rocket',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('payment_number')
                            ->label('Payment Number')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Amount Paid (BDT)')
                            ->required()
                            ->numeric()
                            ->prefix('৳'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Request Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending')
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state === 'rejected') {
                                    $set('rejection_reason', '');
                                }
                            }),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->rows(3)
                            ->visible(function (\Livewire\Forms\Form $form) {
                                return $form->getState()['status'] === 'rejected';
                            })
                            ->helperText('Please provide a reason for rejection.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\BadgeColumn::make('payment_method')
                    ->label('Payment Method')
                    ->colors([
                        'nagad' => 'warning',
                        'bkash' => 'danger',
                        'rocket' => 'purple',
                    ]),
                Tables\Columns\TextColumn::make('payment_number')
                    ->label('Payment Number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label('Amount')
                    ->money('bdt')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => '৳' . number_format($state)),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    ]),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assigned User')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'nagad' => 'Nagad',
                        'bkash' => 'Bkash',
                        'rocket' => 'Rocket',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollmentRequests::route('/'),
            'create' => Pages\CreateEnrollmentRequest::route('/create'),
            'edit' => Pages\EditEnrollmentRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
