<div>
    @if($modManager == 'Manual')
        <livewire:admin.server-mods.manager.manual />
    @elseif($modManager == 'CurseForge')
        <livewire:admin.server-mods.manager.curseforge />    
    @endif
</div>