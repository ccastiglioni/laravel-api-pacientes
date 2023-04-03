<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition()
    {
        return [
            'end_paciente_id' => rand(1,20),
            'end_cep' => $this->faker->postcode,
            'end_endereco' => $this->faker->streetAddress,
            'end_numero' => $this->faker->buildingNumber,
            'end_complemento' => $this->faker->secondaryAddress,
            'end_bairro' => $this->faker->word,
            'end_cidade' => $this->faker->city,
            'end_estado' => $this->faker->stateAbbr,
        ];
    }
}

