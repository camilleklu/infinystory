<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Chapter;
use Livewire\Attributes\Validate;

class StoryGenerator extends Component
{
    #[Validate('required|string|min:5')]
    public string $prompt = '';
    public string $story = '';

    public string $title = '';

    public bool $hasGenerated = false;


    public function mount()
    {
        if (session()->has('pending_story')) {
            $this->title = session()->pull('pending_title', '');

            $this->story = session()->pull('pending_story');

            $this->prompt = session()->pull('pending_prompt', '');

            if (!empty($this->story)) {
                $this->hasGenerated = true;
            }
        }
    }

    public function generate()
    {
        $this->hasGenerated = true;
        $this->validate();
        $this->story = '';

        $stream = OpenAI::chat()->createStreamed([
            'model' => 'mistral',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Tu écris exclusivement en français correct.
                Ta tâche est de continuer l’histoire exactement à l’endroit où elle s’est arrêtée.
                Reprends les derniers mots du texte utilisateur puis continue naturellement, sans changer de style."
                ],
                ['role' => 'user', 'content' => $this->prompt],
            ],
        ]);

        foreach ($stream as $response) {
            $chunk = $response->choices[0]->delta->content ?? '';
            $this->story .= $chunk;
            $this->stream('story', $chunk);
        }

    }

    public function goToLoginToSave()
    {

        Session::put('pending_title', $this->title);
        Session::put('pending_story', $this->story);
        Session::put('pending_prompt', $this->prompt);

        Session::put('url.intended', route('story.create'));

        return $this->redirect("/login");
    }

    public function save()
    {
        if (!Auth::check()) {
            abort(403, 'Vous devez être connecté pour sauvegarder.');
        }

        if (empty($this->story)) {
            return;
        }

        $newStory = Story::create([
            'user_id' => Auth::id(),
            'title' => $this->title ?: 'Nouvelle Histoire IA',
            'prompt' => $this->prompt,
        ]);

        Chapter::create([
            'story_id' => $newStory->id,
            'title' => 'Chapitre 1',
            'body' => $this->story,
            'order' => 1,
        ]);

        session()->flash('message', 'Histoire sauvegardée avec succès !');
        $this->reset(['title', 'story', 'prompt']);
        session()->forget(['title', 'story', 'prompt']);
    }


    public function render()
    {
        return view('livewire.story-generator');
    }
}
