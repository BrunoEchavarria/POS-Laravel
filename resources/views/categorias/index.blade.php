@extends('template')

@section('title', 'categorias')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    @if(session('success'))
    <script>
        let message = "{{ session('success') }}";
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
        icon: "success",
        title: message
        });
    </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Categorias</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>

        <div class="mb-4">
            <a href="{{ route('categorias.create') }}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button></a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Categorias
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($categorias as $categoria)
                       <tr>
                            <td>
                                {{$categoria->caracteristica->nombre}}
                            </td>
                            <td>
                                {{$categoria->caracteristica->descripcion}}
                            </td>
                            <td>
                                @if ($categoria->caracteristica->estado == 1)
                                    <span class=" d-flex justify-content-center fw-bolder rounded bg-success text-white p-2">Activo</span>
                                @else
                                    <span class="d-flex justify-content-center fw-bolder rounded bg-danger p-2 text-white">Eliminado</span>
                                @endif
                                
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="{{route('categorias.edit',['categoria'=>$categoria])}}" method="GET">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    @if ($categoria->caracteristica->estado == 1)
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}">Eliminar</button>
                                    @else
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}">Restaurar</button>
                                    @endif
                                  </div>
                            </td>
                       </tr>
                       <div class="modal fade" id="confirmModal-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                              {{$categoria->caracteristica->estado == 1 ? 'Esta seguro de eliminar esta categoria?' : 'Esta seguro que quiere restaurar esta categoria?'}}
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                              <form action="{{route('categorias.destroy',['categoria'=>$categoria->id] )}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    @if ($categoria->caracteristica->estado == 1)
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    @else
                                    <button type="submit" class="btn btn-success">Restaurar</button>
                                    @endif
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush