<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Акции', 'Криптовалюты', 'Облигации', 'Товары', 'Наличные и экв.', 'Недвижимость'];

        foreach ($types as $type) {
            Type::updateOrCreate(['name' => $type], ['name' => $type]);
        }
    }
}
