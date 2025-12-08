<div class="min-h-screen bg-slate-50 py-12 font-sans">
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

            {{-- 1. HEADER (Titre, Auteur, Date) --}}
            <div class="border-b border-slate-100 bg-slate-50/30 p-8 text-center">

                {{-- Titre (Nullable dans ta BDD, donc fallback) --}}
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-3">
                    {{ $story->title ?: 'Histoire sans titre' }}
                </h1>

                {{-- Auteur (User_id Nullable, donc fallback) --}}
                <p class="text-lg text-slate-600 mb-4">
                    Générée par <span
                        class="font-semibold text-emerald-600">{{ $story->user->name ?? 'Un membre anonyme' }}</span>
                </p>

                {{-- Infos méta --}}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        {{ str_word_count($story->body) }} mots
                    </span>
                </div>
            </div>

            {{-- 2. LE PROMPT (Ce qui a été demandé à l'IA) --}}
            {{-- Je le mets dans une boite grise style "technique" --}}
            <div class="px-6 sm:px-12 pt-8 pb-4 bg-white">
                <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="4 17 10 11 4 5" />
                            <line x1="12" y1="19" x2="20" y2="19" />
                        </svg>
                        Prompt utilisé
                    </h3>
                    <p class="text-slate-600 text-sm font-mono leading-relaxed">
                        {{ $story->prompt }}
                    </p>
                </div>
            </div>

            {{-- 3. RÉSUMÉ (Si présent) --}}
            @if($story->summary)
                <div class="px-6 sm:px-12 py-4 bg-white">
                    <div class="rounded-lg bg-emerald-50/50 p-5 border-l-4 border-emerald-500">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-800 mb-2">Résumé</h3>
                        <p class="text-slate-700 italic leading-relaxed">
                            {{ $story->summary }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- 4. CORPS DE L'HISTOIRE --}}
            <div class="px-6 sm:px-12 py-8 bg-white">
                <div class="prose prose-slate prose-lg max-w-none text-slate-800 leading-8">
                    {{-- Affichage du texte principal --}}
                    {!! nl2br(e($story->body)) !!}
                </div>
            </div>

            {{-- 5. PIED DE PAGE --}}
            <div class="bg-slate-50 border-t border-slate-100 p-8 text-center">
                <div class="flex items-center justify-center gap-2 text-slate-400">
                    <span class="h-px w-8 bg-slate-300"></span>
                    <span class="text-sm font-medium uppercase tracking-widest">Fin de l'histoire</span>
                    <span class="h-px w-8 bg-slate-300"></span>
                </div>
            </div>

        </article>
    </div>
</div>