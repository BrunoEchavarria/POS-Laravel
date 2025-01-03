<div>
    <div>
        @extends('template')
    
    @section('title', 'Editar proveedor')
    
    @push('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @endpush
    
    @section('content')
    
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center">Editar proveedor</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                <li class="breadcrumb-item "><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
                <li class="breadcrumb-item active">Editar proveedor</li>
            </ol>
            <div class="container w-100 border border-3 border-primary rounded p-4 mt3">
                <form action="{{route('proveedores.update',['proveedore'=>$proveedore])}}" method="POST">
                    @method('PATCH')
                    @csrf
    
                    {{-- tipo de cliente --}}
    
                    <div class="row g3">
    
                        <div class="col-md-6">
                            <label for="tipo_persona" class="form-label">Tipo de Proveedor/es: <span class="fw-bold">{{strtoupper($proveedore->persona->tipo_persona)}}</span></label>
                        </div>
    
                        {{-- razon social --}}
    
                        <div class="col-md-12 mb-2" id="box-razon-social">
                            @if ($proveedore->persona->tipo_persona == 'locales')
                                <label id="label-local" for="razon_social" class="form-label mt-2">Nombre y apellido:</label>
                            @else
                                <label id="label-otroTipo" for="razon_social" class="form-label mt-2">Nombre de la empresa:</label>
                            @endif
    
                            <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social',$proveedore->persona->razon_social)}}">
                        
                            @error('razon_social')
                                <small class="text-damger">{{ '*'.$message }}</small>
    
                            @enderror
                        </div>
    
                        {{-- direccion --}}
    
                        <div class="col-md-12 mb-2">
                            <label for="direccion" class="form-label">Direccion:</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion',$proveedore->persona->direccion) }}">
                            @error('direccion')
                                <smal class="text-danger">{{ '*'.$message }}</smal>
                            @enderror
    
                        </div>
    
                        {{-- documento --}}
    
                        <div class="col-md-6">
                            <label for="documento_id" class="form-label">Tipo de documento: </label>
                            <select class="form-select" name="documento_id" id="documento_id">
                                @foreach ($documentos as $documento )
                                    @if ($proveedore->persona->documento_id == $documento->id)
                                        <option selected value="{{$documento->id}}" {{old('documento_id')== $documento->id ? 'selected' : ''  }} >{{ $documento->tipo_documento }}</option>
                                    @else    
                                        <option value="{{$documento->id}}" {{ old('documento_id') == $documento->id ? 'selected' : ''  }} >{{ $documento->tipo_documento }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('documento_id')
                                <small class="text-danger">{{'*'. $message}}</small>
                            @enderror
                        </div>
    
                        {{-- nro documento --}}
    
                        <div class="col-md-6 mb-2">
                            <label for="numero_documento" class="form-label">Número documento:</label>
                            <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento',$proveedore->persona->numero_documento) }}">
                            @error('numero_documento')
                                <smal class="text-danger">{{ '*'.$message }}</smal>
                            @enderror
    
                        </div>
    
                        
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        
        </div>
    @endsection
    
    @push('js')
        <script>
            $(document).ready(function(){
                $('#tipo_persona').on('change', function(){
                    let selectValor = $(this).val();
                    //Si es depende de que tipo sea, ocultar las demás
    
                    if(selectValor == 'locales'){
                        $('#label-otroTipo').hide();
                        $('#label-local').show();
                    }else{
                        $('#label-otroTipo').show();
                        $('#label-local').hide();
                    }
    
                    $('#box-razon-social').show();
                });
            });
        </script>
    @endpush
    </div>
    
</div>
