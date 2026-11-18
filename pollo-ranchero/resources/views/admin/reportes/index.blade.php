@extends('layouts.admin')

@section('title', 'Reportes')

@section('content')
    <header class="report-heading">
        <span class="eyebrow">Administración</span>
        <h1>Reporte de ventas</h1>
        <p>Consulta las ventas de un día, periodo o rango de fechas.</p>
    </header>

    <form class="filter-card no-print" method="GET" action="{{ route('admin.reportes.index') }}">
        <label for="periodo">Periodo</label>
        <select id="periodo" name="periodo">
            <option value="diario" @selected($periodo === 'diario')>Diario</option>
            <option value="semanal" @selected($periodo === 'semanal')>Semanal</option>
            <option value="semestral" @selected($periodo === 'semestral')>Semestral</option>
            <option value="anual" @selected($periodo === 'anual')>Anual</option>
            <option value="personalizado" @selected($periodo === 'personalizado')>Rango personalizado</option>
        </select>

        <div id="fecha-field">
            <label for="fecha">Fecha de referencia</label>
            <input id="fecha" name="fecha" type="date" value="{{ $fecha }}">
        </div>

        <div id="rango-fields">
            <label for="desde">Desde</label>
            <input id="desde" name="desde" type="date" value="{{ $desde }}">

            <label for="hasta">Hasta</label>
            <input id="hasta" name="hasta" type="date" value="{{ $hasta }}">
        </div>

        <button class="report-button" type="submit">Filtrar</button>
        <button class="report-button button-soft" type="button" onclick="window.print()">
            Imprimir
        </button>
    </form>

    @if ($errors->any())
        <div class="report-error no-print">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="report-card">
        <div class="report-period">
            <div>
                <h2>Pollo's Ranchero</h2>
                <p>Ventas del {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}</p>
            </div>

            <strong class="report-total">
                Total: Bs {{ number_format((float) $totalVentas, 2) }}
            </strong>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>Número de transacción</th>
                        <th>Cola</th>
                        <th>Generado por</th>
                        <th>Total (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pedido->fecha_creacion?->format('h:i A') ?? '—' }}</td>
                            <td>{{ $pedido->codigo }}</td>
                            <td>{{ $pedido->numero_cola }}</td>
                            <td>{{ $pedido->usuario?->nombre_usuario ?? 'N/A' }}</td>
                            <td class="amount">{{ number_format((float) $pedido->monto_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                No se encontraron pedidos en este periodo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Total de ventas</th>
                        <th class="amount">{{ number_format((float) $totalVentas, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <style>
        .report-heading { margin-bottom:22px; }
        .report-heading h1 { margin:7px 0; font-size:clamp(30px,4vw,40px); }
        .report-heading p,.report-period p { margin:0; color:var(--muted); }
        .eyebrow { color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .filter-card { display:flex; align-items:end; flex-wrap:wrap; gap:12px; margin-bottom:20px; padding:18px; border:1px solid var(--line); border-radius:18px; background:var(--surface); }
        .filter-card label { display:block; margin-bottom:6px; color:var(--muted); font-size:12px; }
        .filter-card select,.filter-card input { min-height:38px; padding:8px 10px; border:1px solid var(--line); border-radius:10px; color:var(--text); background:var(--surface-soft); }
        #rango-fields { display:none; }
        #rango-fields label { display:inline-block; margin-left:8px; }
        .report-button { min-height:38px; padding:0 14px; border:1px solid var(--action); border-radius:10px; color:#fff; background:var(--action); cursor:pointer; font-weight:700; }
        .button-soft { border-color:var(--line); color:var(--text); background:var(--surface-soft); }
        .report-card { overflow:hidden; border:1px solid var(--line); border-radius:20px; color:var(--text); background:var(--surface); box-shadow:var(--shadow); }
        .report-period { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:20px; }
        .report-period h2 { margin:0 0 5px; }
        .report-total { font-size:18px; }
        .table-scroll { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; text-align:left; }
        th,td { padding:12px 14px; border-top:1px solid var(--line); }
        thead { color:var(--muted); background:var(--surface-soft); }
        .amount { text-align:right; }
        tfoot { background:var(--surface-soft); }
        .empty { padding:24px; color:var(--muted); text-align:center; }
        .report-error { margin-bottom:16px; padding:12px; border:1px solid #B42318; border-radius:12px; color:var(--text); }
        @media(max-width:700px) { .report-period { align-items:flex-start; flex-direction:column; } }

        @media print {
            .no-print, .sidebar, .topbar, .page-footer { display:none !important; }
            .app-shell { display:block; }
            .page-content { width:100%; padding:0; }
            .report-card { border:0; box-shadow:none; }
        }
    </style>

    <script>
        const periodo = document.getElementById('periodo');
        const fechaField = document.getElementById('fecha-field');
        const rangoFields = document.getElementById('rango-fields');

        function actualizarCampos() {
            const personalizado = periodo.value === 'personalizado';
            fechaField.style.display = personalizado ? 'none' : 'block';
            rangoFields.style.display = personalizado ? 'block' : 'none';
        }

        periodo.addEventListener('change', actualizarCampos);
        actualizarCampos();
    </script>
@endsection