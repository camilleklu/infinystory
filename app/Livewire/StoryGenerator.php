<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class StoryGenerator extends Component
{
    public string $prompt = '';
    public string $story = '';

    public string $title = '';

    public $showResult = false;

    public function mount()
    {
        // dd(session()->all());
        if (session()->has('pending_story')) {
            $this->title = session()->pull('pending_title', '');

            $this->story = session()->pull('pending_story');

            $this->prompt = session()->pull('pending_prompt', '');
        }
    }

    public function generate()
    {
        $this->showResult = true;
        $this->validate(['prompt' => 'required|string|min:5']);
        $this->story = '';

        $stream = OpenAI::chat()->createStreamed([
            'model' => 'mistral',
            'messages' => [
                ['role' => 'system', 'content' => 'Continue cette histoire en reprenant exactement où elle s/est arrêtée. Reprends les derniers mots écrits puis enchaîne naturellement avec la suite. Texte à continuer : [TEXTE_UTILISATEUR]'],
                ['role' => 'user', 'content' => $this->prompt],
            ],
            'max_tokens' => 300,
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
        Story::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'prompt' => $this->prompt,
            'body' => $this->story,
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
