<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
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
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('registration_id')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('admission_session_id')
                    ->label('Admission Session')
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
                Action::make('approvePayment')
                    ->label('Approve Payment')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Application $record) => $record->payment_status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Application $record) {
                        $regId = 'REG-' . date('Y') . '-' . str_pad($record->id, 5, '0', STR_PAD_LEFT);
                        $record->update([
                            'payment_status' => 'approved',
                            'registration_id' => $regId,
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Payment Approved')
                            ->body("Registration ID: $regId generated.")
                            ->success()
                            ->send();
                    }),
                Action::make('denyPayment')
                    ->label('Deny Payment')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Application $record) => $record->payment_status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Application $record) {
                        $record->update([
                            'payment_status' => 'rejected',
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Payment Denied')
                            ->danger()
                            ->send();
                    }),
            ]);
    }
}
