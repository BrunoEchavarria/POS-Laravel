@extends('template')

@section('title', 'Agregar marca')

@push('css')
    
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Agregar marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{ route('marca.index') }}">Marca</a></li>
        <li class="breadcrumb-item active">Agregar marca</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt3">
        <form action="{{route('marca.store')}}" method="POST">
            @csrf
            <div class="row g3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="5" class="form-control">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <small class="text-danger">{{'*'. $message}}</small>
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

@endpush
