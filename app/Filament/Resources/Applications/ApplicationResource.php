<?php

namespace App\Filament\Resources\Applications;

use App\Filament\Resources\Applications\Pages\CreateApplication;
use App\Filament\Resources\Applications\Pages\EditApplication;
use App\Filament\Resources\Applications\Pages\ListApplications;
use App\Models\Application;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Schemas;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Status & Merit')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'under_review' => 'Under Review',
                                'waitlisted' => 'Waitlisted',
                                'offered' => 'Offered',
                                'rejected' => 'Rejected',
                                'admitted' => 'Admitted',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('merit_score')
                            ->numeric(),
                        Forms\Components\Select::make('assigned_subject_id')
                            ->relationship('assignedSubject', 'name')
                            ->placeholder('None'),
                    ])->columns(3),

                Schemas\Components\Tabs::make('Details')
                    ->tabs([
                        Schemas\Components\Tabs\Tab::make('Personal Info')
                            ->schema([
                                Forms\Components\TextInput::make('father_name')->disabled(),
                                Forms\Components\TextInput::make('mother_name')->disabled(),
                                Forms\Components\DatePicker::make('dob')->disabled(),
                                Forms\Components\TextInput::make('phone')->disabled(),
                                Forms\Components\Textarea::make('address')->disabled()->columnSpanFull(),
                            ])->columns(2),
                        Schemas\Components\Tabs\Tab::make('Academic Info')
                            ->schema([
                                Schemas\Components\Fieldset::make('SSC')
                                    ->schema([
                                        Forms\Components\TextInput::make('ssc_board')->disabled(),
                                        Forms\Components\TextInput::make('ssc_year')->disabled(),
                                        Forms\Components\TextInput::make('ssc_gpa')->disabled(),
                                    ])->columns(3),
                                Schemas\Components\Fieldset::make('HSC')
                                    ->schema([
                                        Forms\Components\TextInput::make('hsc_board')->disabled(),
                                        Forms\Components\TextInput::make('hsc_year')->disabled(),
                                        Forms\Components\TextInput::make('hsc_group')->disabled(),
                                        Forms\Components\TextInput::make('hsc_gpa')->disabled(),
                                    ])->columns(4),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Applicant')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('merit_score')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'waitlisted' => 'Waitlisted',
                        'offered' => 'Offered',
                        'rejected' => 'Rejected',
                        'admitted' => 'Admitted',
                    ]),
                Tables\Columns\TextColumn::make('assignedSubject.name')
                    ->label('Assigned')
                    ->placeholder('N/A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('admission_session_id')
                    ->relationship('session', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('assignSubject')
                    ->label('Assign Subject')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('subject_id')
                            ->label('Subject')
                            ->options(fn (Application $record) => $record->preferences->pluck('subject.name', 'subject_id'))
                            ->required(),
                    ])
                    ->action(function (Application $record, array $data): void {
                        $record->update([
                            'assigned_subject_id' => $data['subject_id'],
                            'status' => 'offered',
                        ]);
                    }),
            ]);
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
            'index' => ListApplications::route('/'),
            'create' => CreateApplication::route('/create'),
            'edit' => EditApplication::route('/{record}/edit'),
        ];
    }
}
