@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <!-- Título con Raya Separadora -->
        <div class="text-center mb-4">
            <h1 class="text-black font-weight-bold" style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; text-transform: capitalize; letter-spacing: 1px;">Listado de Reservas</h1>
            <hr class="my-4" style="border: 3px solid #007bff; width: 70%; margin: auto;"/>
        </div>

        <!-- Calendario con mes de Enero 2025 -->
        <div id="calendar" class="mb-5"></div>

        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet" />

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    timeZone: 'America/Lima',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    buttonText: {
                        prev: '◁',
                        next: '▷',
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día'
                    },
                    initialDate: '2025-01-01',
                    events: {!! json_encode($reservas->map(function ($reserva) {
                        return [
                            'title' => 'Reserva',
                            'start' => $reserva->fecha . 'T' . $reserva->hora_inicio,
                            'end' => $reserva->fecha . 'T' . \Carbon\Carbon::parse($reserva->hora_inicio)->addMinutes($reserva->duracion * 60)->format('H:i'),
                        ];
                    })) !!},
                    dateClick: function(info) {
                        window.location.href = '/reservas?fecha=' + info.dateStr;
                    }
                });
                calendar.render();
            });
        </script>

        <!-- Botón de Programar Nueva Reserva (Sin ícono y con texto más grande) -->
        <div class="text-center mb-4">
            <a href="{{ route('reservas.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4 py-2 d-flex align-items-center justify-content-center">
                <span style="font-size: 1.25rem;">Programar Nueva Reserva</span>
            </a>
        </div>

        <!-- Línea separadora debajo del botón -->
        <hr class="my-5" style="border: 2px solid #007bff; width: 70%; margin: auto;"/>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success shadow-lg rounded-lg mb-4 p-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger shadow-lg rounded-lg mb-4 p-3">
                {{ session('error') }}
            </div>
        @endif

        <!-- Reservas Pendientes -->
        <div class="my-5">
            <h2 class="text-center text-muted mb-4" style="font-size: 2.25rem; font-weight: 600;">Reservas Pendientes</h2>
            <div class="table-responsive">
                <table class="table table-modern table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora de Inicio</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            @if ($reserva->estado == 'pendiente')
                                <tr class="hover-shadow">
                                    <td>{{ $reserva->fecha }}</td>
                                    <td>{{ $reserva->hora_inicio }}</td>
                                    <td>{{ $reserva->duracion == 0.5 ? 'Media Hora' : ($reserva->duracion == 1 ? '1 Hora' : $reserva->duracion . ' Horas') }}</td>
                                    <td>S/. {{ number_format($reserva->precio, 2) }}</td>
                                    <td>S/. {{ number_format($reserva->total, 2) }}</td>
                                    <td class="text-center text-white bg-warning font-weight-bold rounded">
                                        Pendiente
                                    </td>
                                    <td>
                                        <form action="{{ route('reservas.pagar', $reserva->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-2">Pagar</button>
                                        </form>
                                        <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 py-2">Editar</a>
                                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 py-2">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Línea separadora entre las tablas -->
        <hr class="my-5" style="border: 2px solid #007bff; width: 70%; margin: auto;"/>

        <!-- Reservas Pagadas -->
        <div class="my-5">
            <h2 class="text-center text-success mb-4" style="font-size: 2.25rem; font-weight: 600;">Reservas Pagadas</h2>
            <div class="table-responsive">
                <table class="table table-modern table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora de Inicio</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            @if ($reserva->estado == 'pagada')
                                <tr class="hover-shadow">
                                    <td>{{ $reserva->fecha }}</td>
                                    <td>{{ $reserva->hora_inicio }}</td>
                                    <td>{{ $reserva->duracion == 0.5 ? 'Media Hora' : ($reserva->duracion == 1 ? '1 Hora' : $reserva->duracion . ' Horas') }}</td>
                                    <td>S/. {{ number_format($reserva->precio, 2) }}</td>
                                    <td>S/. {{ number_format($reserva->total, 2) }}</td>
                                    <td class="text-center text-white bg-success font-weight-bold rounded">
                                        Pagado
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total de Ingresos -->
        <div class="card shadow-lg rounded-lg">
            <div class="card-body">
                <h3 class="text-center text-primary mb-3" style="font-size: 1.75rem; font-weight: 600;">Total de Ingresos</h3>
                <div class="text-center">
                    <strong class="h4 text-primary">S/. {{ number_format($totalIngresos, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Fuentes personalizadas y colores modernos */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fb;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .table-modern {
            font-size: 1.1rem;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 2rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-modern th, .table-modern td {
            padding: 14px;
            text-align: center;
        }

        .table-modern th {
            background-color: #343a40;
            color: white;
            font-weight: 700;
        }

        .table-modern td {
            background-color: #ffffff;
            color: #333;
        }

        .table-modern tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-modern tr:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .alert {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            font-size: 1.1rem;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .hover-shadow:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .btn-primary {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
            }

            .table-modern {
                font-size: 1rem;
            }

            h1 {
                font-size: 2.25rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            .text-center {
                padding-right: 10px;
                padding-left: 10px;
            }
        }
    </style>
@endsection
