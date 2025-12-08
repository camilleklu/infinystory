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

    // 2. L'attribut #[Url] lie cette variable à la barre d'adresse du navigateur.
    // 'except' => '' permet de ne pas afficher ?search= si la recherche est vide.
    #[Url(except: '')]
    public $search = '';

    // Garde cette fonction pour la mise à jour en temps réel si on est déjà sur la page
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