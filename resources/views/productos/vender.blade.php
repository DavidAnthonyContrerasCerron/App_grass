@extends('layouts.app')

@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card p-4 shadow-lg border-0" style="max-width: 450px; border-radius: 15px; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
            <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-size: 1.8rem; color: #34495e; font-weight: 700; text-transform: uppercase;">
                Venta de Productos
            </h2>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 0.9rem;">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('ventas.store') }}" method="POST" class="row g-4">
                @csrf

                <!-- Selección de Producto -->
                <div class="col-12">
                    <label for="producto" class="form-label text-secondary fw-semibold">Producto</label>
                    <select name="producto_id" id="producto" class="form-select form-select-sm shadow-sm" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">
                                {{ $producto->nombre }} (Disponible: {{ $producto->cantidad }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cantidad -->
                <div class="col-12">
                    <label for="cantidad_vendida" class="form-label text-secondary fw-semibold">Cantidad</label>
                    <input type="number" name="cantidad_vendida" id="cantidad_vendida" class="form-control form-control-sm shadow-sm" required min="1">
                </div>

                <!-- Total -->
                <div class="col-12">
                    <label for="total" class="form-label text-secondary fw-semibold">Total (S/)</label>
                    <input type="text" name="total" id="total" class="form-control form-control-sm shadow-sm bg-light" readonly>
                </div>

                <!-- Botones -->
                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm">Realizar Venta</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm px-4 shadow-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Configurar hora en Perú (UTC-5)
        function getPeruTime() {
            const offset = -5; // UTC-5
            const localDate = new Date();
            return new Date(localDate.getTime() + (offset - localDate.getTimezoneOffset() / 60) * 3600 * 1000);
        }

        // Actualizar el valor total automáticamente
        function updateTotal() {
            const productoId = document.getElementById('producto').value;
            const cantidad = document.getElementById('cantidad_vendida').value;

            fetch(`/productos/${productoId}`)
                .then(response => response.json())
                .then(data => {
                    const precio = data.precio;
                    document.getElementById('total').value = cantidad ? (precio * cantidad).toFixed(2) : '';
                });
        }

        document.getElementById('producto').addEventListener('change', updateTotal);
        document.getElementById('cantidad_vendida').addEventListener('input', updateTotal);
    </script>
@endsection

@section('styles')
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #7f8c8d;
            --background-color: #fdfbfb;
            --font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e8e8e8 0%, #f5f5f5 100%);
            font-family: var(--font-family);
            color: #2c3e50;
        }

        .form-control-sm, .form-select-sm {
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
        }

        .btn-sm {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-success {
            background-color: var(--primary-color);
            border: none;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-outline-secondary {
            border-color: var(--secondary-color);
            color: var(--secondary-color);
        }

        .btn-outline-secondary:hover {
            background-color: var(--secondary-color);
            color: #fff;
        }

        h2 {
            font-size: 1.8rem;
            text-transform: uppercase;
        }

        @media (max-width: 576px) {
            .card {
                padding: 2rem 1rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
@endsection
