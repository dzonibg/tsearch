<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowTestText extends Component
{

    public $text;

    public function mount() {
        $this->text = "Testing text!";
    }

    public function render()
    {
        return view('livewire.show-test-text');
    }
}
