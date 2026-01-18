<x-layouts.app title="Login - Hytale Web Panel">
    <div class="relative flex items-center justify-center min-h-screen overflow-hidden">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-primary-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 -right-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>

        <div class="relative w-full px-6 sm:max-w-md">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Hytale <span class="text-primary-600">Web Panel</span>
                </h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Welcome back! Please enter your details.
                </p>
            </div>

            <x-card class="border-none shadow-2xl bg-white/80 dark:bg-secondary-800/90 backdrop-blur-xl rounded-2xl">
                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf

                    <x-input 
                        label="Email Address" 
                        placeholder="your@email.com" 
                        icon="envelope" 
                        name="email"
                        type="email"
                        required 
                        autofocus 
                        class="!rounded-xl"
                    />

                    <div>
                        <x-input
                            type="password"
                            label="Password" 
                            placeholder="••••••••" 
                            name="password"
                            required 
                            class="!rounded-xl"
                        />
                        <div class="flex items-center justify-end mt-2">
                            @if (Route::has('password.request'))
                                <a class="text-xs font-medium text-primary-600 hover:text-primary-500 transition-colors" href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-checkbox 
                            id="remember_me" 
                            name="remember" 
                            label="Keep me logged in" 
                            sm 
                        />
                    </div>

                    <div class="pt-2">
                        <x-button 
                            type="submit" 
                            primary 
                            lg
                            label="Sign In" 
                            class="w-full !rounded-xl shadow-md hover:shadow-lg transition-all active:scale-[0.98]"
                        />
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-layouts.app>