<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url; // <--- 1. Import de l'attribut URL
use Livewire\Attributes\On;
use App\Models\Story;

class Stories extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[On('update-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }

    public function render()
    {
        $stories = Story::query()
            ->published()
            ->with('chapters')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('body', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(9);

        return view('livewire.stories', [
            'stories' => $stories
        ]);
    }
}