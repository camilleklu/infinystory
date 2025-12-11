<div class="min-h-screen bg-slate-50 py-12 font-sans" x-data
    @scroll-to-top.window="window.scrollTo({top: 0, behavior: 'smooth'})">
    <div class="container mx-auto px-4 max-w-4xl">

        {{-- Bouton Retour --}}
        <div class="mb-6">
            <a href="{{ route('stories') }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-emerald-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Retour à la bibliothèque
            </a>
        </div>

        {{-- Carte de lecture --}}
        <article class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden">

            {{-- 1. HEADER (Infos du Livre) --}}
            <div class="border-b border-slate-100 bg-slate-50/30 p-8 text-center">

                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-3">
                    {{ $story->title ?: 'Histoire sans titre' }}
                </h1>

                <p class="text-lg text-slate-600 mb-4">
                    Créée par <span class="font-semibold text-emerald-600">{{ $story->user->name ?? 'Anonyme' }}</span>
                </p>

                <div class="inline-flex items-center gap-4 text-sm text-slate-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $story->created_at->format('d/m/Y') }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        {{ $totalChapters }} Chapitre(s)
                    </span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        {{ number_format($totalWords, 0, ',', ' ') }} mots
                    </span>
                </div>
            </div>

            {{-- 2. INFOS CONTEXTUELLES (Prompt/Résumé) - Affiché seulement au Chapitre 1 --}}
            @if($chapterIndex === 0 && ($story->prompt || $story->summary))
                <div class="px-6 sm:px-12 pt-8 pb-4 bg-white border-b border-slate-50">
                    @if($story->prompt)
                        <div class="rounded-lg bg-slate-50 border border-slate-200 p-4 mb-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Prompt original</h3>
                            <p class="text-slate-600 text-sm font-mono leading-relaxed">{{ $story->prompt }}</p>
                        </div>
                    @endif
                    @if($story->summary)
                        <div class="rounded-lg bg-emerald-50/50 p-4 border-l-4 border-emerald-500">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 mb-2">Résumé</h3>
                            <p class="text-slate-700 italic text-sm">{{ $story->summary }}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if($chapter)
                {{-- 3. NAVIGATION DU HAUT (Style AO3) --}}
                <div class="px-6 sm:px-12 py-6 bg-white flex justify-between items-center border-b border-slate-100">
                    <div>
                        <button wire:click="previousChapter" @if(!$hasPrevious) disabled @endif
                            class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            ← Précédent
                        </button>
                    </div>

                    <div class="text-sm font-bold text-slate-500 uppercase tracking-widest">
                        Chapitre {{ $chapterIndex + 1 }} / {{ $totalChapters }}
                    </div>

                    <div>
                        <button wire:click="nextChapter" @if(!$hasNext) disabled @endif
                            class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            Suivant →
                        </button>
                    </div>
                </div>

                {{-- 4. CORPS DU CHAPITRE --}}
                <div class="px-6 sm:px-12 py-8 bg-white min-h-[400px]">
                    {{-- Titre du Chapitre --}}
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-slate-800">{{ $chapter->title }}</h2>
                    </div>

                    <div class="prose prose-slate prose-lg max-w-none text-slate-800 leading-8">
                        {!! nl2br(e($chapter->body)) !!}
                    </div>
                </div>

                {{-- 5. NAVIGATION DU BAS --}}
                <div class="px-6 sm:px-12 py-6 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                    <button wire:click="previousChapter" @if(!$hasPrevious) disabled @endif
                        class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                        ← Chapitre Précédent
                    </button>

                    <button wire:click="nextChapter" @if(!$hasNext) disabled @endif
                        class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                        Chapitre Suivant →
                    </button>
                </div>

            @else
                {{-- Cas où il n'y a pas de chapitres --}}
                <div class="p-12 text-center text-slate-500 italic">
                    Cette histoire ne contient pas encore de chapitres.
                </div>
            @endif

        </article>
    </div>
</div>