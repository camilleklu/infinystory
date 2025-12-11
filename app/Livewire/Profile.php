<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{

    public $editingStoryId = null;
    public $editTitle = '';


    public $isCreating = false;
    public $newTitle = '';
    public $newBody = '';


    public $chapters = [];
    public $editingChapterId = null;
    public $chapterTitle = '';
    public $chapterBody = '';

    // Status publication // brouillon
    public function toggleStatus($id)
    {
        $story = Story::where('user_id', Auth::id())->find($id);

        if ($story) {
            $story->status = $story->status === 'draft' ? 'published' : 'draft';
            $story->save();
        }
    }

    // édition
    public function edit($id)
    {
        $story = Story::where('user_id', Auth::id())->find($id);

        if ($story) {
            $this->editingStoryId = $id;
            $this->editTitle = $story->title;

            $this->chapters = $story->chapters()->orderBy('order', 'asc')->get();

            $this->isCreating = false;
            $this->editingChapterId = null;
        }
    }

    public function update()
    {
        $this->validate([
            'editTitle' => 'required|min:3',
        ]);

        $story = Story::where('user_id', Auth::id())->find($this->editingStoryId);

        if ($story) {
            $story->update([
                'title' => $this->editTitle,
            ]);
        }
        session()->flash('message', 'Titre du livre mis à jour.');
    }

    public function cancelEdit()
    {
        $this->editingStoryId = null;
        $this->reset(['editTitle', 'chapters', 'editingChapterId']);
    }

    public function editChapter($chapterId)
    {
        $chapter = Chapter::find($chapterId);

        if ($chapter && $chapter->story_id == $this->editingStoryId) {
            $this->editingChapterId = $chapterId;
            $this->chapterTitle = $chapter->title;
            $this->chapterBody = $chapter->body;
        }
    }

    public function addChapter()
    {
        $story = Story::find($this->editingStoryId);

        $nextOrder = $story->chapters()->max('order') + 1;

        $chapter = Chapter::create([
            'story_id' => $this->editingStoryId,
            'title' => 'Nouveau Chapitre',
            'body' => '',
            'order' => $nextOrder
        ]);

        $this->chapters = $story->chapters()->orderBy('order', 'asc')->get();
        $this->editChapter($chapter->id);
    }

    // 3. Sauvegarder le chapitre
    public function saveChapter()
    {
        $this->validate([
            'chapterTitle' => 'required|string|max:255',
            'chapterBody' => 'nullable|string'
        ]);

        $chapter = Chapter::find($this->editingChapterId);

        if ($chapter) {
            $chapter->update([
                'title' => $this->chapterTitle,
                'body' => $this->chapterBody
            ]);
        }

        session()->flash('message', 'Chapitre sauvegardé.');

        $this->chapters = Chapter::where('story_id', $this->editingStoryId)->orderBy('order')->get();

        $this->editingChapterId = null;
    }

    public function deleteChapter($chapterId)
    {
        $chapter = Chapter::find($chapterId);

        if ($chapter && $chapter->story_id == $this->editingStoryId) {
            $chapter->delete();
            $this->chapters = Chapter::where('story_id', $this->editingStoryId)->orderBy('order')->get();
        }
    }



    public function startCreating()
    {
        $this->isCreating = true;
        $this->editingStoryId = null;
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


        $story = Story::create([
            'user_id' => Auth::id(),
            'title' => $this->newTitle,
            'prompt' => 'Création manuelle',
            'status' => 'draft',

        ]);

        Chapter::create([
            'story_id' => $story->id,
            'title' => 'Chapitre 1',
            'body' => $this->newBody,
            'order' => 1
        ]);

        $this->isCreating = false;
        $this->reset(['newTitle', 'newBody']);

        session()->flash('message', 'Histoire créée ! Vous pouvez maintenant ajouter d\'autres chapitres.');
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