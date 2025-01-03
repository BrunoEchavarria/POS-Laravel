<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class compraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante', 'proveedore.persona')
        ->where('estado',1)
        ->latest()
        ->get();
        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::whereHas('persona', function($query){
            $query->where('estado',1);
        })->get();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado',1)->get();
        return view('compras.create', compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        //dd($request->validated());

        try{
            DB::beginTransaction();

            //llenar compras
            $compra = Compra::create($request->validated());

            //llenar tabla compra_productos
            //1.recuperarar los arrays

            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            // 2. realizar el lllenado
            $sizeArray = count($arrayProducto_id);
            $contador = 0;
            while($contador < $sizeArray){
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$contador] => [
                        'cantidad' => $arrayCantidad[$contador],
                        'precio_compra' => $arrayPrecioCompra[$contador],
                        'precio_venta' => $arrayPrecioVenta[$contador]
                    ]
                ]);
                
                // 3.Actualizar Stock
                $producto = Producto::find($arrayProducto_id[$contador]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$contador]);


                DB::table('productos')
                ->where('id',$producto->id)
                ->update([
                    'stock' => $stockActual + $stockNuevo
                ]);

                $contador++;

            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('compras.index')->with('success', 'Compra exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Compra::where('id',$id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('compras.index')->with('success', 'Compra eliminada');
    }
}
