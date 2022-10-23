<?php

namespace App\Repositories;

class SearchRepository {

    public array $data;

    public function sendSearchData($string) {
        return $this->fetchFirstPage($string);
    }

    public function fetchFirstPage($string) {
        $response = \Http::get(getenv('SEARCH_URL') . "api/piratebay/$string/1");
        $data = $response->json();
        return $data;
    }

}
