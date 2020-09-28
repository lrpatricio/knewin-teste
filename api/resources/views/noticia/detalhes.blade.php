@extends('master')
@section('conteudo')
    <div class="container">
        <h2>{{$item['_source']['titulo']}}</h2>
        <h4>{!! nl2br($item['_source']['subtitulo']) !!}</h4>
        <i>{{ (new DateTime($item['_source']['data_publicacao']))->format('d/m/Y H:i') }}</i>

        <p class="mb-5 mt-5">{!! nl2br($item['_source']['conteudo']) !!}</p>

        <p>
            Fonte: {{ $item['_source']['fonte'] }}
            <br/>
            (<a href="{{ $item['_source']['url'] }}" class="btn-link" target="_blank">{{ $item['_source']['url'] }}</a>)
        </p>
        <a href="{{route('noticia')}}" class="mb-5">Voltar</a>
    </div>
@endsection