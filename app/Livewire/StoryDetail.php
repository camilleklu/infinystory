<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;

class StoryDetail extends Component
{
    public Story $story;
    public $allChapters;
    public $chapterIndex = 0;

    public function mount(Story $story)
    {
        $this->story = $story;
        $this->allChapters = $story->chapters()->orderBy('order')->get();
    }

    public function nextChapter()
    {
        if ($this->chapterIndex < $this->allChapters->count() - 1) {
            $this->chapterIndex++;
            $this->dispatch('scroll-to-top'); // Petit bonus UX (remonte la page)
        }
    }

    public function previousChapter()
    {
        if ($this->chapterIndex > 0) {
            $this->chapterIndex--;
            $this->dispatch('scroll-to-top');
        }
    }

    public function render()
    {
        $currentChapter = $this->allChapters[$this->chapterIndex] ?? null;

        $totalWords = $this->allChapters->sum(function ($chapter) {
            return str_word_count($chapter->body ?? '');
        });

        return view('livewire.story-detail', [
            'chapter' => $currentChapter,
            'totalChapters' => $this->allChapters->count(),
            'totalWords' => $totalWords,
            'hasPrevious' => $this->chapterIndex > 0,
            'hasNext' => $this->chapterIndex < $this->allChapters->count() - 1,
        ]);
    }
}
