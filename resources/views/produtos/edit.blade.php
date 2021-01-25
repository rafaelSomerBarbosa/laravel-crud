@extends('app')

@section('title', 'Produtos -> ' . $product->dsProduto)

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

    <form method="POST" action="{{ route('produtos.update', ['produto' => $product->idProduto]) }}" enctype="multipart/form-data">
        @METHOD('PATCH')
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" class="form-control" id="nome" placeholder="Nome" value="{{ $product->dsProduto }}" required />
        </div>

        <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input name="sku" class="form-control" id="sku" placeholder="sku" value="{{ $product->nmProduto }}" required />
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select class="form-select" name="categoria">
                @foreach ($categories as $category) 
                    <option value="{{ $category->idCategoria }}" {{ $product->idCategoria == $category->idCategoria ? 'selected' : '' }}>{{ $category->dsCategoria }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Imagens</label>
            <input name="imagens[]" type="file" class="form-control" id="upload-file" multiple accept="image/png, image/jpeg" />
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-primary">Voltar</a>
    </form>

    <h1 class="mt-3 mb-1 d-none text-xl" id="title-preview">Novas imagens a ser cadastrada</h1>
    <div id="preview-images-new-images" class="d-flex flex-row flex-wrap"></div>
    
    <h1 class="mt-3 mb-1 text-xl {{ $product->images()->get()->count() == 0 ? 'd-none' : '' }}">Imagens</h1>
    <div id="preview-images">
        <div class="row d-flex flex-row flex-wrap">
            @foreach ($product->images()->get() as $image)                    
                <div class="col-auto position-relative remove-image">
                    <form id="remove-image-{{ $image->idImagem }}" method="POST" action="{{ route('image.destroy', ['image' => $image->idImagem]) }}">
                        @method('DELETE')
                        @csrf
                    </form>
                    
                    <img src="{{ asset('storage/produtos/' . $product->idProduto . '/' . $image->nomeDoArquivo) }}" class="img-thumbnail mb-3" style="height: 150px;" />
                    <div class="position-absolute top-50 start-50 translate-middle content-button-remove">
                        <button type="submit" form="remove-image-{{ $image->idImagem }}" class="btn btn-danger">Remover</button>
                    </div>
                </div>                    
            @endforeach
        </div>
    </div>
@endsection

@push('js_footer')
    <script>
        document.querySelector('#upload-file').addEventListener('change', (event) => {
            document.querySelector('#preview-images-new-images').innerHTML = ''
            document.querySelector('#title-preview').classList.remove('d-none')
            const inputFile = event.target

            if(!inputFile.files.length) {
                document.querySelector('#title-preview').classList.add('d-none')
            }
            
            for(file of inputFile.files) {
                const image = document.createElement('img')
                image.classList.add('img-thumbnail', 'mb-3', 'mr-3')
                image.src = URL.createObjectURL(file)
                console.log(image, file)
                image.style.cssText = `height: 150px;`

                document.querySelector('#preview-images-new-images').appendChild(image)
            }
        })
    </script>
@endpush