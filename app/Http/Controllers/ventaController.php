<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\Venta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ventaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('comprobante', 'cliente.persona')
            ->where('estado', 1)
            ->latest()
            ->get();

        // $productos = Producto::with('categorias.caracteristica', 'marca.caracteristica', 'presentacione.caracteristica')->latest()->get();

        return view('ventas.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //traemos la tabla compra producto  selecionando primeramente su producto_id filtrando por su valor maximo de craeted_at
        $subquery = DB::table('compra_producto')
        ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
        ->groupBy('producto_id');
        
        //unimos la tabla compra producto con el modelo producto 

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery){
            //especifico la condicion que debe cumplirse
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function($query) use ($subquery){
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        //cuando se cumpla la siguiente condicion
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })

            ->select('productos.nombre', 'productos.id', 'cpr.precio_venta', 'productos.stock')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();    

        //$productos = Producto::where('estado', 1)->get();
        $clientes = Cliente::whereHas('persona', function($query){
            $query->where('estado',1);
        })->get();
        $comprobantes = Comprobante::all();
        return view('ventas.create', compact('productos', 'clientes', 'comprobantes'));


        // $clientes = Cliente::whereHas('persona', function($query){
        //     $query->where('estado',1);
        // })->get();
        // $comprobantes = Comprobante::all();
        // return view('ventas.create', compact('productos', 'clientes', 'comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try{
            
            DB::beginTransaction();

            // llenar mii tabla venta
            $venta = Venta::create($request->validated());

            // llenar mi tabla venta_productos
            // 1.recuperar los arrays

            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraypreciodescuento');

            //realizaar el llenado
            $sizeArray = count($arrayProducto_id);
            $cont = 0;

            while($cont < $sizeArray){
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont]
                    ]
                ]);

                // actualizar stock
                $productos = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $productos->stock;
                $cantidad = intval($arrayCantidad[$cont]);

                DB::table('productos')
                    ->where('id', $productos->id)
                    ->update([
                        'stock' => $stockActual - $cantidad
                ]);

                $cont++;
            }

            DB::commit();
        }catch(Exception $e){
            dd($e);
            DB::rollback();
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
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
        Venta::where('id', $id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada');
    }
}
