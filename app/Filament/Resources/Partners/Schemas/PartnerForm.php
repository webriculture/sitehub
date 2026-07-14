<?php

declare(strict_types=1);

namespace App\Filament\Resources\Partners\Schemas;

use App\Tenancy\Tenancy;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Organization')
                    ->components([
                        TextInput::make('name')
                            ->label('Organization name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('website_url')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(50),
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk(config('sitehub.media_disk'))
                            ->directory(fn (): string => Tenancy::current()?->slug.'/partners'),
                        Toggle::make('published')
                            ->default(true)
                            ->helperText('Unpublish to retire a listing without deleting it.'),
                    ]),

                Section::make('Description')
                    ->description('Shown on the site. Provide both languages side by side.')
                    ->components([
                        Textarea::make('description.en')
                            ->label('Description (English)')
                            ->rows(4)
                            ->required(),
                        Textarea::make('description.es')
                            ->label('Descripción (Español)')
                            ->rows(4),
                    ]),

                Section::make('Programs')
                    ->description('The programs or services this partner offers at the center.')
                    ->components([
                        Repeater::make('programs')
                            ->hiddenLabel()
                            ->components([
                                TextInput::make('name.en')
                                    ->label('Program name (English)')
                                    ->required(),
                                TextInput::make('name.es')
                                    ->label('Nombre del programa (Español)'),
                                Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->rows(2),
                                Textarea::make('description.es')
                                    ->label('Descripción (Español)')
                                    ->rows(2),
                            ])
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible(),
                    ]),
            ]);
    }
}
