<?php

namespace App\Http\Livewire;

use App\Repositories\SearchRepository;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class MainSearch extends Component
{
    public $torrents = [];
    public $string;

    protected $listeners = [
        'loadedFirstPage' => 'loadAllPages',
        'startedSearch' => 'postSearch',
        'loadedPage' => 'refreshData'
    ];

    public function setString($string) {
        $this->string = $string;
    }

    public function fetch(SearchRepository $repository) {
        if (strlen($this->string) > 2) {
            $this->torrents = [];
            $this->dispatchBrowserEvent('started-search', ['search_string' => 'testing string']);
            $this->emit("loadedFirstPage");
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = [];
        }
    }

    public function updatedString() {
        if (strlen($this->string) > 2) {
            Log::info("Searching for $this->string");
            $repository = new SearchRepository();
            $this->dispatchBrowserEvent('started-search', ['search_string' => 'testing string']);
            $this->emit("loadedFirstPage");
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = [];
        }
    }

    /*
     *  Old method for fetching all pages.
     *  It was a blocking method, meaning you'd need to
     *  wait for all results to be fetched before you
     *  are getting the response.
     */
    public function loadedFirstPage() {
        Log::alert("OLD EVENT DISPATCHED!");
        $this->loadNextPages();
    }

    public function cleanPage() {
        $this->torrents = [];
    }

    /*
     *  New query for fetching the rest of pages.
     */
    public function loadAllPages(SearchRepository $repository) {
        Log::alert("New event method dispatched!");
        $currentPage = 1;
        $errors = 0;
        Log::info("Page iteration started. Searching for " . $this->string);

        while ($errors == 0) {
            Log::info("Fetching page " . $currentPage);
            $newData = $repository->fetchPage($this->string, $currentPage);
            if ((count($newData) > 0) && ($currentPage < 30)) {
                $this->torrents = array_merge($this->torrents, $newData);
                $this->emit('loadedPage');
                Log::info("Fetched page.");
                $currentPage++;

            } else {
                $errors++;
            }
        }
        Log::info("Finished fetching pages for " . $this->string . ". Found $currentPage pages.");
    }

    public function refreshData() {
        $this->render();
    }

    public function render()
    {
        $torrents = $this->torrents;
        return view('livewire.main-search',[
            'torrents' => $torrents
        ]);
    }
}
