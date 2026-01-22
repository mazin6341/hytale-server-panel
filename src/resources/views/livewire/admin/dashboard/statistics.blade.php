<div wire:poll.5s="getDockerStats" class="flex flex-col gap-4 transition-colors duration-300">
    @can('view docker stats')
        <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 p-4 rounded-xl shadow-sm overflow-hidden relative">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-lg">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">CPU Load</span>
                </div>
                <span class="text-sm font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['cpu'] }}%</span>
            </div>
            <div class="w-full bg-slate-100 dark:bg-gray-800 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(16,185,129,0.4)]" style="width: {{ min($stats['cpu'], 100) }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 p-4 rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg">
                        <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Memory RAM</span>
                </div>
                <span class="text-sm font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['memory_pct'] }}%</span>
            </div>
            <div class="flex justify-between text-[9px] text-slate-400 dark:text-gray-500 font-mono mb-2 uppercase tracking-tight">
                <span>Usage: {{ $stats['memory'] }}</span>
                <span>Limit: {{ $stats['memory_limit'] }}</span>
            </div>
            <div class="w-full bg-slate-100 dark:bg-gray-800 rounded-full h-1.5">
                <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(99,102,241,0.4)]" style="width: {{ $stats['memory_pct'] }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 p-4 rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-purple-50 dark:bg-purple-500/10 rounded-lg">
                        <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold font-mono text-slate-500 dark:text-gray-400 uppercase tracking-widest">Network IO</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="text-xs font-mono text-slate-600 dark:text-gray-300">
                    <span class="opacity-50 tracking-tighter mr-1">IN/OUT:</span> {{ $stats['net_io'] }}
                </div>
                <div class="h-2 w-2 rounded-full bg-purple-500 animate-ping"></div>
            </div>
        </div>
    @else
        <div class="bg-slate-50 dark:bg-gray-950 border border-dashed border-slate-300 dark:border-gray-800 p-8 rounded-xl flex flex-col items-center justify-center text-center">
            <svg class="w-8 h-8 text-slate-300 dark:text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h4 class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest">Stats Restricted</h4>
            <p class="text-[10px] text-slate-400 dark:text-gray-600 font-mono mt-1">You do not have permission to view real-time container metrics.</p>
        </div>
    @endcan
</div>