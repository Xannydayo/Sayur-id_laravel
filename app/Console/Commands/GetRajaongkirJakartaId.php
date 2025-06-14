<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RajaOngkirService;

class GetRajaongkirJakartaId extends Command
{
    protected $signature = 'app:get-rajaongkir-jakarta-id';
    protected $description = 'Get RajaOngkir city ID for Jakarta.';

    public function handle(RajaOngkirService $rajaOngkirService)
    {
        $this->info('Fetching cities from RajaOngkir...');

        try {
            $citiesData = $rajaOngkirService->getCities();

            if (isset($citiesData['rajaongkir']['results']) && count($citiesData['rajaongkir']['results']) > 0) {
                $jakartaFound = false;
                foreach ($citiesData['rajaongkir']['results'] as $city) {
                    if (stripos($city['city_name'], 'jakarta') !== false || stripos($city['province'], 'jakarta') !== false) {
                        $this->info('Found: ' . $city['city_name'] . ' (' . $city['type'] . ' - ID: ' . $city['city_id'] . ', Province ID: ' . $city['province_id'] . ')');
                        $jakartaFound = true;
                    }
                }

                if (!$jakartaFound) {
                    $this->warn('Jakarta city ID not found. Please check your RajaOngkir account type or API key.');
                }
            } else {
                $statusDescription = isset($citiesData['rajaongkir']['status']['description']) ? $citiesData['rajaongkir']['status']['description'] : 'Unknown error';
                $this->error('Failed to retrieve cities data: ' . $statusDescription);
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
} 