<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $max_data = 5;
        // pencarian
        if(request('search')){
            $data = Todo::where('task', 'like','%' . request('search') . '%')->paginate($max_data)->withQueryString();
        }else{
            $data = Todo::orderBy('id', 'asc')->paginate($max_data);
        }

        
        //cara dulu
        // return view('todo.app', ['data' => $data]);

        return view('todo.app', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|min:3|max:50',
        ],[
            'task.required' => 'Task Wajib diisi',
            'task.min' => 'Task minimal 3 karakter',
            'task.max' => 'Task maksimal 50 karakter',
        ]);

        $data = [
            'task' => $request->input('task'),
        ];

        Todo::create($data);
        //success session kirim ke blade
        // route todo dari web.php route name todo
        return redirect()->route('todo')->with('success', 'Task Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'task' => 'required|min:3|max:50',
        ],[
            'task.required' => 'Task Wajib diisi',
            'task.min' => 'Task minimal 3 karakter',
            'task.max' => 'Task maksimal 50 karakter',
        ]);

        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done'),
        ];

        Todo::where('id', $id)->update($data);
        return redirect()->route('todo')->with('success', 'Task Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::where('id', $id)->delete();
        return redirect()->route('todo')->with('success', 'Task Berhasil Dihapus');
    }
}
