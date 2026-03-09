<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox as ComponentsCheckbox;
use Filament\Forms\Components\Concerns\CanBeSearchable;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Markdown;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;

use function Laravel\Prompts\select;

class PostForm
{
public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Kiri: Post Details (2/3 lebar)
                Section::make("Post Details")
                    ->description("Fill in the details of the post.")
                    ->icon("heroicon-o-document-text")
                    ->schema([
                        Group::make([
                            TextInput::make("title")
                                ->required()
                                ->minLength(5),
                            TextInput::make("slug")
                                ->required()
                                ->unique(table: 'posts', column: 'slug', ignoreRecord: true),
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->required()
                                ->preload()
                                ->searchable(),
                            ColorPicker::make("color"),
                        ])->columns(2), // Membuat field utama menjadi 2 kolom
                        
                        MarkdownEditor::make("content")
                            ->columnSpanFull(), // Pastikan konten mengambil lebar penuh
                    ])->columnSpan(2),

                // Kanan: Upload & Meta (1/3 lebar)
                Group::make([
                    Section::make("Image Upload")
                        ->icon("heroicon-o-photo")
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    Section::make("Meta Information")
                        ->icon("heroicon-o-bookmark")
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),
                ])->columnSpan(1),
            ])->columns(3); // Membagi seluruh halaman menjadi 3 kolom grid
    }
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             //section 1 - post details
    //             Section::make("Post Details")
    //             ->description("Fill in the details of the post.")
    //             // ->icon(Heroicon::RoketLaunch)
    //             -> icon("heroicon-o-document-text")
    //             ->schema([ 
    //             Group::make([
    //                 TextInput::make("title"),
    //                 TextInput::make("slug"),
    //                 Select::make("category_id")
    //                     ->relationship("category", "name")
    //                     ->preload()
    //                     ->searchable(),
    //                 ColorPicker::make("color"),
    //             ])->columns(2),

    //                 MarkdownEditor::make("content"),
    //             ])->columnSpan(2),

    //             // grouping fields into 2 columns
    //             Group::make([
                    
    //             //section 2
    //             Section::make("Image Upload")
    //             ->schema([
    //                 FileUpload::make("image")
    //                     ->disk("public")
    //                     ->directory("posts"),
    //             ]),

    //             // section 3 - meta
    //             Section::make("Meta Information")
    //                 ->schema([
    //                     TagsInput::make("tags"),
    //                     Checkbox::make("published"),
    //                     DateTimePicker::make("published_at"),
    //                 ]),
    //             ])->columnSpan(1),
    //         ])->columns(3);
    // }
}
