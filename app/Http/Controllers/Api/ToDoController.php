<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:"crear todos"', ['only' => ['store']]);
        $this->handlePermissions([
            'crear todos'   =>  ['store'],
            'ver todos'     =>  ['index', 'show'],
            'editar todos'  =>  ['update', 'updateDoneAt'],
            'eliminar todos' =>  ['destroy', 'destroyDones']
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = optional(auth()->user()); # Evitar el error del linter

        return json(['data' => $user->todos()->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         =>  ['required'],
            'description'   =>  ['nullable']
        ]);

        $todo = $request->user()->todos()->create($data);

        return json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = optional(auth()->user()); # Evitar el error del linter
        $todo = $user->todos()->whereId($id)->firstOrFail();

        return json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title'         =>  ['required'],
            'description'   =>  ['nullable']
        ]);

        $todo = $request->user()->todos()->whereId($id)->firstOrFail();
        $todo->update($data);

        if (!$todo->wasChanged())
            return json(['message' => 'No se pudo hacer el cambio'], 500);

        return nothing();
    }

    /**
     * Update done_at.
     */
    public function updateDoneAt(Request $request, string $id)
    {
        $todo = $request->user()->todos()->whereId($id)->firstOrFail();
        $todo->update([
            'done_at' => $todo->done_at == null ? now() : null
        ]);

        if (!$todo->wasChanged())
            return json(['message' => 'No se pudo hacer el cambio'], 500);

        return nothing();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = optional(auth()->user()); # Evitar el error del linter
        $todo = $user->todos()->whereId($id)->firstOrFail();

        $todo->delete();

        if ($todo->exists)
            return json(['message' => 'No se pudo eliminar'], 500);

        return nothing();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyDones()
    {
        $user = optional(auth()->user()); # Evitar el error del linter

        $todos = $user->todos()->whereNotNull('done_at')->delete();

        if ($todos == 0)
            return json(['message' => 'No se pudieron eliminar'], 500);

        return nothing();
    }
}
