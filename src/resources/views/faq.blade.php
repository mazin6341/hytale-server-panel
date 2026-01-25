<x-layouts.app title="FAQs - Hytale Web Panel">
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-16 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                
                <div class="lg:col-span-4">
                    <div class="sticky top-10">
                        <h2 class="text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase text-sm">
                            Support
                        </h2>
                        <h3 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                            FAQs
                        </h3>
                        <p class="mt-4 text-slate-500 dark:text-slate-400 leading-relaxed">
                            Need help? specific answers to the most common questions about the project.
                        </p>

                        <div class="mt-8 p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <h4 class="text-base font-bold text-slate-900 dark:text-white">
                                Can't find an answer?
                            </h4>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 mb-4">
                                Our team is active on Discord. Come say hi!
                            </p>
                            <a href="https://discord.gg/kbEEvqRkaH" target="_blank" class="flex items-center justify-center w-full px-4 py-2.5 bg-[#5865F2] hover:bg-[#4752C4] text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02]">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037 13.46 13.46 0 0 0-.64 1.298 17.65 17.65 0 0 0-5.43 0 13.483 13.483 0 0 0-.642-1.3.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                                Join Community
                            </a>
                            <x-button black icon="arrow-left" href="/admin/dashboard" class="mt-4 w-full">
                                Back to Dashboard
                            </x-button>
                        </div>
                    </div>
                    <div class="w-full">
                    </div>
                </div>

                <div class="mt-10 lg:mt-0 lg:col-span-8">
                    <dl class="space-y-6 divide-y divide-slate-200 dark:divide-slate-800">
                        <!-- Question Template -->
                        {{--
                        <div class="py-6 first:pt-0">
                            <details class="border-b border-slate-200 pb-4 dark:border-slate-800 group [&_summary::-webkit-details-marker]:hidden">
                                <summary class="flex w-full items-start justify-between text-left text-slate-900 dark:text-white cursor-pointer focus:outline-none">
                                    <span class="text-lg font-semibold leading-7">
                                        Question Template 1?
                                    </span>
                                    <span class="ml-6 flex h-7 items-center">
                                        <svg class="h-6 w-6 transform text-indigo-500 group-open:hidden transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                        </svg>
                                        <svg class="h-6 w-6 transform text-indigo-500 hidden group-open:block transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                        </svg>
                                    </span>
                                </summary>
                                <div class="mt-3 pr-12">
                                    <p class="text-base leading-7 text-slate-600 dark:text-slate-400">
                                        Answer text goes here. This design separates the questions with lines rather than boxes, making it easier to read large amounts of text.
                                    </p>
                                </div>
                            </details>
                        </div>
                        --}}
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>