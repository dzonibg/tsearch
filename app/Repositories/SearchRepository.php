<?php

namespace App\Repositories;

class SearchRepository {

    public function sendSearchData($string) {
        $response = \Http::get(getenv('SEARCH_URL') . "api/piratebay/$string");
        $data = $response->json();
        return $data;
    }

}
