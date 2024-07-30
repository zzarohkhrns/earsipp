<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Form extends Component
{

    public $contacts, $name, $phone, $contact_id;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    public function render()
    {
        return view('livewire.form');
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }
}
