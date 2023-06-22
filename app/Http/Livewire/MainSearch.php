<?php

namespace App\Http\Livewire;

use App\Repositories\SearchRepository;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class MainSearch extends Component
{
    public $torrents;
    public $string;

    protected $listeners = [
        'loadedFirstPage' => 'loadNextPages', // loads next pages after first page. - moved to emmits so we get instant updates.
        'startedSearch' => 'postSearch',
        'pageLoaded' => 'loadNextPages',
        'loadExactPage' => 'loadPage'
    ];

    public function setString($string) {
        $this->string = $string;
    }

    public function fetch(SearchRepository $repository) {
        if (strlen($this->string) > 2) {
            $this->torrents = [];
            $this->dispatchBrowserEvent('started-search', ['search_string' => 'testing string']);
            $this->torrents = $repository->sendSearchData($this->string);
            Log::info("Continuing to next pages.");
            $this->emit("loadedFirstPage", ['page' => 1, 'errors' => 0]); // This is where you emit the event after loading the first page.
        } else {
            $this->torrents = [];
        }
    }

    public function updatedString() { //TODO merge with fetch method.
        if (strlen($this->string) > 2) {
            Log::info("String updated. Searching for $this->string");
            $repository = new SearchRepository();
            $this->dispatchBrowserEvent('started-search', ['search_string' => 'testing string']);
            $this->emit("loadedFirstPage", ['page' => 1, 'errors' => 0]); // This is where you emit the event after loading the first page.
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = [];
        }
    }

    public function cleanPage() {
        Log::info("Clearing page.");
        $this->torrents = [];
    }

    public function loadNextPages($arguments) {
        Log::info("Loading next page. Errors: " . $arguments['errors'] ?? 'not set' . " Page number: " . $arguments['page'] ?? 'not set');
        $errors = $arguments['errors'] ?? 0;
        $page = $arguments['page'] ?? 1;
        if  (($page < 30) && $errors == 0) {
            $this->emit('loadExactPage', [
                'pageNumber' => $page
            ]);
        } else {
            Log::info("We either have errors or it's the last page we're fetching by limit. We won't emit to fetch next page.");
        }
    }

    public function loadPage($arguments) {
        Log::info("loadPage event hit. Page number: " . $arguments['pageNumber']);
        $searchRepository = new SearchRepository();
        $data = $searchRepository->fetchPage($this->string, $arguments['pageNumber']);
        Log::alert("Data count: " . count($data));

        if ((count($data) > 0) && (!isset($data['error']))) {
            $this->torrents = array_merge($this->torrents, $data);
            $nextPage = $arguments['pageNumber'] +1;
            $this->emit('pageLoaded', [
                'errors' => 0,
                'page' => $nextPage
            ]);
        } else {
            Log::alert("There's no more data or there's an error in the response.");
        }
    }

    public function render()
    {
        $torrents = $this->torrents;
        return view('livewire.main-search',[
            'torrents' => $torrents
        ]);
    }
}
