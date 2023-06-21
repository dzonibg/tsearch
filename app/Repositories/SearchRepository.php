<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchRepository {

    public array $data;
    private int $objectsPerPage;

    public function fetchPage(string $string, int $pageNumber = 1): array {
        Log::info("Fetching Page $pageNumber for $string");
        $response = Http::get(getenv('SEARCH_URL') . "api/piratebay/$string/$pageNumber");
        $data = $response->json();
        return $data;
    }

    public function sendSearchData(string $string): array {
        return $this->fetchFirstPage($string);
    }

    public function fetchFirstPage(string $string): array {
        $data = $this->fetchPage($string, 1);
        return $data;
    }

    /*
     * Let's try to avoid this.
     */

    public function fetchNextPages($string) { // method causes weird things to happen; need to load page 1 to fully load page 2? Will refactor this.
        $currentPage = 1;
        $errors = 0;
        while ($errors == 0) {
            Log::info("Nextpage is $currentPage");
            $pageData = $this->fetchPage($string, $currentPage);
            if ((count($pageData) == 1) || ($currentPage > 30)) {
                $errors = 1;
                $endPage = $currentPage - 1;
                Log::info("Found $endPage pages for $string.");
            } else {
                // got items => push to array
                foreach ($pageData as $datum) {
                    $this->data[] = $datum;
                }
            }
            $currentPage++;
        }
        return $this->data;
    }

}
