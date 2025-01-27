@extends('template')

@section('title', 'Crear compra')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('compras.index') }}">Compra</a></li>
            <li class="breadcrumb-item active">Crear compra</li>
        </ol>
    </div>

    <form action="{{route('ventas.store')}}" method="post">
        @csrf

        <div class="container mt-4">
            <div class="row gy-4">
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalle de la compra
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            {{-- producto --}}
                            <div class="col-md-12 mb-2">
                                <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" data-size="4" title="Seleccione un producto">
                                    @foreach ($productos as $producto )
                                        <option value="{{$producto->id}}">{{$producto->codigo.' '.$producto->nombre}}</option>
                                    @endforeach
                                </select>

                            </div>

                            
                            {{-- cantidad --}}
                            <div class="col-md-4 mb-2">
                                <label for="cantidad" class="form-label">Cantidad: </label>
                                <input  type="number" name="cantidad" id="cantidad" class="form-control">
                            </div>

                            {{-- precio de compra --}}
                            <div class="col-md-4 mb-2">
                                <label for="precio_compra" class="form-label">Precio de compra: </label>
                                <input  type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                            </div>

                            {{-- precio de venta --}}
                            
                            <div class="col-md-4 mb-2">
                                <label for="precio_venta" class="form-label">Precio de venta: </label>
                                <input  type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                            </div>

                            {{-- Descuento --}}

                            {{-- <div class="col-md-4 mb-2">
                                <label for="descuento" class="form-label">Descuento: </label>
                                <input  type="number" name="descuento" id="descuento" class="form-control">
                            </div> --}}

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
                                                <th>Precio de venta</th>
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

                            {{-- boton para cancelar la venta --}}

                            <div class="col-md-12 mb-2 text-end">
                                <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Cancelar venta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- venta --}}
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            {{-- cliente --}}
                            <div class="col-md-12 mb-2">
                                <label for="proveedore_id" class="form-label">Cliente: </label>
                                <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona" data-size="3">
                                    @foreach ($proveedores as $proveedore )
                                        <option value="{{$proveedore->id}}">{{$proveedore->persona->razon_social}}</option>
                                    @endforeach
                                </select>
                                @error('proveedore_id')
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
                            </div>

                            <?php 
                            use Carbon\Carbon;
                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>

                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">

                            {{-- botones --}}
                            <div class="col-md-12 mt-3 text-end">
                                <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal para cancelar venta -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar venta!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Está seguro que desea cancelar la venta?
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
            $('#btn_agregar').click(function(){
                agregarProducto();
            });

            $('#btnCancelarCompra').click(function(){
                cancelarCompra();
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

        // constante

        const impuesto = 21;

        function cancelarCompra(){
            // eliminar tbody de la tabla
            $('#tabla_detalle > tbody').empty();

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

        function disableButtons(){
            if(total == 0){
                $('#guardar').hide();
                $('#cancelar').hide();
            }else{
                $('#guardar').show();
                $('#cancelar').show();
            }
        }

        function agregarProducto(){ 
            let idProducto = $('#producto_id').val();
            let nameProducto = ($('#producto_id option:selected').text()).split(' ')[1];
            let cantidad = $('#cantidad').val();
            let precioCompra = $('#precio_compra').val();
            let precioVenta = $('#precio_venta').val();

            // VALIDACIONES
            // 1.validaciones para no acpetar campos vacios

            if(idProducto != '' && nameProducto != '' && cantidad != '' && precioCompra != '' && precioVenta != ''){
                
                // 2.para que los valores ingresados sean correctos
                if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(precioCompra) > 0 && parseFloat(precioVenta) > 0) {
                    //para que el precio de compra sea menor o igual al precio de venta
                    if (parseFloat(precioVenta) >= parseFloat(precioCompra)) {
                        //calcular valores
                        subTotal[cont] = round(cantidad * precioCompra);
                        suma += subTotal[cont];
                        igv = round(suma/100 * impuesto);
                        total = round(suma + igv);

                        let fila = '<tr id="fila'+ cont + '">' +
                            '<th>'+ (cont + 1) +'</th>' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="'+ idProducto +'">'+ nameProducto +'</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="'+ cantidad +'">'+ cantidad +'</td>' +
                            '<td><input type="hidden" name="arraypreciocompra[]" value="'+ precioCompra +'">'+ precioCompra +'</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="'+ precioVenta +'">'+ precioVenta +'</td>' +
                            '<td>'+ subTotal[cont] +'</td>' +
                            '<th><button class="btn btn-danger" type="button" onClick="eliminarProducto('+ cont +')"><i class="fa-solid fa-trash"></i></button></th>' +
                            '</tr>';

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
                        showModal('Precio de venta debe ser mayor o igual que al de compra!');
                    }

                } else {
                    showModal('Valores incorrectos');
                }
                
                
            }else{
                showModal('Complete todos los campos!')
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

        function limpiarCampos(){
            let select = $('#producto_id');
            select.selectpicker();
            select.selectpicker('val', '');
            $('#cantidad').val('');
            $('#precio_compra').val('');
            $('#precio_venta').val('');

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
