@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <!-- Título de la página -->
        <h1 class="text-center mb-3" style="font-family: 'Roboto', sans-serif; font-weight: 700; font-size: 2rem; color: #34495e; letter-spacing: 1px; text-transform: uppercase; border-bottom: 2px solid #3498db; padding-bottom: 5px;">
            Lista de Productos
        </h1>

        <!-- Barra de búsqueda -->
        <div class="row mb-3 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <form method="GET" action="{{ route('productos.index') }}" class="d-flex">
                    <input type="text" name="search" placeholder="Buscar producto..." class="form-control form-control-sm border-0 rounded-pill shadow-sm px-3" value="{{ request('search') }}" style="background-color: #ecf0f1; font-size: 1rem;">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill ms-2 px-3 py-1 shadow-sm" style="font-size: 1rem;"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!-- Botón Nuevo Producto -->
        <div class="text-end mb-3">
            <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm rounded-pill px-4 py-2 shadow-sm" style="font-size: 1rem;"><i class="fas fa-plus-circle"></i> Nuevo Producto</a>
        </div>

        <!-- Tabla de productos más compacta -->
        <div class="table-responsive shadow-sm rounded-3">
            <table class="table table-striped table-hover table-borderless">
                <thead class="table-light" style="font-size: 1rem;">
                    <tr>
                        <th class="text-center" style="padding: 10px; font-weight: 600;">Nombre</th>
                        <th class="text-center" style="padding: 10px; font-weight: 600;">Descripción</th>
                        <th class="text-center" style="padding: 10px; font-weight: 600;">Precio</th>
                        <th class="text-center" style="padding: 10px; font-weight: 600;">Cantidad</th>
                        <th class="text-center" style="padding: 10px; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.95rem;">
                    @foreach($productos as $producto)
                        <tr class="hover-shadow" style="background-color: #fff; transition: background-color 0.3s ease;">
                            <td class="text-center" style="padding: 15px; border-bottom: 1px solid #ddd;">{{ $producto->nombre }}</td>
                            <td class="text-center" style="padding: 15px; border-bottom: 1px solid #ddd;">{{ $producto->descripcion }}</td>
                            <td class="text-center" style="padding: 15px; border-bottom: 1px solid #ddd;">S/ {{ number_format($producto->precio, 2) }}</td>
                            <td class="text-center" style="padding: 15px; border-bottom: 1px solid #ddd;">{{ $producto->cantidad }}</td>
                            <td class="text-center" style="padding: 15px; border-bottom: 1px solid #ddd;">
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm rounded-pill" style="font-size: 0.9rem; padding: 5px 10px;"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill" style="font-size: 0.9rem; padding: 5px 10px;"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $productos->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
