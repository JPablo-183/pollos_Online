@extends('layouts.admin')

@section('title', 'Panel principal')

@section('content')
    <section class="dashboard">
        <header class="dashboard-heading">
            <div>
                <span class="dashboard-eyebrow">Resumen del día</span>
                <h1>Hola, {{ auth()->user()->nombre }}.</h1>
                <p>Este es el estado actual de Pollo's Ranchero.</p>
            </div>

            <div class="today-pill">
                <span aria-hidden="true">✦</span>
                {{ now()->format('d/m/Y') }}
            </div>
        </header>

        <div class="welcome-card">
            <div>
                <span class="welcome-label">Tu jornada, de un vistazo</span>
                <h2>Todo listo para atender.</h2>
                <p>Consulta los datos principales de tu restaurante desde aquí.</p>
            </div>
            <div class="welcome-shape" aria-hidden="true">P</div>
        </div>

        <div class="metrics-grid">
            <article class="metric-card">
                <div class="metric-top">
                    <span class="metric-label">Categorías activas</span>
                    <span class="metric-icon" aria-hidden="true">▦</span>
                </div>
                <strong class="metric-value">{{ number_format($categorias) }}</strong>
                <span class="metric-note">Disponibles en el sistema</span>
            </article>

            <article class="metric-card">
                <div class="metric-top">
                    <span class="metric-label">Platos del menú</span>
                    <span class="metric-icon" aria-hidden="true">◇</span>
                </div>
                <strong class="metric-value">{{ number_format($platos) }}</strong>
                <span class="metric-note">Platos activos</span>
            </article>

            <article class="metric-card">
                <div class="metric-top">
                    <span class="metric-label">Pedidos en cola</span>
                    <span class="metric-icon" aria-hidden="true">≋</span>
                </div>
                <strong class="metric-value">{{ number_format($pedidosEnCola) }}</strong>
                <span class="metric-note">Pendientes de atención</span>
            </article>

            <article class="metric-card">
                <div class="metric-top">
                    <span class="metric-label">Ventas de hoy</span>
                    <span class="metric-icon metric-icon-money" aria-hidden="true">Bs</span>
                </div>
                <strong class="metric-value">
                    Bs {{ number_format((float) $ventasHoy, 2, ',', '.') }}
                </strong>
                <span class="metric-note">Total registrado en pedidos</span>
            </article>
        </div>

        <section class="next-card">
            <div class="next-symbol" aria-hidden="true">⚙</div>
            <div>
                <h2>Panel en construcción</h2>
                <p>
                    El resumen está conectado a las tablas de categorías,
                    platos y pedidos. En los siguientes pasos conectaremos
                    el menú de navegación con cada módulo.
                </p>
            </div>
        </section>
    </section>

    <style>
        :root[data-theme="claro"] {
            --dashboard-card: #FFFFFF;
            --dashboard-secondary: #FFF8EF;
        }

        :root[data-theme="oscuro"] {
            --dashboard-card: #2E140B;
            --dashboard-secondary: #2E140B;
        }

        .dashboard-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .dashboard-eyebrow {
            color: var(--action);
            font-size: 11px;
            font-weight: 850;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .dashboard-heading h1 {
            margin: 8px 0 6px;
            color: var(--text);
            font-size: clamp(30px, 4vw, 42px);
            line-height: 1.05;
            letter-spacing: -.05em;
        }

        .dashboard-heading p {
            margin: 0;
            color: var(--muted);
        }

        .today-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--text);
            background: var(--surface);
            font-size: 13px;
            font-weight: 750;
            white-space: nowrap;
        }

        .today-pill span {
            color: var(--gold);
        }

        .welcome-card {
            position: relative;
            min-height: 190px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 22px;
            padding: clamp(24px, 4vw, 38px);
            overflow: hidden;
            border-radius: 30px 22px 34px 22px;
            color: #FFFFFF;
            background:
                radial-gradient(circle at 85% 20%, rgba(255, 199, 44, .18), transparent 28%),
                var(--banner);
            box-shadow: var(--shadow);
        }

        .welcome-card > div:first-child {
            position: relative;
            z-index: 1;
        }

        .welcome-label {
            color: rgba(255, 255, 255, .82);
            font-size: 12px;
            font-weight: 750;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .welcome-card h2 {
            margin: 12px 0 8px;
            color: #FFFFFF;
            font-size: clamp(25px, 3vw, 34px);
            letter-spacing: -.04em;
        }

        .welcome-card p {
            max-width: 500px;
            margin: 0;
            color: rgba(255, 255, 255, .88);
            line-height: 1.6;
        }

        .welcome-shape {
            position: absolute;
            top: -44px;
            right: 34px;
            width: 245px;
            height: 245px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 42% 58% 52% 48% / 48% 42% 58% 52%;
            color: var(--gold);
            font-size: 110px;
            font-weight: 900;
            opacity: .9;
            transform: rotate(12deg);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .metric-card {
            min-height: 170px;
            padding: 21px;
            border: 1px solid var(--line);
            border-radius: 24px 17px 24px 17px;
            background: var(--dashboard-card);
            box-shadow: var(--shadow);
            transition:
                transform .25s cubic-bezier(.2, .8, .2, 1),
                box-shadow .25s ease;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 34px rgba(0, 0, 0, .16);
        }

        .metric-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .metric-label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 750;
        }

        .metric-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 15px 10px 15px 10px;
            color: #FFFFFF;
            background: var(--action);
            font-size: 16px;
            font-weight: 850;
        }

        .metric-icon-money {
            color: var(--text);
            background: var(--gold);
        }

        .metric-value {
            display: block;
            margin: 18px 0 6px;
            color: var(--text);
            font-size: clamp(27px, 3vw, 36px);
            letter-spacing: -.04em;
        }

        .metric-note {
            color: var(--muted);
            font-size: 12px;
        }

        .next-card {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: 22px 16px 22px 16px;
            background: var(--dashboard-secondary);
            backdrop-filter: blur(12px);
        }

        .next-symbol {
            width: 38px;
            height: 38px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #1A0000;
            background: var(--gold);
        }

        .next-card h2 {
            margin: 2px 0 6px;
            color: var(--text);
            font-size: 16px;
        }

        .next-card p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        @media (max-width: 1050px) {
            .metrics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .dashboard-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .metrics-grid {
                grid-template-columns: 1fr;
            }

            .welcome-card {
                min-height: 180px;
            }

            .welcome-shape {
                right: -110px;
                opacity: .4;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .metric-card {
                transition: none;
            }

            .metric-card:hover {
                transform: none;
            }
        }
    </style>
@endsection