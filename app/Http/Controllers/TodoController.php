<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public  function index(){

        $todo= Todo::orderBy('completed')->get();
        return view('Todo.all-todo', compact('todo'));
    }

    public  function create(){
        return view('Todo.create');
    }

    public  function store( Request $request){
        $validated = $request->validate([
            'title' => 'required|unique:todos|max:255',
        ]);
        
        $title = new Todo();
        $title->title = $request->title;
        $title->save();
        return redirect()->route('all');
    }

    public  function edit(Todo $todo){
        return view('Todo.edit', compact('todo'));
    }

    public  function update( Request $request, Todo $todo){

        $todo->update([
            'title'=>$request->title,
        ]);
        return redirect()->route('all');
    }

    public function complete(Todo $todo){
        $todo->update([
            'completed'=>true,
        ]);
        return redirect()->back();
    }

    public function incomplete(Todo $todo){
        $todo->update([
            'completed'=>false,
        ]);
        return redirect()->back();
    }
}