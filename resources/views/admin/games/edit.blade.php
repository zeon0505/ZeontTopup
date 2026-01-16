<x-admin-layout>
    <x-slot name="title">Edit Game</x-slot>
    <x-slot name="pageTitle">Edit Game</x-slot>
    <x-slot name="pageDescription">Update game information</x-slot>

    <livewire:admin.game-edit :game="$game" />
</x-admin-layout>
