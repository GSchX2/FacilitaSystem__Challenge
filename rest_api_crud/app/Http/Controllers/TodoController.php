<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreUpdateRequest;
use App\Http\Resources\TodoResources;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        // Retorna todo o banco de dados
        return TodoResources::collection($todos);
    }

    /* Armazena no banco de dados as informações repassadas na 
    requisição após elas serem verificadas como válidas */
    public function store(TodoStoreUpdateRequest $request)
    {
        $data = $request->validated();
        $todo = Todo::create($data);

        // Retorna os dados criados para a banco de dados de forma filtrada
        return new TodoResources($todo);
    }

    public function show(string $id)
    {
        /* Com base no endereço da rota procura pelo existência do 
        id no banco de dados no campo id */
        $show = Todo::findOrFail($id);

        /* Retorna os dados encontrados no banco de dados de forma filtrada, 
        caso não encontre mostra a mesagem de erro */
        return new TodoResources($show);
    }

    public function update(TodoStoreUpdateRequest $request, string $id)
    {
        /* Com base no endereço da rota procura pelo existência do 
        id no banco de dados no campo id */
        $todo = Todo::findOrFail($id);

        // Valida os dados passados na requisição
        $updatedTodo = $request->validated();

        /* Se dados foram encontrados para aquele id ocorre a alteração no 
        banco de dados, substituindo apenas os dados alterados */
        $todo->update($updatedTodo);

        // Retorna os dados completos atualizados de forma filtrada
        return new TodoResources($todo);
    }

    public function destroy(string $id)
    {
        /* Com base no endereço da rota procura pelo existência do 
        id no banco de dados no campo id */
        $toDelete = Todo::findOrFail($id);

        // Deleta do banco de dados os dados encontrados para aquele id
        $toDelete->delete();
      
    }
}
