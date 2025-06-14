<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected static function baseUrl(): string
    {
        return config('services.supabase.url'); // gunakan .env
    }

    protected static function apiKey(): string
    {
        return config('services.supabase.key'); // gunakan .env
    }

    protected static function headers(): array
    {
        return [
            'apikey' => self::apiKey(),
            'Authorization' => 'Bearer ' . self::apiKey(),
            'Content-Type' => 'application/json',
        ];
    }

    public static function get(string $table, array $query = [])
    {
        return Http::withHeaders(self::headers())
            ->get(self::baseUrl() . '/rest/v1/' . $table, $query);
    }

    public static function insert(string $table, array $data)
    {
        return Http::withHeaders(self::headers())
            ->post(self::baseUrl() . '/rest/v1/' . $table, $data);
    }

    public static function update(string $table, array $filters, array $data)
    {
        $queryString = http_build_query($filters);
        $url = self::baseUrl() . '/rest/v1/' . $table . '?' . $queryString;

        return Http::withHeaders(self::headers())
            ->patch($url, $data);
    }

    public static function delete(string $table, array $filters)
    {
        $$queryString = http_build_query($filters);
        $url = self::baseUrl() . '/rest/v1/' . $table . '?' . $queryString;
    
        return Http::withHeaders(self::headers())
            ->delete($url);
    }

    // penggunaan delete
    // $filters = ['id' => 'eq.' . $id];

    // $response = SupabaseHelper::delete('contacts', $filters);

    // $response = SupabaseHelper::insert('contacts', [
    //     'name' => 'Ali',
    //     'phone' => '08123456789',
    // ]);
}
