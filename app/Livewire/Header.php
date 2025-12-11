<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $search = '';

    public function performSearch()
    {
        return redirect()->route('stories', ['search' => $this->search]);
    }

    public function updatedSearch($value)
    {
        if (request()->routeIs('stories')) {
            $this->dispatch('update-search', $value);
        }
    }

    public function render()
    {
        return view('livewire.header');
    }
}