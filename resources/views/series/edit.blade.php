<x-layout title="editar Série">
    <x-form action="/series/{{ $series->id }}" :update="true" :name="$series->name" buttonName="Editar" />
</x-layout>
