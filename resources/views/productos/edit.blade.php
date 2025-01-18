@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Editar Producto</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label text-muted">Nombre</label>
                                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="form-control form-control-sm" placeholder="Nombre del producto" required>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label text-muted">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control form-control-sm" rows="3" placeholder="Descripción breve" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                            </div>

                            <!-- Precio -->
                            <div class="mb-3">
                                <label for="precio" class="form-label text-muted">Precio (S/)</label>
                                <input type="number" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" class="form-control form-control-sm" step="0.01" placeholder="Precio del producto" required>
                            </div>

                            <!-- Cantidad -->
                            <div class="mb-3">
                                <label for="cantidad" class="form-label text-muted">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad', $producto->cantidad) }}" class="form-control form-control-sm" placeholder="Cantidad disponible" required>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">Cancelar</a>
                                <button type="submit" class="btn btn-primary btn-sm">Actualizar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Estilos generales */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #2c3e50;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control-sm {
            padding: 0.75rem;
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-outline-secondary {
            border-color: #3498db;
            color: #3498db;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
            border-color: #2980b9;
            color: #2980b9;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #2c3e50;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .card-header h4 {
                font-size: 1.25rem;
            }

            .btn {
                padding: 0.5rem 1rem;
            }

            .form-control-sm {
                font-size: 0.875rem;
            }
        }
    </style>
@endsection
