@extends('template')

@section('title', 'Realizar venta')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Realizar venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{ route('ventas.index') }}">Venta</a></li>
        <li class="breadcrumb-item active">Realizar venta</li>
    </ol>
</div>

<form action="{{route('ventas.store')}}" method="post">
    @csrf

    <div class="container mt-4">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalle de la venta
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">

                        {{-- producto --}}
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" data-size="4" title="Seleccione un producto">
                                @foreach ($productos as $producto )
                                    <option value="{{$producto->id}}-{{$producto->stock}}-{{$producto->precio_venta}}">{{$producto->codigo.' '.$producto->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- stock --}}
                        <div class="d-flex justify-content-end">
                            <div class="col-md-6 mb-2">
                                <div class="row">
                                    <label for="stock" class="form-label col-sm-4">En stock:</label>
                                    <div class="col-sm-8">
                                        <input disabled id="stock" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- cantidad --}}
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad: </label>
                            <input  type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>

                        {{-- precio de venta --}}
                        
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta: </label>
                            <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                        </div>

                        {{-- descuento --}}
                        
                        <div class="col-md-4 mb-2">
                            <label for="descuento" class="form-label">Descuento: </label>
                            <input  type="number" name="descuento" id="descuento" class="form-control" step="0.1">
                        </div>

                        {{-- boton --}}
                        <div class="col-md-12 mt-3 text-end">
                            <button id="btn_agregar" type="submit" class="btn btn-primary">Agregar</button>
                        </div>

                        
                        {{-- tabla para el detalle de compra --}}

                        <div class="col-md-12 mt-2">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio de compra</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Sumas</th>
                                            <th colspan="2"><span id="sumas">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">IGV %</th>
                                            <th colspan="2"><span id="igv">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>  

                        {{-- boton para cancelar la compra --}}

                        <div class="col-md-12 mb-2 text-end">
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar compra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">

                        {{-- Cliente --}}
                        <div class="col-md-12 mb-2">
                            <label for="cliente_id" class="form-label">Cliente: </label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size="3">
                                @foreach ($clientes as $cliente )
                                    <option value="{{$cliente->id}}">{{$cliente->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- tipo comprobante --}}
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante: </label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick" title="Selecciona">
                                @foreach ($comprobantes as $comprobante )
                                    <option value="{{$comprobante->id}}">{{$comprobante->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- numero de comprobante --}}
                        <div class="col md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">Número de comprobante: </label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante')
                                <small class="text-danger">{{'*'.$message}}</small>
                             @enderror
                        </div>

                        {{-- impuesto --}}
                        <div class="col-md-6-mb-2">
                            <label for="impuesto" class="form-label">Impuesto (IGV): </label>
                            <input type="text" name="impuesto" id="impuesto" class="form-control border-success">
                            @error('impuesto')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        {{-- fecha --}}
                        <div class="col-md-6-mb-2">
                            <label for="fecha" class="form-label">Fecha: </label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
    
                            <?php 
                            use Carbon\Carbon;
                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
    
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>

                        {{-- user --}}

                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                        {{-- botones --}}
                        <div class="col-md-12 mt-3 text-end">
                            <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para cancelar compra -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar compra!</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Está seguro que desea cancelar la compra?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
            </div>
        </div>
        </div>
    </div>

</form>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function(){
        
        $('#producto_id').change(mostrarValores);
        
        $('#btn_agregar').click(function(){
            agregarProducto();
        });
        
        $('#btnCancelarVenta').click(function(){
            cancelarVenta();
        });

        disableButtons();

        $('#impuesto').val(impuesto + '%');
        
    });

    //variables
    let cont = 0;
    let subTotal = [];
    let suma = 0;
    let igv = 0;
    let total = 0;
    //constante
    let impuesto = 18;

    function mostrarValores(){
        datosProducto = document.getElementById('producto_id').value.split('-');
        $('#stock').val(datosProducto[1]);
        $('#precio_venta').val(datosProducto[2]);
    }

    function agregarProducto(){ 
        let datosProducto = document.getElementById('producto_id').value.split('-');
        let idProducto = datosProducto[0];
        let nameProducto = $('#producto_id option:selected').text();
        let cantidad = $('#cantidad').val();
        let precioVenta = $('#precio_venta').val();
        let descuento = $('#descuento').val();
        let stock = $('#stock').val();

        if(descuento == ''){
            descuento = 0;
        }
        

        // VALIDACIONES
        // 1.validaciones para no acpetar campos vacios

        if(idProducto != '' && cantidad != ''){
            
            // 2.para que los valores ingresados sean correctos
            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {
                //para que la cantidad no supere el stock
                if (parseFloat(cantidad) <= parseInt(stock)) {
                    //calcular valores
                    subTotal[cont] = round(cantidad * precioVenta - descuento);
                    suma += subTotal[cont];
                    igv = round(suma/100 * impuesto);
                    total = round(suma + igv);

                    let fila = '<tr id="fila'+ cont + '">' +
                        '<th>'+ (cont + 1) +'</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="'+ idProducto +'">'+ nameProducto +'</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="'+ cantidad +'">'+ cantidad +'</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="'+ precioVenta +'">'+ precioVenta +'</td>' +
                        '<td><input type="hidden" name="arraypreciodescuento[]" value="'+ descuento +'">'+ descuento +'</td>' +
                        '<td>'+ subTotal[cont] +'</td>' +
                        '<th><button class="btn btn-danger" type="button" onClick="eliminarProducto('+ cont +')"><i class="fa-solid fa-trash"></i></button></th>' +
                        '</tr>';
                    
                    //acciones despues de añadir la fila
                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;
                    disableButtons();

                    // mostrar los campos calculados

                    $('#sumas').html(suma);
                    $('#igv').html(igv);
                    $('#total').html(total);
                    $('#impuesto').val(igv);
                    $('#inputTotal').val(total);

                    
                } else {
                    showModal('Cantidad incorrecta!');
                }

            } else {
                showModal('Valores incorrectos');
            }
            
            
        }else{
            showModal('Complete todos los campos!')
        }
    }

    function disableButtons(){
        if(total == 0){
            $('#guardar').hide();
            $('#cancelar').hide();
        }else{
            $('#guardar').show();
            $('#cancelar').show();
        }
    }

    function eliminarProducto(indice){
        // calcular valores
        suma -= round(subTotal[indice]);
        igv = round(suma/100 * impuesto);
        total = round(suma + igv);

        //mostrar los campos calculados
        $('#sumas').html(suma);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(igv);
        $('#inputTotal').val(total);

        //eliminar la fila de la tabla
        $('#fila'+indice).remove();

        disableButtons();
    }

    function cancelarVenta(){
        // eliminar tbody de la tabla
        $('#tabla_detalle tbody').empty();

        //añadimos una fila vacia a la tabla(solo estetica)
        let fila = '<tr>' +
            '<th></th>' +
            '<th></th>' +
            '<th></th>' +
            '<th></th>' +
            '<th></th>' +
            '<th></th>' +
            '<th></th>' +
        '</tr>';

        $('#tabla_detalle').append(fila);

        //reinicio de variables
        cont = 0;
        subTotal = [];
        suma = 0;
        igv = 0;
        total = 0;

        
        $('#sumas').html(suma);
        $('#igv').html(igv);
        $('#total').html(total);
        $('#impuesto').val(impuesto + '%');
        $('#inputTotal').val(total);


        limpiarCampos();
        disableButtons();
    }

    function limpiarCampos(){
        let select = $('#producto_id');
        select.selectpicker();
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_venta').val('');
        $('#descuento').val('');
        $('#stock').val('');

    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) //con 0 decimales
            return signo * Math.round(num);
        // round(x * 10 ^ decimales)
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        // x * 10 ^ (-decimales)
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
    //fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
    
    function showModal(message, icon = 'error'){
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: icon,
        title: message
        });
    }

</script>
@endpush
