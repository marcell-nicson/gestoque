<?php

use App\Events\ProdutoCriado;
use App\Http\Controllers\AfiliadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaidaController;
use App\Http\Controllers\VendaController;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('welcome');
})->name('/');

Route::get('/', [ProdutoController::class, 'ofertas'])->name('ofertas.ofertas');
Route::get('/ofertas', [ProdutoController::class, 'ofertas'])->name('ofertas.ofertas');
Route::get('ofertas/{id}', [ProdutoController::class, 'showOferta'])->name('ofertas.showOferta'); 

Route::get('/dashboard', [ProdutoController::class, 'index']) //retorna a listagem de produtos por enquanto
->middleware(['auth', 'verified'])->name('dashboard.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('produtos/', [ProdutoController::class, 'index'])->name('produtos.index'); 
        Route::get('produtos/create', [ProdutoController::class, 'create'])->name('produtos.create'); 
        Route::post('produtos/store', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('produtos/{id}', [ProdutoController::class, 'show'])->name('produtos.show'); 
        Route::get('produtos/{id}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit'); 
        Route::put('produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update'); 
        Route::delete('destroy/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

        Route::post('/produtos/reenviar/{id}', [ProdutoController::class, 'reenviar'])->name('produtos.reenviar');
        
    Route::prefix('categorias')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('categorias.index'); // Listar produtos
        Route::get('/create', [CategoriaController::class, 'create'])->name('categorias.create'); // Formulário para criar produto
        Route::post('/store', [CategoriaController::class, 'store'])->name('categorias.store'); // Armazenar novo produto
        Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy'); // Excluir produto
    });

        Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');
        Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
        Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
        Route::get('fornecedores/{id}', [FornecedorController::class, 'show'])->name('fornecedores.show'); 
        Route::get('/fornecedores/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
        Route::put('/fornecedores/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
        Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');


        Route::post('marcas/store', [MarcaController::class, 'store'])->name('marcas.store'); 
        Route::post('entradas/entrada_create/{id}', [FornecedorController::class, 'entrada_create'])->name('entradas.entrada_create');
        Route::put('fornecedores/{id}/entradaUpdate', [FornecedorController::class, 'entradaUpdate'])->name('entradas.entradaUpdate');

        Route::get('/vendas', [VendaController::class, 'index'])->name('vendas.index');
        Route::post('/vendas/finalizar', [VendaController::class, 'finalizarCompra'])->name('vendas.finalizar');
        Route::post('/vendas/store', [VendaController::class, 'store'])->name('vendas.store');


        Route::get('/saidas', [SaidaController::class, 'index'])->name('saidas.index');
        Route::post('/saidas/adicionar/{produtoId}', [SaidaController::class, 'adicionar'])->name('saidas.adicionar');
        Route::post('/saidas/ajustar/{id}', [SaidaController::class, 'ajustarQuantidade'])->name('saidas.ajustarQuantidade');
        Route::delete('/saidas/remover/{id}', [SaidaController::class, 'remover'])->name('saidas.remover');

        Route::put('/saidas/adicionar-multiplos', [SaidaController::class, 'adicionarMultiplos'])->name('saidas.adicionarMultiplos');

        Route::get('/afiliado', [AfiliadoController::class, 'index'])->name('afiliado.index');
        Route::post('/afiliado/adicionarMembrosNoGrupo', [AfiliadoController::class, 'adicionarMembrosNoGrupo'])->name('afiliado.adicionarMembrosNoGrupo');

        Route::post('grupos/store', [GrupoController::class, 'store'])->name('grupos.store'); 
        Route::delete('grupos/destroy/{id}', [GrupoController::class, 'destroy'])->name('grupos.destroy'); 



});

require __DIR__.'/auth.php';
