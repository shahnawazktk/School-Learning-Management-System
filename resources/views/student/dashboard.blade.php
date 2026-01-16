<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Student Dashboard</h2>
    </x-slot>

    <div class="py-12">
        Welcome, {{ Auth::user()->name }}! You are a Student.
    </div>
</x-app-layout>
