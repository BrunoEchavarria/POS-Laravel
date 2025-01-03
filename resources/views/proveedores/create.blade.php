<div>
    <div>
        @extends('template')
    
    @section('title', 'Crear proveedor')
    
    @push('css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
        <style>
            #box-razon-social{
                display: none;
            }
        </style>
    @endpush
    
    @section('content')
    
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center">Crear proveedor</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                <li class="breadcrumb-item "><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
                <li class="breadcrumb-item active">Crear proveedor</li>
            </ol>
            <div class="container w-100 border border-3 border-primary rounded p-4 mt3">
                <form action="{{route('proveedores.store')}}" method="POST">
                    @csrf
    
                    {{-- tipo de cliente --}}
    
                    <div class="row g3">
    
                        <div class="col-md-6">
                            <label for="tipo_persona" class="form-label">Tipo de proveedor: </label>
                            <select class="form-select" name="tipo_persona" id="tipo_persona">
                                <option value="" selected disabled>Seleccione un opción:</option>
                                <option value="locales"  {{ old('tipo_persona')  ==  'locales' ? 'selected' : '' }} >Empresas locales / Emprendimientos</option>
                                <option value="nacionales" {{ old('tipo_persona')  ==  'nacionales' ? 'selected' : '' }} >Productos comercializados nacionalmente</option>
                                <option value="internacionales" {{ old('tipo_persona')  ==  'internacionales' ? 'selected' : '' }} >Productos comercializados internacionalmente</option>
                                <option value="remoto" {{ old('tipo_persona')  ==  'remoto' ? 'selected' : '' }} >Proveedor de servicio remoto</option>
                            </select>
                            @error('tipo_persona')
                                <small class="text-danger">{{'*'. $message}}</small>
                            @enderror
                        </div>
    
                        {{-- razon social --}}
    
                        <div class="col-md-12 mb-2" id="box-razon-social">
                            <label id="label-local" for="razon_social" class="form-label mt-2">Nombre y apellido:</label>
                            <label id="label-otroTipo" for="razon_social" class="form-label mt-2">Nombre de la empresa:</label>
    
                            <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}">
                        
                            @error('razon_social')
                                <small class="text-damger">{{ '*'.$message }}</small>
    
                            @enderror
                        </div>
    
                        {{-- direccion --}}
    
                        <div class="col-md-12 mb-2">
                            <label for="direccion" class="form-label">Direccion:</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                            @error('direccion')
                                <smal class="text-danger">{{ '*'.$message }}</smal>
                            @enderror
    
                        </div>
    
                        {{-- documento --}}
    
                        <div class="col-md-6">
                            <label for="documento_id" class="form-label">Tipo de documento: </label>
                            <select class="form-select" name="documento_id" id="documento_id">
                                <option value="" selected disabled>Seleccione un opción:</option>
                                @foreach ($documentos as $documento )
                                    <option  value="{{$documento->id}}" {{ old('documento_id') == $documento->id ? 'selected' : ''  }} >{{ $documento->tipo_documento }}</option>
                                @endforeach
                            </select>
                            @error('documento?id')
                                <small class="text-danger">{{'*'. $message}}</small>
                            @enderror
                        </div>
    
                        {{-- nro documento --}}
    
                        <div class="col-md-6 mb-2">
                            <label for="numero_documento" class="form-label">Número documento:</label>
                            <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento') }}">
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
