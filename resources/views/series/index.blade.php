<x-layout title="Lista das series">
    <h1>Primeira view</h1>
    <div>
        @foreach ($series as $serie)
            <ul>
                <li>{{ $serie }}</li>
            </ul>
        @endforeach
    </div>
</x-layout>
