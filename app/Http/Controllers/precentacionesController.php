<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\StorePresentacionesRequest;
use App\Http\Requests\UpdatePrecentacionRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class precentacionesController extends Controller
{
    public function index(){
        $presentacione = Presentacione::with('caracteristica')->latest()->get();
        return view('presentacione.index', ['presentacione'=>$presentacione]);
    }

    public function create(){
        return view('presentacione.create');
    }

    public function store(StoreCategoriaRequest $request){

        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){   
            DB::rollBack();
        }
        return redirect()->route('presentaciones.index')->with('success', 'Presentacion creada correctamente');
    }

    public function show(string $id){
        //
    }

    public function edit(Presentacione $presentacione)
    {
        return view('presentacione.edit', ['presentacione' => $presentacione]);
    }

    public function update(UpdatePrecentacionRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id', $presentacione->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('presentaciones.index')->with('success', 'Presentacion actualizada');
    }

    public function destroy(string $id)
    {
        $message = '';
        $presentacione = Presentacione::find($id);
        if($presentacione->caracteristica->estado == 1) {
            Caracteristica::where('id', $presentacione->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Presentacion eliminada correctamente';
        }else{
            Caracteristica::where('id', $presentacione->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Presentacion eliminada correctamente';
        }
        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
