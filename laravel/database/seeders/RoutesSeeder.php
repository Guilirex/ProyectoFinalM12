<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener los IDs de los usuarios y los estilos de ruta existentes
        $userIds = DB::table('users')->pluck('id')->toArray();
        $routeStyleIds = DB::table('route_styles')->pluck('id')->toArray();

        // Generar algunos datos aleatorios para la tabla "routes"
        $routes = [];
        $vehicleTypes = ['Moto', 'Coche'];

        for ($i = 0; $i < 20; $i++) {
            $latitude = mt_rand(36.0, 43.8) + mt_rand() / mt_getrandmax();
            $longitude = mt_rand(-9.3, 3.4) + mt_rand() / mt_getrandmax();
            $latitude1 = mt_rand(36.0, 43.8) + mt_rand() / mt_getrandmax();
            $longitude1 = mt_rand(-9.3, 3.4) + mt_rand() / mt_getrandmax();
            
            $type_vehicle = $vehicleTypes[array_rand($vehicleTypes)];


            $routes[] = [
                'name' => 'Route ' . ($i + 1),
                'description' => 'Route de pruebaa',
                'date' => '2023-05-17 18:20:56',
                'estimated_duration' => '1:30',
                'distance' => '1020',

                'startLatitude'=> $latitude,
                'startLongitude'=> $longitude,

                'endLatitude'=> $latitude1,
                'endLongitude'=> $longitude1,

                'type_vehicle' => $type_vehicle,
                // 'url_maps' => 'https://maps.google.com/route' . ($i + 1),
                'num_stops' => rand(1, 10),
                // 'max_users' => rand(1, 10),
                'max_users' => rand(1, 2),

                'author_id'=> rand(1,3),
                'id_route_style' => $routeStyleIds[array_rand($routeStyleIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertar los datos en la tabla "routes"
        DB::table('routes')->insert($routes);

    }
}
