<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Profile extends Component
{
    // Pour l'édition
    public $editingStoryId = null;
    public $editTitle;
    public $editBody;

    // Pour la création manuelle
    public $isCreating = false;
    public $newTitle = '';
    public $newBody = '';

    // Règles de validation
    protected $rules = [
        'editTitle' => 'required|min:3',
        'editBody' => 'required|min:10',
        'newTitle' => 'required|min:3',
        'newBody' => 'required|min:10',
    ];

    // --- GESTION DU STATUT (PUBLIER) ---
    public function toggleStatus($id)
    {
        $story = Story::where('user_id', Auth::id())->find($id);

        if ($story) {
            $story->status = $story->status === 'draft' ? 'published' : 'draft';
            $story->save();
        }
    }

    // --- GESTION DE L'ÉDITION ---
    public function edit($id)
    {
        $story = Story::where('user_id', Auth::id())->find($id);

        if ($story) {
            $this->editingStoryId = $id;
            $this->editTitle = $story->title;
            $this->editBody = $story->body;
            $this->isCreating = false; // Ferme la création si ouverte
        }
    }

    public function cancelEdit()
    {
        $this->editingStoryId = null;
        $this->reset(['editTitle', 'editBody']);
    }

    public function update()
    {
        $this->validate([
            'editTitle' => 'required|min:3',
            'editBody' => 'required|min:10',
        ]);

        $story = Story::where('user_id', Auth::id())->find($this->editingStoryId);

        if ($story) {
            $story->update([
                'title' => $this->editTitle,
                'body' => $this->editBody,
            ]);
        }

        $this->cancelEdit();
        session()->flash('message', 'Histoire mise à jour avec succès.');
    }

    // --- GESTION DE LA CRÉATION MANUELLE ---
    public function startCreating()
    {
        $this->isCreating = true;
        $this->editingStoryId = null; // Ferme l'édition si ouverte
        $this->reset(['newTitle', 'newBody']);
    }

    public function cancelCreating()
    {
        $this->isCreating = false;
    }

    public function storeManual()
    {
        $this->validate([
            'newTitle' => 'required|min:3',
            'newBody' => 'required|min:10',
        ]);

        Story::create([
            'user_id' => Auth::id(),
            'title' => $this->newTitle,
            'body' => $this->newBody,
            'prompt' => 'Création manuelle',
        ]);

        $this->isCreating = false;
        $this->reset(['newTitle', 'newBody']);
        session()->flash('message', 'Histoire créée ! Pensez à la publier.');
    }

    public function delete($id)
    {
        Story::where('user_id', Auth::id())->where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.profile', [
            'stories' => Auth::user()->stories()->latest()->get()
        ]);
    }
}