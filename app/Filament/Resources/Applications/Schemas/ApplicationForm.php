<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms;
use Filament\Schemas;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                                'enrolled' => 'Enrolled',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('merit_score')
                            ->numeric(),
                        Forms\Components\Select::make('assigned_subject_id')
                            ->relationship('assignedSubject', 'name')
                            ->placeholder('None'),
                        Forms\Components\Textarea::make('admin_remarks')
                            ->label('Admin Remarks / Feedback')
                            ->columnSpanFull(),
                    ])->columns(3),

                Schemas\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('payment_method'),
                        Forms\Components\TextInput::make('payment_amount')->numeric(),
                        Forms\Components\TextInput::make('payment_trx_id'),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ]),
                        Forms\Components\TextInput::make('registration_id'),
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
}