<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactFormResource\Pages;
use App\Filament\Resources\ContactFormResource\RelationManagers;
use App\Models\ContactForm;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
                    ->label('Nom du formulaire')
                    ->required(),
                TextInput::make('subject')
                    ->label('Sujet')
                    ->required(),
                TextInput::make('recipients')
                    ->label('Destinataires')
                    ->helperText('Emails séparés par des virgules')
                    ->required(),
                Section::make('Champs du formulaire')
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
                                    ->label(fn(?array $state): ?string => $state['label'] ?? 'Champ de texte')
                                    ->icon('heroicon-o-document-text')
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Label')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        Select::make('type')->options(['text' => 'Texte', 'email' => 'Email'])->required(),
                                        TextInput::make('mask')
                                            ->label('Masque')
                                            ->helperText('Si besoin, renseigner le format à vérifier lors de la validation du champ'),
                                        Checkbox::make('required')->label('Champ requis'),
                                        Toggle::make('fullWidth')->label('Pleine largeur')->default(false),
                                    ]),
                                Builder\Block::make('textarea')
                                    ->label(fn(?array $state): ?string => $state['label'] ?? 'Zone de texte')
                                    ->icon('heroicon-o-bars-3-bottom-left')
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Label')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        Checkbox::make('required')->label('Champ requis'),
                                        Toggle::make('fullWidth')->label('Pleine largeur')->default(false),
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                Builder\Block::make('choices')
                                    ->label(fn(?array $state): ?string => $state['label'] ?? 'Choix multiples')
                                    ->icon('heroicon-o-list-bullet')
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Label')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        KeyValue::make('values')->label('Valeurs possibles')->required(),
                                        Select::make('type')->options(['checkbox' => 'Cases à cocher', 'radio' => 'Boutons radio', 'select' => 'Liste de sélection'])->required(),
                                        Checkbox::make('required')->label('Champ requis'),
                                        Toggle::make('fullWidth')->label('Pleine largeur')->default(false),
                                    ]),
                                Builder\Block::make('file')
                                    ->label(fn(?array $state): ?string => $state['label'] ?? 'Fichier')
                                    ->icon('heroicon-o-arrow-up-on-square')
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Label')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        TextInput::make('format')
                                            ->label('Formats autorisés')
                                            ->helperText('Séparer par des virgules. ex: jpg,png'),
                                        Checkbox::make('required')->label('Champ requis'),
                                        Toggle::make('fullWidth')->label('Pleine largeur')->default(false),
                                    ]),
                                Builder\Block::make('optin')
                                    ->label(fn(?array $state): ?string => $state['label'] ?? 'Consentement')
                                    ->icon('heroicon-o-check-badge')
                                    ->schema([
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required(),
                                        RichEditor::make('text')
                                            ->label('Texte'),
                                        Checkbox::make('required')->label('Champ requis'),
                                        Toggle::make('fullWidth')->label('Pleine largeur')->default(false),
                                    ]),

                            ])->columnSpan(2),
                    ]),
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
