@extends('app')

@section('title', 'Produtos')

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
        <a href="{{ route('produtos.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i>
            Cadastrar
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">SKU</th>
                <th scope="col">Nome</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <th scope="row">{{$product->idProduto}}</th>
                <td>{{$product->nmProduto}}</td>
                <td>{{$product->dsProduto}}</td>
                <td>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('produtos.edit', ['produto' => $product->idProduto]) }}" class="btn btn-sm btn-warning mr-3">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="submit" class="btn btn-sm btn-danger" onclick="openDiaolog({{ $product->idProduto }})">
                            <i class="bi bi-trash"></i>
                        </button>
                        <form method="POST" action="{{ route('produtos.destroy', ['produto' => $product->idProduto]) }}" class="d-none" id="remove-product-{{ $product->idProduto }}">
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
        {{ $products->links() }}
    </div>

    <div class="modal" tabindex="-1" id="modal-remove-product">
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
                    <button type="button" class="btn btn-danger" onclick="removeProduct()" id="data-id-remove">Excluir</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_footer')
    <script>
        const dialogremoveProduct = new bootstrap.Modal(document.querySelector('#modal-remove-product'), {
            keyboard: false
        })

        const buttonRemove = document.querySelector('#data-id-remove')
        
        function openDiaolog(id) {
            buttonRemove.setAttribute('data-id', id)
            dialogremoveProduct.toggle()
        }

        function removeProduct(e) {
            document
                .querySelector(`#remove-product-${buttonRemove.getAttribute('data-id')}`)
                .submit()
        }
    </script>
@endpush