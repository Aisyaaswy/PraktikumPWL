<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
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
                                ->rules(["required", "min:5", "max:10"])
                                ->required()
                                ->validationMessages([
                                    "required" => "Title must be filled"
                                ]),
                            TextInput::make("slug")
                                ->rules(["required", "min:3", "max:10"])
                                ->unique()
                                ->validationMessages([
                                    "unique" => "Slug must be unique"
                                ]),
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->options(Category::all()->pluck("name", "id"))
                                ->required()
                                ->validationMessages([
                                    "required" => "Category must be selected"
                                ])
                                // ->preload()
                                ->searchable(),
                            ColorPicker::make("color"),
                        ])->columns(2), 
                        
                        MarkdownEditor::make("content")
                            ->columnSpanFull(), 
                    ])->columnSpan(2),

                
                Group::make([
                    // section 2 - image upload
                    Section::make("Image Upload")
                        ->icon("heroicon-o-photo")
                        ->schema([
                            FileUpload::make("image")
                                ->required()
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
