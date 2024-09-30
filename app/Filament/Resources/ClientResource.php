<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label("Nome"),
                Forms\Components\TextInput::make('cpf')
                    ->required()
                    ->placeholder('Digite o CPF')
                    ->label("CPF")
                    ->mask('999.999.999-99'),
                Forms\Components\Select::make('education')
                    ->required()
                    ->label("Escolaridade")
                    ->options([
                        'Ensino Fundamental Incompleto' => 'Ensino Fundamental Incompleto',
                        'Ensino Fundamental Completo' => 'Ensino Fundamental Completo',
                        'Ensino Médio Incompleto' => 'Ensino Médio Incompleto',
                        'Ensino Médio Completo' => 'Ensino Médio Completo',
                        'Ensino Superior Incompleto' => 'Ensino Superior Incompleto',
                        'Ensino Superior Completo' => 'Ensino Superior Completo',
                    ]),
                Forms\Components\TextInput::make('salary')
                    ->numeric()
                    ->label("Salário")
                    ->prefix('R$')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('credit_cards')
                    ->numeric()
                    ->label("Cartões de Crédito")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('debts')
                    ->numeric()
                    ->prefix("R$")
                    ->label("Dívidas Totais")
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label("Nome"),
                Tables\Columns\TextColumn::make('cpf')
                    ->searchable()
                    ->label("CPF"),
                Tables\Columns\TextColumn::make('education')
                    ->searchable()
                    ->label("Escolaridade"),
                Tables\Columns\TextColumn::make('salary')
                    ->searchable()
                    ->label("Salário"),
                Tables\Columns\IconColumn::make('apto')
                    ->searchable()
                    ->label("Apto")
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label("Editar"),
                Tables\Actions\Action::make('download')
                    ->label('Download PDF')
                    ->url(fn(Client $id) => route('client.pdf.download', $id))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                ->label("Ações"),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
