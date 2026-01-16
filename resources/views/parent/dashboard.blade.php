<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Parent Dashboard</h2>
    </x-slot>

    <div class="py-12">
        Welcome, {{ Auth::user()->name }}! You are a Parent.
    </div>
</x-app-layout>
