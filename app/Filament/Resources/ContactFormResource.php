<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactFormResource\Pages;
use App\Models\ContactForm;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Component as Livewire;

class ContactFormResource extends Resource
{
    use Translatable;

    protected static ?string $model = ContactForm::class;

    protected static ?string $modelLabel = 'Formulaire';

    protected static ?string $navigationLabel = 'Formulaires';

    protected static ?string $navigationGroup = 'Formulaires';

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__("Form name"))
                    ->required(),
                TextInput::make('subject')
                    ->label(__('Subject'))
                    ->required(),
                TextInput::make('recipients')
                    ->label(__('Recipients'))
                    ->helperText(__('Split emails with a comma'))
                    ->required(),
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Form fields'))
                            ->schema([
                                Builder::make('fields')
                                    ->label('')
                                    ->addActionLabel('Ajouter un nouveau champ')
                                    ->blockNumbers(false)
                                    ->blockPickerColumns(3)
                                    ->collapsible()
                                    ->cloneable()
                                    ->collapsed()
                                    ->blocks([
                                        Builder\Block::make('text')
                                            ->label(fn(?array $state): string => $state['label'] ?? 'Champ de texte')
                                            ->icon('heroicon-o-document-text')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Label')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                                Select::make('type')->options(['text' => 'Texte', 'email' => 'Email'])->required(),
                                                TextInput::make('mask')
                                                    ->label(__('Mask'))
                                                    ->helperText(__('If necessary, enter the format to check when validating the field')),
                                                Checkbox::make('required')->label(__('Required field')),
                                                Toggle::make('fullWidth')->label(__('Full width'))->default(false),
                                            ])
                                            ->columns(2),
                                        Builder\Block::make('textarea')
                                            ->label(fn(?array $state): string => $state['label'] ?? 'Zone de texte')
                                            ->icon('heroicon-o-bars-3-bottom-left')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Label')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                                Checkbox::make('required')->label(__('Required field')),
                                                Toggle::make('fullWidth')->label(__('Full width'))->default(false),
                                            ])
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                        Builder\Block::make('choices')
                                            ->label(fn(?array $state): string => $state['label'] ?? __('Multiple choices'))
                                            ->icon('heroicon-o-list-bullet')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Label')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                                KeyValue::make('values')->label(__('Available values'))->required(),
                                                Select::make('type')->options(['checkbox' => __('Checkboxes'), 'radio' => __('Radio buttons'), 'select' => __('Select list')])->required(),
                                                Checkbox::make('required')->label(__('Required field')),
                                                Toggle::make('fullWidth')->label(__('Full width'))->default(false),
                                            ]),
                                        Builder\Block::make('file')
                                            ->label(fn(?array $state): string => $state['label'] ?? __('File'))
                                            ->icon('heroicon-o-arrow-up-on-square')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Label')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                                TextInput::make('format')
                                                    ->label(__('Authorized formats'))
                                                    ->helperText(__('Split with commas. ex: jpg,png')),
                                                Checkbox::make('required')->label(__('Required field')),
                                                Toggle::make('fullWidth')->label(__('Full width'))->default(false),
                                            ]),
                                        Builder\Block::make('optin')
                                            ->label(fn(?array $state): string => $state['label'] ?? __('Consent'))
                                            ->icon('heroicon-o-check-badge')
                                            ->schema([
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                                RichEditor::make('text')
                                                    ->label('Texte'),
                                                Checkbox::make('required')->label(__('Required field')),
                                                Toggle::make('fullWidth')->label(__('Full width'))->default(false),
                                            ]),

                                    ])->columnSpan(2),
                            ]),
                        Tabs\Tab::make(__('Email template'))
                            ->schema([
                                RichEditor::make('template')
                                    ->helperText(function (Livewire $livewire) {
                                        $tags = [];
                                        foreach ($livewire->data['fields'] as $field) {
                                            if (empty($field['data']['slug'])) continue;
                                            if ($field['type'] == 'file') continue;
                                            $tags[] = "[[" . $field['data']['slug'] . "]]";
                                        }
                                        return count($tags) ? __('Available tags : ') . implode(', ', $tags) : '';
                                    })
                                    ->label('')
                                    ->toolbarButtons([
                                        'bold',
                                        'bulletList',
                                        'orderedList',
                                        'italic',
                                        'link',
                                    ])
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListContactForms::route('/'),
            'create' => Pages\CreateContactForm::route('/create'),
            'edit' => Pages\EditContactForm::route('/{record}/edit'),
        ];
    }
}
