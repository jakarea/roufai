<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reviews';

    protected static ?string $modelLabel = 'Review';

    protected static ?string $pluralModelLabel = 'Reviews';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Content Moderation';

    // Moderation only - no create/edit
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->required(),
                        Forms\Components\Select::make('course_id')
                            ->relationship('course', 'title')
                            ->disabled()
                            ->required(),
                        Forms\Components\TextInput::make('rating')
                            ->disabled()
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->suffix('★'),
                        Forms\Components\Textarea::make('comment')
                            ->disabled()
                            ->columnSpanFull()
                            ->rows(4),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Review $record): string => $record->user->email)
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(fn (Review $record): string => $record->course->title)
                    ->wrap(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state): string => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Review $record): ?string {
                        if (strlen($record->comment) > 50) {
                            return $record->comment;
                        }
                        return null;
                    })
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Filter by Rating')
                    ->options([
                        '5' => '5 Stars',
                        '4' => '4 Stars',
                        '3' => '3 Stars',
                        '2' => '2 Stars',
                        '1' => '1 Star',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value'])) {
                            $query->where('rating', $data['value']);
                        }
                    }),
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'title')
                    ->label('Filter by Course')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Filter by Student')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('has_comment')
                    ->label('Has Comment')
                    ->placeholder('All reviews')
                    ->trueLabel('With comment')
                    ->falseLabel('Rating only')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('comment')->where('comment', '!=', ''),
                        false: fn (Builder $query) => $query->whereNull('comment')->orWhere('comment', ''),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Review $record) {
                        $record->delete();
                        \Filament\Notifications\Notification::make()
                            ->title('Review Deleted')
                            ->body('The review has been removed.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'view' => Pages\ViewReview::route('/{record}'),
        ];
    }
}
