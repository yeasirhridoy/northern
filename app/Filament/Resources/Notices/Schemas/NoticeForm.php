<?php

namespace App\Filament\Resources\Notices\Schemas;

use Filament\Schemas\Schema;

class NoticeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('notices/images'),
                \Filament\Forms\Components\FileUpload::make('file')
                    ->label('PDF Attachment')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('notices/files'),
                \Filament\Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
