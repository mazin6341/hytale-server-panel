<x-layouts.app>
    <div class="relative flex items-center justify-center min-h-screen overflow-hidden bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-100/50 dark:bg-indigo-500/10 blur-3xl"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-blue-100/50 dark:bg-blue-500/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-2xl px-6 text-center">
            
            <div class="inline-flex items-center px-3 py-1 mb-8 text-sm font-medium text-indigo-700 dark:text-indigo-300 rounded-full bg-indigo-50 dark:bg-indigo-900/30 ring-1 ring-inset ring-indigo-700/10 dark:ring-indigo-400/20">
                <span class="relative flex w-2 h-2 mr-2">
                    <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-indigo-400 dark:bg-indigo-400"></span>
                    <span class="relative inline-flex w-2 h-2 rounded-full bg-indigo-500 dark:bg-indigo-400"></span>
                </span>
                Work in Progress
            </div>

            <h1 class="text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-7xl">
                {{ config('app.name', 'Hytale Web Panel') }}<span class="text-indigo-600 dark:text-indigo-500">.</span>
            </h1>

            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-400">
                Something exciting is under construction. We're building a modern experience 
                from the ground up using Laravel and Tailwind CSS.
            </p>

            <div class="flex items-center justify-center mt-10 gap-x-6">
                <a href="#" class="px-6 py-3 text-sm font-semibold text-white transition-all bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-500 dark:bg-indigo-600 dark:hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Learn More
                </a>
                <a href="https://github.com/mazin6341/hytale-server-panel" class="text-sm font-semibold leading-6 text-slate-900 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    View on GitHub <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="pt-16 mt-16 border-t border-slate-200 dark:border-slate-800">
                <p class="text-xs text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                    Built with Laravel {{ app()->version() }} &bull; PHP v{{ PHP_VERSION }}
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>