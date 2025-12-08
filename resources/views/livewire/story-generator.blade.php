<div class="min-h-screen bg-slate-50/50 py-12 font-sans text-slate-900">
    <div class="container mx-auto max-w-4xl px-4 space-y-8">
        <div class="space-y-4 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                Générer une histoire
            </h1>
            <p class="text-lg text-slate-500">
                Commencez par une idée, et laissez l'IA continuer votre histoire
            </p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="font-semibold leading-none tracking-tight flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-emerald-600">
                        <path
                            d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                    </svg>
                    Votre idée d'histoire
                </h3>
                <p class="text-sm text-slate-500">
                    Décrivez le début de votre histoire en quelques mots
                </p>
            </div>
            <div class="p-6 pt-0 space-y-4">
                <div class="space-y-2">
                    <label for="story"
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                        Racontez-nous une histoire :
                    </label>
                    <textarea id="story" wire:model="prompt"
                        class="flex min-h-[120px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none"
                        placeholder="Ex: un jeune magicien découvre un livre ancien dans une bibliothèque abandonnée..."></textarea>
                </div>
                @error('prompt')
                    <span class="text-red-500 text-sm font-medium">{{ $message }}</span>
                @enderror
                <button wire:click="generate" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-emerald-600 text-white hover:bg-emerald-700 h-11 px-8 w-full">
                    <span wire:loading>
                        Génération en cours...
                    </span>
                    <span wire:loading.remove class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                        </svg>
                        Générer l'histoire
                    </span>
                </button>
            </div>
        </div>

        <div class="rounded-xl border border-emerald-100 bg-white text-slate-950 shadow-sm transition-all duration-500 ease-in-out {{ empty($story) ? 'hidden' : '' }}"
            wire:loading.class.remove="hidden" wire:target="generate">
            <div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">Votre histoire</h3>
                <div>
                    <label for="title">Titre de l'histoire :</label>
                    <input type="text" id="title" wire:model="title"
                        class="ml-2 rounded-md border border-slate-200 bg-white px-3 py-1 text-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        placeholder="Entrez un titre pour votre histoire" />
                </div>
                @auth
                    <button wire:click="save"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Enregistrer
                    </button>
                @endauth
            </div>
            <div class="p-6 pt-4">
                <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed min-h-[4rem]">
                    <p wire:stream="story" class="whitespace-pre-line">
                        {{ $story }}
                        <span wire:loading wire:target="generate"
                            class="inline-block w-2 h-5 ml-1 align-middle bg-emerald-600 animate-pulse"></span>
                    </p>
                </div>
                @guest
                    <div class="mt-6 rounded-md bg-amber-50 p-4 border border-amber-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-amber-800">Sauvegarde impossible</h3>
                                <div class="mt-2 text-sm text-amber-700">
                                    <p>
                                        <button wire:click="goToLoginToSave"
                                            class=" border-hidden font-bold underline hover:text-amber-900"
                                            type="button">Connectez-vous</button>

                                        pour sauvegarder cette histoire dans votre bibliothèque.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>