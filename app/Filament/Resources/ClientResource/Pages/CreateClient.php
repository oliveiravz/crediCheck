<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;
    public int $score = 0;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data["apto"] = false;
        $this->score = 0;

        if (!empty($data["education"])) {

            switch ($data["education"]) {
                case 'Ensino Fundamental Incompleto':
                    $this->score += 300;
                    break;
                case 'Ensino Fundamental Completo':
                    $this->score += 400;
                    break;
                case 'Ensino Médio Incompleto':
                    $this->score += 500;
                    break;
                case 'Ensino Médio Completo':
                    $this->score += 600;
                    break;
                case 'Ensino Superior Incompleto':
                    $this->score += 700;
                    break;
                case 'Ensino Superior Completo':
                    $this->score += 800;
                    break;
            }
        }

        // Calcular score com base no salário
        if (!empty($data["salary"])) {

            $data["salary"] = (float) $data["salary"];

            if ($data["salary"] <= 1412) {
                $this->score += 400;
            } elseif ($data["salary"] <= (1412 * 3)) {
                $this->score += 450;
            } elseif ($data["salary"] <= (1412 * 5)) {
                $this->score += 500;
            } elseif ($data["salary"] <= (1412 * 10)) {
                $this->score += 550;
            } else {
                $this->score += 600;
            }
        }

        // Ajustar score com base nos cartões de crédito
        if (!empty($data["credit_cards"])) {
            $credit_cards = (int) $data["credit_cards"] * 15;
            $this->score -= $credit_cards;
        }

        // Ajustar score com base nas dívidas
        if (!empty($data["debts"])) {
            $data["debts"] = (float) $data["debts"];

            if ($data["debts"] <= (1412 * 3)) {
                $this->score -= 100;
            } elseif ($data["debts"] <= (1412 * 5)) {
                $this->score -= 200;
            } elseif ($data["debts"] <= (1412 * 10)) {
                $this->score -= 300;
            } else {
                $this->score -= 400;
            }
        }
        
        if($this->score > 1000) {
            $this->score = 1000;
        }
        
        // Definir o valor final de score
        $data["score"] = (int) $this->score;

        // Verifica se é apto
        if ($this->score >= 600) {
            $data["apto"] = true;
        }


        return $data;
    }
    
}
