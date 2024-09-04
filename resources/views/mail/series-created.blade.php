<x-mail::message>
    # {{ $seriesName }}
    Sua série {{ $seriesName }} foi criada com sucesso!

    Cada episódio da série está disponível agora.

    <x-mail::button :url="$url" color="success">
        Ver Série
    </x-mail::button>


</x-mail::message>
