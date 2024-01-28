<?php

use Illuminate\Database\Seeder;
use App\Models\Country; // Asegúrate de usar el namespace correcto de tu modelo Country

class CountrySeeder extends Seeder
{
    public function run()
    {
        // Importación de países desde un archivo CSV (https://raw.githubusercontent.com/innoboxrr/utils/main/csv/countries.csv)
        $countriesText = file_get_contents(database_path('seeders/countries.csv'));

        // Dividir por líneas
        $lines = explode("\n", $countriesText);

        // Eliminar la línea de encabezado si existe
        array_shift($lines);

        // Crear array de países
        $countries = [];
        foreach ($lines as $line) {
            if (!empty($line)) {
                // Eliminar comillas y dividir por comas
                $countryData = str_getcsv($line);
                $countries[] = [
                    'name' => $countryData[1], // Cambiado índice para ajustarse a tu estructura de CSV
                    'iso_code_2' => $countryData[3],
                    'iso_code_3' => $countryData[4],
                    'iso_code_numeric' => $countryData[5]
                ];
            }
        }

        // Insertar o actualizar países en la base de datos
        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso_code_2' => $country['iso_code_2']],
                [
                    'name' => $country['name'],
                    'iso_code_3' => $country['iso_code_3'],
                    'iso_code_numeric' => $country['iso_code_numeric']
                ]
            );
        }
    }
}
