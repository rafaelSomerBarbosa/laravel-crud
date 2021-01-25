<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categorias.index', ['categories' => Category::orderBy('idCategoria', 'desc')->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
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
                'nome' => 'required|max:255|unique:Categoria,dsCategoria',
            ]);
    
            Category::create(['dsCategoria' => $validate['nome']]);
    
            return redirect()->route('categorias.index');
        } catch(QueryException $e) {
            return redirect()->route('produtos.index')->withErrors($e->getMessage());
        }
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
            return view('categorias.edit', ['category' => Category::find($id)]);
        } catch(QueryException $e) {
            return view('categorias.edit', ['error' => $e->getMessage()]);
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
            ]);
    
            Category::find($id)->update(['dsCategoria' => $validate['nome']]);
            
            return redirect()->route('categorias.index');
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
            Category::destroy($id);

            return redirect()->route('categorias.index');
        } catch(QueryException $e) {
            if($e->getCode() == 23000) {
                return redirect()->route('categorias.index')->withErrors('Não é possivel remover essa categoria pois ela já está vinculado a um produto.');
            }

            return redirect()->route('categorias.index')->withErrors($e->getMessage());
        }
    }
}
