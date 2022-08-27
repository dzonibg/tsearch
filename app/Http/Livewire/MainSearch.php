<?php

namespace App\Http\Livewire;

use App\Repositories\SearchRepository;
use Livewire\Component;

class MainSearch extends Component
{
    public $torrents = [];
    public $string;

    public function setString($string) {
        $this->string = $string;
    }

    public function fetch(SearchRepository $repository) {
        $this->torrents = $repository->sendSearchData($this->string);
    }

    public function updatedString() {
        $repository = new SearchRepository();
        $this->torrents = $repository->sendSearchData($this->string);
    }

    public function render()
    {
        return view('livewire.main-search');
    }
}
