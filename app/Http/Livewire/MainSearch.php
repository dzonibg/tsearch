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
        'loadedFirstPage' => 'loadNextPages',
        'startedSearch' => 'postSearch'
    ];

    public function setString($string) {
        $this->string = $string;
    }

    public function fetch(SearchRepository $repository) {
        if (strlen($this->string) > 2) {
            $this->dispatchBrowserEvent('started-search', ['search_string' => 'testing string']);
            $this->emit("loadedFirstPage");
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = (array) null;
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
            $this->torrents = (array) null;
        }
    }

    public function firstPageLoaded() {
        $this->loadNextPages();
    }

    public function loadNextPages() {
        Log::alert("Loading next pages.");
        $repository = new SearchRepository();
        $newData = $repository->fetchNextPages($this->string);
        $this->torrents += $newData;
    }

    public function cleanPage() {
        $this->torrents = [];
    }

    public function render()
    {
        return view('livewire.main-search');
    }
}
