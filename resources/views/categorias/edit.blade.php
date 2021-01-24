@extends('app')

@section('title', 'Categorias -> ' . $category->dsCategoria)

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categorias.update', $category) }}">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" class="form-control" id="nome" placeholder="Nome" value="{{ $category->dsCategoria }}">
        </div>

        <button type="submit" class="btn btn-success">Alterar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-primary">Voltar</a>
    </form>
@endsection