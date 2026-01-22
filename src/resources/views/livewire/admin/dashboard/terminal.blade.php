<div class="rounded-xl shadow-2xl border border-slate-200 dark:border-gray-800 overflow-hidden transition-colors duration-300"
     x-data="{
        ansiUp: new AnsiUp(),
        autoScroll: true,
        renderMainLogs() {
            $refs.mainLogs.innerHTML = this.ansiUp.ansi_to_html($wire.logs);
            this.tryScroll();
        },
        renderCommand(raw) {
            return this.ansiUp.ansi_to_html(raw);
        },
        tryScroll() {
            if (this.autoScroll) {
                this.$nextTick(() => {
                    $refs.scrollContainer.scrollTop = $refs.scrollContainer.scrollHeight;
                });
            }
        }
     }"
     x-init="
        renderMainLogs(); 
        $watch('$wire.logs', () => renderMainLogs());
        $watch('$wire.manualBuffer', () => tryScroll());
     ">

    <div class="bg-slate-50 dark:bg-gray-900/50 px-4 py-2.5 border-b border-slate-200 dark:border-gray-800 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="flex gap-1.5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-400/80"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-amber-400/80"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/80"></div>
            </div>
            <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Hytale Console</span>
        </div>
        <button wire:click="$set('manualBuffer', [])" 
                class="text-[10px] font-bold text-slate-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400 font-mono uppercase transition-colors px-2 py-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20">
            Clear History
        </button>
    </div>

    <div x-ref="scrollContainer" 
         wire:poll.3s="getDockerLogs"
         class="h-[500px] overflow-y-auto bg-white dark:bg-black/90 p-5 font-mono text-sm selection:bg-indigo-500/30">
        
        <div x-ref="mainLogs" wire:ignore class="whitespace-pre-wrap text-slate-700 dark:text-gray-300 leading-relaxed text-xs"></div>

        <template x-for="(item, index) in $wire.manualBuffer" :key="index">
            <div class="mt-4 border-l-2 border-indigo-500 dark:border-indigo-900 pl-4 py-1 bg-slate-50/50 dark:bg-indigo-950/10 rounded-r-md">
                <div class="flex items-center gap-2 text-xs mb-1.5 opacity-80">
                    <span class="text-indigo-600 dark:text-indigo-400 font-bold" x-text="item.time"></span>
                    <span class="text-slate-400 dark:text-gray-500 tracking-tighter">—</span>
                    <span class="text-indigo-600 dark:text-indigo-400 font-black uppercase">Input</span>
                    <span class="text-slate-800 dark:text-gray-200 font-bold italic" x-text="item.cmd"></span>
                </div>
                <pre class="whitespace-pre-wrap text-slate-600 dark:text-gray-300 text-xs" x-html="renderCommand(item.out)"></pre>
            </div>
        </template>
    </div>

    <div class="bg-slate-50 dark:bg-gray-900 px-4 py-3 border-t border-slate-200 dark:border-gray-800">
        <form wire:submit.prevent="sendCommand" class="flex items-center group">
            <span class="text-indigo-500 dark:text-emerald-500 font-black mr-3 transition-transform group-focus-within:translate-x-1">❯</span>
            <input type="text" 
                   wire:model="command" 
                   class="w-full bg-transparent border-none text-slate-800 dark:text-gray-200 font-mono text-sm focus:ring-0 p-0 placeholder-slate-400 dark:placeholder-gray-600 disabled:opacity-50"
                   placeholder="{{ \Auth::user()->can('manage docker container') ? 'Type a command...' : 'You do not have permission to execute commands.' }}"
                   {{ !\Auth::user()->can('manage docker container') ? 'disabled' : '' }}       
            >
            @if($isRunning)
                <div x-show="autoScroll" class="flex items-center gap-1.5 ml-2 text-[9px] font-bold text-emerald-600 dark:text-emerald-500/80 animate-pulse">
                    <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                    LIVE
                </div>
            @endif
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/ansi_up@5.1.0/ansi_up.min.js"></script>

    <style>
        /* ANSI Color Overrides for better Light/Dark compatibility */
        :root {
            --ansi-green: #059669; /* emerald-600 */
            --ansi-red: #dc2626;   /* red-600 */
            --ansi-blue: #2563eb;  /* blue-600 */
            --ansi-yellow: #d97706;/* amber-600 */
        }

        .dark {
            --ansi-green: #34d399; /* emerald-400 */
            --ansi-red: #f87171;   /* red-400 */
            --ansi-blue: #60a5fa;  /* blue-400 */
            --ansi-yellow: #fbbf24;/* amber-400 */
        }

        .ansi-green-fg { color: var(--ansi-green) !important; }
        .ansi-red-fg { color: var(--ansi-red) !important; }
        .ansi-blue-fg { color: var(--ansi-blue) !important; }
        .ansi-yellow-fg { color: var(--ansi-yellow) !important; }
        .ansi-bright-black-fg { color: #94a3b8 !important; } /* slate-400 */
    </style>
</div>