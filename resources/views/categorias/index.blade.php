@extends('app')

@section('title', 'Categorias')

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

    <div>
        <a href="{{ route('categorias.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i>
            Cadastrar
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <th scope="row">{{$category->idCategoria}}</th>
                <td>{{$category->dsCategoria}}</td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('categorias.edit', ['categoria' => $category->idCategoria]) }}" class="btn btn-sm btn-warning mr-3">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="submit" class="btn btn-sm btn-danger" onclick="openDiaolog({{ $category->idCategoria }})">
                            <i class="bi bi-trash"></i>
                        </button>
                        <form method="POST" action="{{ route('categorias.destroy', ['categoria' => $category->idCategoria]) }}" class="d-none" id="remove-category-{{ $category->idCategoria }}">
                            @method('DELETE')
                            @csrf
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>

    <div class="modal" tabindex="-1" id="modal-remove-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remover categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja removere essa categoria?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" onclick="removeCategory()" id="data-id-remove">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_footer')
    <script>
        const dialogRemoveCategory = new bootstrap.Modal(document.querySelector('#modal-remove-category'), {
            keyboard: false
        })

        const buttonRemove = document.querySelector('#data-id-remove')
        
        function openDiaolog(id) {
            buttonRemove.setAttribute('data-id', id)
            dialogRemoveCategory.toggle()
        }

        function removeCategory(e) {
            document
                .querySelector(`#remove-category-${buttonRemove.getAttribute('data-id')}`)
                .submit()
        }
    </script>
@endpush