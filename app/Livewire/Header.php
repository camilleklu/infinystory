<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $search = '';

    // Cette fonction est appelée quand on appuie sur "Entrée"
    public function performSearch()
    {
        // Redirection vers la route 'stories' (assure-toi que ta route s'appelle bien 'stories' dans web.php)
        // On passe le terme de recherche dans l'URL
        return redirect()->route('stories', ['search' => $this->search]);
    }

    // Optionnel : Pour garder le "Live" quand on est DÉJÀ sur la page histoires
    public function updatedSearch($value)
    {
        // Si on est sur la route 'stories', on envoie le signal live (plus fluide)
        if (request()->routeIs('stories')) {
            $this->dispatch('update-search', $value);
        }
    }

    public function render()
    {
        return view('livewire.header');
    }
}