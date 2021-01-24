@extends('app')

@section('title', 'Categorias -> Novo')

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

    <form method="POST" action="{{ route('categorias.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" class="form-control" id="nome" placeholder="Nome" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-primary">Voltar</a>
    </form>
@endsection