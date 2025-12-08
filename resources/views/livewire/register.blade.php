<div
    class="flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8 bg-white font-sans relative overflow-hidden">

    {{-- Background Gradient (Identique à ta page d'accueil) --}}
    <div
        class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.emerald.100),white)] opacity-40">
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative">
        {{-- Titre --}}
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-slate-900">
            Créer un compte
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Commencez votre aventure sur <span class="text-emerald-600 font-medium">InfinityStory</span>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative">
        <div class="bg-white/80 backdrop-blur-sm py-8 px-4 shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl sm:px-10">
            <form wire:submit="register" class="space-y-6">

                {{-- Nom --}}
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-slate-900">Nom complet</label>
                    <div class="mt-2">
                        <input id="name" type="text" wire:model="name" required
                            class="block w-full rounded-md border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-slate-900">Adresse email</label>
                    <div class="mt-2">
                        <input id="email" type="email" wire:model="email" required
                            class="block w-full rounded-md border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Mot de
                        passe</label>
                    <div class="mt-2">
                        <input id="password" type="password" wire:model="password" required
                            class="block w-full rounded-md border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium leading-6 text-slate-900">Confirmer le mot de passe</label>
                    <div class="mt-2">
                        <input id="password_confirmation" type="password" wire:model="password_confirmation" required
                            class="block w-full rounded-md border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove>S'inscrire</span>
                        <span wire:loading>Création en cours...</span>
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white/80 backdrop-blur-sm px-2 text-slate-500">Déjà inscrit ?</span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="/login" class="font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>