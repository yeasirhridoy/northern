<?php

namespace App\Filament\Resources\Applications\Infolists;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class ApplicationInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Grid::make(3)
                    ->schema([
                        Infolists\Components\Group::make([
                            Infolists\Components\Section::make('Application Status')
                                ->schema([
                                    Infolists\Components\TextEntry::make('status')
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
                                    Infolists\Components\TextEntry::make('merit_score')
                                        ->weight(FontWeight::Bold)
                                        ->color('primary'),
                                    Infolists\Components\TextEntry::make('assignedSubject.name')
                                        ->label('Assigned Subject')
                                        ->placeholder('Not Assigned Yet')
                                        ->weight(FontWeight::Bold),
                                ])->columns(1),
                        ])->columnSpan(1),

                        Infolists\Components\Group::make([
                            Infolists\Components\Section::make('Payment & Registration')
                                ->schema([
                                    Infolists\Components\TextEntry::make('payment_status')
                                        ->badge()
                                        ->colors([
                                            'warning' => 'pending',
                                            'success' => 'approved',
                                            'danger' => 'rejected',
                                        ]),
                                    Infolists\Components\TextEntry::make('registration_id')
                                        ->label('Registration ID')
                                        ->placeholder('Pending Approval')
                                        ->copyable(),
                                    Infolists\Components\TextEntry::make('payment_method')
                                        ->label('Method'),
                                    Infolists\Components\TextEntry::make('payment_trx_id')
                                        ->label('Transaction ID'),
                                ])->columns(2),
                        ])->columnSpan(2),
                    ]),

                Infolists\Components\Tabs::make('Detailed Information')
                    ->tabs([
                        Infolists\Components\Tabs\Tab::make('Personal Details')
                            ->schema([
                                Infolists\Components\TextEntry::make('user.name')->label('Applicant Name'),
                                Infolists\Components\TextEntry::make('user.email')->label('Email Address'),
                                Infolists\Components\TextEntry::make('phone'),
                                Infolists\Components\TextEntry::make('dob')->label('Date of Birth')->date(),
                                Infolists\Components\TextEntry::make('father_name'),
                                Infolists\Components\TextEntry::make('mother_name'),
                                Infolists\Components\TextEntry::make('address')->columnSpanFull(),
                            ])->columns(2),

                        Infolists\Components\Tabs\Tab::make('Academic Records')
                            ->schema([
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        Infolists\Components\Fieldset::make('SSC / Equivalent')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('ssc_board')->label('Board'),
                                                Infolists\Components\TextEntry::make('ssc_year')->label('Year'),
                                                Infolists\Components\TextEntry::make('ssc_roll')->label('Roll'),
                                                Infolists\Components\TextEntry::make('ssc_gpa')->label('GPA')->weight(FontWeight::Bold),
                                            ])->columns(4),

                                        Infolists\Components\Fieldset::make('HSC / Equivalent')
                                            ->schema([
                                                Infolists\Components\TextEntry::make('hsc_board')->label('Board'),
                                                Infolists\Components\TextEntry::make('hsc_year')->label('Year'),
                                                Infolists\Components\TextEntry::make('hsc_group')->label('Group'),
                                                Infolists\Components\TextEntry::make('hsc_gpa')->label('GPA')->weight(FontWeight::Bold),
                                            ])->columns(4),
                                    ]),
                            ]),

                        Infolists\Components\Tabs\Tab::make('Subject Preferences')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('preferences')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('priority_order')
                                            ->label('Priority')
                                            ->badge(),
                                        Infolists\Components\TextEntry::make('subject.name')
                                            ->label('Subject'),
                                        Infolists\Components\TextEntry::make('subject.department.name')
                                            ->label('Department'),
                                    ])
                                    ->columns(3)
                                    ->grid(1),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}