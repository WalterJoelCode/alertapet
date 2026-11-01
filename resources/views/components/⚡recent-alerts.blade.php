<?php

use Livewire\Component;

new class extends Component
{
    public string $type = 'perdidas';

    public function show(string $type): void
    {
        $this->type = $type;
    }
};
?>

<div class="surface-card p-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"><div><h3 class="text-xl font-black text-pet-charcoal">Alertas recientes</h3><p class="mt-1 text-sm text-pet-slate">Información de demostración mientras se integra el módulo.</p></div><div class="flex rounded-xl bg-pet-surface p-1"><button wire:click="show('perdidas')" @class(['rounded-lg px-3 py-2 text-sm font-bold', 'bg-white text-pet-gold-strong shadow-sm' => $type === 'perdidas', 'text-pet-slate' => $type !== 'perdidas'])>Perdidas</button><button wire:click="show('encontradas')" @class(['rounded-lg px-3 py-2 text-sm font-bold', 'bg-white text-pet-charcoal shadow-sm' => $type === 'encontradas', 'text-pet-slate' => $type !== 'encontradas'])>Encontradas</button></div></div>
    @foreach ($type === 'perdidas' ? [['Luna', 'Barrio San Juan', 'Hace 2 h'], ['Toby', 'Centro', 'Hace 5 h'], ['Milo', 'Las Colinas', 'Ayer']] : [['Cachorra canela', 'Mercado Oriental', 'Hace 1 h'], ['Gato atigrado', 'Altamira', 'Hace 4 h'], ['Perrito blanco', 'Carretera Sur', 'Ayer']] as [$name, $place, $time])
        <div class="flex items-center gap-4 border-t border-pet-charcoal/10 py-4 first:mt-5"><div @class(['grid size-11 place-items-center rounded-xl', 'bg-pet-surface text-pet-gold-strong' => $type === 'perdidas', 'bg-pet-charcoal text-pet-primary' => $type === 'encontradas'])><i class="fa-solid fa-paw" aria-hidden="true"></i></div><div class="grow"><p class="font-bold text-pet-charcoal">{{ $name }}</p><p class="text-sm text-pet-slate">{{ $place }}</p></div><span class="text-xs text-pet-slate">{{ $time }}</span></div>
    @endforeach
</div>
