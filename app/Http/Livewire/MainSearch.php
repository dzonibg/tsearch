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
        if (strlen($this->string) > 2) {
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = (array) null;
        }
    }

    public function updatedString() {
        if (strlen($this->string) > 2) {
            $repository = new SearchRepository();
            $this->torrents = $repository->sendSearchData($this->string);
        } else {
            $this->torrents = (array) null;
        }
    }

    public function render()
    {
        return view('livewire.main-search');
    }
}
