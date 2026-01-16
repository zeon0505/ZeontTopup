<x-admin-layout>
    <x-slot name="title">Game Details</x-slot>
    <x-slot name="pageTitle">Game Details</x-slot>
    <x-slot name="pageDescription">View complete game information</x-slot>

    <livewire:admin.game-detail :game="$game" />
</x-admin-layout>
