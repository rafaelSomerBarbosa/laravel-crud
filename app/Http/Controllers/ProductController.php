<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produtos.index', ['products' => Product::orderBy('idProduto', 'desc')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produtos.create', ['categories' => Category::orderBy('idCategoria', 'desc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'nome' => 'required|max:255',
                'sku' => 'required|max:120',
                'categoria' => 'required',
                'imagens.*' => 'nullable|file|mimes:jpeg,bmp,png,jpg'
            ]);

            $inserted = Product::create([
                'nmProduto' => $validate['sku'],
                'dsProduto' => $validate['nome'],
                'idCategoria' => $validate['categoria'],
            ]);

            if($request->has('imagens')) {
                $files = $request->file('imagens');
                foreach ($files as $file) {
                    $file->store('public/produtos/' . $inserted->idProduto);

                    Image::create([
                        'dsImagem' => $file->getClientOriginalName(),
                        'nomeDoArquivo' => $file->hashName(),
                        'idProduto' => $inserted->idProduto,
                    ]);
                }
            }

            return redirect()->route('produtos.index');
        } catch(QueryException $e) {
            return redirect()->route('produtos.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->view('produtos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::find($id);

            return view('produtos.edit', ['product' => $product, 'categories' => Category::orderBy('idCategoria', 'desc')->get()]);
        } catch(QueryException $e) {
            return redirect()->route('produtos.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validate = $request->validate([
                'nome' => 'required|max:255',
                'sku' => 'required|max:120',
                'categoria' => 'required',
                'imagens.*' => 'nullable|file|mimes:jpeg,bmp,png,jpg'
            ]);

            Product::find($id)->update([
                'nmProduto' => $validate['sku'],
                'dsProduto' => $validate['nome'],
                'idCategoria' => $validate['categoria'],
            ]);

            if($request->has('imagens')) {
                $files = $request->file('imagens');
                foreach ($files as $file) {
                    $file->store('public/produtos/' . $id);

                    Image::create([
                        'dsImagem' => $file->getClientOriginalName(),
                        'nomeDoArquivo' => $file->hashName(),
                        'idProduto' => $id,
                    ]);
                }
            }

            return redirect()->route('produtos.edit', ['produto' => $id]);
        } catch(QueryException $e) {
            return redirect()->route('produtos.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            $images = $product->images()->get();

            foreach($images as $image) {
                Storage::disk('public')->delete("produtos/" . $id . '/' . $image->nomeDoArquivo);
                $image->delete();
            }

            Storage::disk('public')->deleteDirectory("produtos/" . $id);

            $product->delete();

            return redirect()->route('produtos.index');
        } catch(QueryException $e) {
            return redirect()->route('produtos.index')->withErrors($e->getMessage());
        }

    }
}
