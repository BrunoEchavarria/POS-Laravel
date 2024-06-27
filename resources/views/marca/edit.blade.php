@extends('template')

@section('title', 'Editar marca')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{ route('marca.index') }}">Marcas</a></li>
        <li class="breadcrumb-item active">Editar marcas</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt3">
        <form action="{{route('marca.update', ['marca'=>$marcas])}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="row g3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $marcas->caracteristica->nombre)}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="5" class="form-control">{{ old('descripcion', $marcas->caracteristica->descripcion) }}</textarea>
                    @error('descripcion')
                        <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
                    <button type="reset" class="btn btn-secondary mt-2" >Reiniciar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection