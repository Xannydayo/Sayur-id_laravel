<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = 'CklYelIic7930ccfd5915e11KDxKbOKY'; // API Key Komerce
        $this->baseUrl = 'https://api-sandbox.collaborator.komerce.id'; // Base URL Komerce Sandbox
    }

    public function getProvinces()
    {
        // Komerce API does not have a direct endpoint for provinces only.
        // We will fetch all cities and then extract unique provinces.
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get($this->baseUrl . '/rajaongkir/api/v1/destination/search');

        $provinces = [];
        if (isset($response['data'])) {
            foreach ($response['data'] as $item) {
                if (isset($item['province_id']) && isset($item['province'])) {
                    $provinces[$item['province_id']] = $item['province'];
                }
            }
        }

        return ['rajaongkir' => ['results' => array_map(function($id, $name) { return ['province_id' => $id, 'province_name' => $name]; }, array_keys($provinces), array_values($provinces))]];
    }

    public function getCities($provinceId = null)
    {
        $url = $this->baseUrl . '/rajaongkir/api/v1/destination/search'; // Endpoint Komerce untuk kota
        $query = [];
        if ($provinceId) {
            $query['province_id'] = $provinceId; // Komerce uses province_id as query parameter
        }

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get($url, $query);

        // Remove dd() statements after debugging
        // dd($response->status(), $response->json());

        // Komerce API returns data directly in 'data' key, not 'rajaongkir.results'
        return ['rajaongkir' => ['results' => $response->json()['data'] ?? []]];
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/rajaongkir/api/v1/cost/calculate', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
            'originType' => 'city', // As per RajaOngkir, assuming Komerce forwards this
            'destinationType' => 'city', // As per RajaOngkir, assuming Komerce forwards this
        ]);

        return $response->json();
    }
} 