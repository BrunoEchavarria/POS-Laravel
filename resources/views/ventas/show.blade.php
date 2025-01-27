@extends('template')

@section('title', 'Ver venta')

@push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Ver venta</li>
        </ol>
    </div>

    <div class="container w-100">

        <div class="card p-2 mb-4">

            {{-- tipo de comprobante --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de comprobante: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->comprobante->tipo_comprobante}}">
                </div>
            </div>

            {{-- numero de comprobante --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input disabled type="text" class="form-control" value="Numero de comprobante: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->numero_comprobante}}">
                </div>
            </div>

            {{-- cliente --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                        <input disabled type="text" class="form-control" value="Cliente: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->cliente->persona->razon_social}}">
                </div>
            </div>

            {{-- usuario --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input disabled type="text" class="form-control" value="Vendedor: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->user->name}}">
                </div>
            </div>
            

            {{-- fecha --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input disabled type="text" class="form-control" value="Fecha: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('d-m-Y')}}">
                </div>
            </div>

            {{-- hora --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                        <input disabled type="text" class="form-control" value="Hora: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('H:i')}}">
                </div>
            </div>

            {{-- impuesto --}}
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                        <input disabled type="text" class="form-control" value="Impuesto: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled id="input-impuesto" type="text" class="form-control" value="{{$venta->impuesto}}">
                </div>
            </div>
        </div>

        {{-- tabla --}}

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla detalle de venta
            </div>
            <div class="card-body table-resposive">
                <table class="table table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio venta</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venta->productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>{{ $producto->pivot->precio_venta}}</td>
                                <td>{{ $producto->pivot->descuento }}</td>
                                <td class="td-subtotal">{{ ($producto->pivot->cantidad) * ($producto->pivot->precio_venta) - ($producto->pivot->descuento)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th colspan="3">Sumas:</th>
                            <th id="th-suma"></th>
                        </tr>
                        <tr>
                            <th colspan="3">IGV:</th>
                            <th id="th-igv"></th>
                        </tr>
                        <tr>
                            <th colspan="3">Total:</th>
                            <th id="th-total"></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
        
    </div>


@endsection

@push('js')
    <script>

        // variables
        let filaSubtotal = document.getElementsByClassName('td-subtotal');
        let cont = 0;
        let impuesto = $('#input-impuesto').val();

        $(document).ready(function() {
            calcularValores();
        });

        function calcularValores(){

            for (let i = 0; i < filaSubtotal.length; i++) {
                cont += parseFloat(filaSubtotal[i].innerHTML);
            }

            $('#th-suma').html(cont);
            $('#th-igv').html(impuesto);
            $('#th-total').html(cont+parseFloat(impuesto));
        }
    </script>
@endpush
