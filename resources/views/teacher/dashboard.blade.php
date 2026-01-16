<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Teacher Dashboard</h2>
    </x-slot>

    <div class="py-12">
        Welcome, {{ Auth::user()->name }}! You are a Teacher.
    </div>
</x-app-layout>
