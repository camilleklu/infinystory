<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;

class StoryDetail extends Component
{
    public Story $story;

    // Livewire injecte automatiquement le modèle grâce à la route
    public function mount(Story $story)
    {
        $this->story = $story;
    }

    public function render()
    {
        return view('livewire.story-detail');
    }
}
