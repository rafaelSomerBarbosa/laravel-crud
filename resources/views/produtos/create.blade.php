@extends('app')

@section('title', 'Produtos -> Novo')

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

    <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" class="form-control" id="nome" placeholder="Nome" required>
        </div>

        <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input name="sku" class="form-control" id="sku" placeholder="sku" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select class="form-select" name="categoria">
                @foreach ($categories as $category) 
                    <option value="{{ $category->idCategoria }}">{{ $category->dsCategoria }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Imagens</label>
            <input name="imagens[]" type="file" class="form-control" id="upload-file" multiple accept="image/png, image/jpeg">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-primary">Voltar</a>

        <h1 class="mt-3 mb-1 d-none text-xl" id="title-preview">Preview das imagens</h1>
        <div id="preview-images" class="d-flex flex-row flex-wrap"></div>
    </form>

@endsection

@push('js_footer')
    <script>
        document.querySelector('#upload-file').addEventListener('change', (event) => {
            document.querySelector('#preview-images').innerHTML = ''
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

                document.querySelector('#preview-images').appendChild(image)
            }
        })
    </script>
@endpush