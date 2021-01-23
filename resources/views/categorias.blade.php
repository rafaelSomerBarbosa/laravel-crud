@extends('app')

@section('title', 'Categorias')

@section('content')
    <div>
        <button type="button" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i>
            Cadastrar
        </button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
            <tr>                
                <th scope="row">{{$categoria->idCategoria}}</th>
                <td>{{$categoria->dsCategoria}}</td>
            </tr>
            @endforeach
        </tr>
    </tbody>
    </table>
    
@endsection