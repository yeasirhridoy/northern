<?php

namespace App\Filament\Resources\Applications\Infolists;

use Filament\Schemas\Schema;
use Filament\Schemas\Components as SchemaComponents;
use Filament\Infolists\Components as InfolistComponents;
use Filament\Support\Enums\FontWeight;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                SchemaComponents\Grid::make(3)
                    ->schema([
                        SchemaComponents\Group::make([
                            SchemaComponents\Section::make('Application Status')
                                ->schema([
                                    InfolistComponents\TextEntry::make('status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'draft' => 'gray',
                                            'submitted' => 'info',
                                            'under_review' => 'warning',
                                            'waitlisted' => 'primary',
                                            'offered' => 'success',
                                            'rejected' => 'danger',
                                            'admitted' => 'success',
                                            default => 'gray',
                                        }),
                                    InfolistComponents\TextEntry::make('merit_score')
                                        ->weight(FontWeight::Bold)
                                        ->color('primary'),
                                    InfolistComponents\TextEntry::make('assignedSubject.name')
                                        ->label('Assigned Subject')
                                        ->placeholder('Not Assigned Yet')
                                        ->weight(FontWeight::Bold),
                                    InfolistComponents\TextEntry::make('admin_remarks')
                                        ->label('Admin Remarks')
                                        ->placeholder('No remarks')
                                        ->columnSpanFull(),
                                ])->columns(1),
                        ])->columnSpan(1),

                        SchemaComponents\Group::make([
                            SchemaComponents\Section::make('Payment & Registration')
                                ->schema([
                                    InfolistComponents\TextEntry::make('payment_status')
                                        ->badge()
                                        ->colors([
                                            'warning' => 'pending',
                                            'success' => 'approved',
                                            'danger' => 'rejected',
                                        ]),
                                    InfolistComponents\TextEntry::make('registration_id')
                                        ->label('Registration ID')
                                        ->placeholder('Pending Approval')
                                        ->copyable(),
                                    InfolistComponents\TextEntry::make('payment_method')
                                        ->label('Method'),
                                    InfolistComponents\TextEntry::make('payment_trx_id')
                                        ->label('Transaction ID'),
                                ])->columns(2),
                        ])->columnSpan(1),
                    ])->columns(2)->columnSpanFull(),

                SchemaComponents\Tabs::make('Detailed Information')
                    ->tabs([
                        SchemaComponents\Tabs\Tab::make('Personal Details')
                            ->schema([
                                InfolistComponents\TextEntry::make('user.name')->label('Applicant Name'),
                                InfolistComponents\TextEntry::make('user.email')->label('Email Address'),
                                InfolistComponents\TextEntry::make('phone'),
                                InfolistComponents\TextEntry::make('dob')->label('Date of Birth')->date(),
                                InfolistComponents\TextEntry::make('father_name'),
                                InfolistComponents\TextEntry::make('mother_name'),
                                InfolistComponents\TextEntry::make('address')->columnSpanFull(),
                            ])->columns(2),

                        SchemaComponents\Tabs\Tab::make('Academic Records')
                            ->schema([
                                SchemaComponents\Grid::make(2)
                                    ->schema([
                                        SchemaComponents\Fieldset::make('SSC / Equivalent')
                                            ->schema([
                                                InfolistComponents\TextEntry::make('ssc_board')->label('Board'),
                                                InfolistComponents\TextEntry::make('ssc_year')->label('Year'),
                                                InfolistComponents\TextEntry::make('ssc_roll')->label('Roll'),
                                                InfolistComponents\TextEntry::make('ssc_gpa')->label('GPA')->weight(FontWeight::Bold),
                                            ])->columns(4),

                                        SchemaComponents\Fieldset::make('HSC / Equivalent')
                                            ->schema([
                                                InfolistComponents\TextEntry::make('hsc_board')->label('Board'),
                                                InfolistComponents\TextEntry::make('hsc_year')->label('Year'),
                                                InfolistComponents\TextEntry::make('hsc_group')->label('Group'),
                                                InfolistComponents\TextEntry::make('hsc_gpa')->label('GPA')->weight(FontWeight::Bold),
                                            ])->columns(4),
                                    ]),
                            ]),

                        SchemaComponents\Tabs\Tab::make('Subject Preferences')
                            ->schema([
                                InfolistComponents\RepeatableEntry::make('preferences')
                                    ->schema([
                                        InfolistComponents\TextEntry::make('priority_order')
                                            ->label('Priority')
                                            ->badge(),
                                        InfolistComponents\TextEntry::make('subject.name')
                                            ->label('Subject'),
                                        InfolistComponents\TextEntry::make('subject.department.name')
                                            ->label('Department'),
                                    ])
                                    ->columns(3)
                                    ->grid(1),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
