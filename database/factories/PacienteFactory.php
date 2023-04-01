<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pac_foto' => 'default.png',
            'pac_nome'=>$this->faker->name,
            'pac_nome_mae'=>$this->faker->name,
            'pac_data' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'pac_cpf' => $this->faker->unique()->numerify('###########'),
            'pac_cns' =>$this->faker->unique()->numerify('########'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
