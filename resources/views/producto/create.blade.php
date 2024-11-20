@extends('template')

@section('title', 'Añadir producto')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Añadir productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('producto.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Añadir productos</li>
        </ol>
        <div class="container w-100 border border-3 border rounded p-4 mt3">
            <form action="{{route('producto.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    {{-- codigo --}}
                    <div class="col-md-6">
                        <label for="codigo" class="form-label">Codigo: </label>
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo')}}">
                        @error('codigo')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- nombre --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre: </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                        @error('nombre')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- descripcion --}}
                    <div class="col-md-12">
                        <label for="descripcion" class="form-label">Descripción: </label>
                        <textarea name="descripcion" id="desc" rows="5" class="form-control">{{old('descripcion')}}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- fecha de vencimiento --}}
                    <div class="col-md-6">
                        <label for="fecha_vencimiento" class="form-label">Fecha vencimiento: </label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento')}}">
                        @error('fecha_vencimiento')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- Imagen --}}
                    <div class="col-md-6">
                        <label for="img_path" class="form-label">Imagen: </label>
                        <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/">
                        @error('img_path')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- marca --}}
                    <div class="col-md-6">
                        <label for="marca_id" class="form-label">Marca: </label>
                        <select data-size="5" title="Seleccione una marca" data-live-search="true" name="marca_id" id="marca_id" class="form-control selectpicker show-tick">
                            @foreach ($marcas as $marca )
                                <option value="{{$marca->id}}" {{old('marca_id') == $marca->id ? 'selected' : ''}} >{{$marca->nombre}}</option>
                            @endforeach
                        </select>
                        @error('marca_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- precentacion --}}
                    <div class="col-md-6">
                        <label for="presentacione_id" class="form-label">Presentaciones: </label>
                        <select data-size="5" title="Seleccione una marca" data-live-search="true" name="presentacione_id" id="presentacione_id"class="form-control selectpicker show-tick">
                            @foreach ($presentaciones as $presentacione )
                                <option value="{{$presentacione->id}}"  {{old('presentacione_id') == $presentacione->id ? 'selected' : ''}}>{{$presentacione->nombre}}</option>
                            @endforeach
                        </select>
                        @error('presentacione_id')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                    {{-- categorias --}}
                    <div class="col-md-6">
                        <label for="categorias" class="form-label">Categorías: </label>
                        <select data-size="5" title="Seleccione la o las categorías" data-live-search="true" name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                            @foreach ($categorias as $categoria )
                                <option value="{{$categoria->id}}" {{ (in_array($categoria->id, old('categorias',[]))) ? 'selected' : ''}}>{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <a class="btn btn-danger" href="{{route('producto.index')}}">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush