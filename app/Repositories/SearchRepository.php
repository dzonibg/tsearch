<?php

namespace App\Repositories;

class SearchRepository {

    public function sendSearchData($string) {
        $response = \Http::get("https://tash-scraper.herokuapp.com/api/piratebay/$string");
        $data = $response->json();
        return $data;
    }

}
