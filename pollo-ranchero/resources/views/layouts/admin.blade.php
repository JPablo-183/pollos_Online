<!DOCTYPE html>
<html lang="es" data-theme="claro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') | Pollo's Ranchero</title>

    <script>
        try {
            const temaGuardado = localStorage.getItem('pollo-tema');
            if (temaGuardado === 'claro' || temaGuardado === 'oscuro') {
                document.documentElement.dataset.theme = temaGuardado;
            }
        } catch (error) {
            // Se conserva el modo claro si el navegador bloquea localStorage.
        }
    </script>

    <style>
        :root,
        :root[data-theme="claro"] {
            color-scheme: light;
            --app-bg: #FDFBF7;
            --surface: #FFFFFF;
            --surface-soft: #FFF8EF;
            --text: #1A0000;
            --muted: #6E5A5A;
            --line: #EFE9E2;
            --sidebar: #800C0C;
            --sidebar-deep: #1F0B05;
            --sidebar-muted: #F4DCDC;
            --active-bg: #FFC72C;
            --active-text: #1A0000;
            --gold: #F5B300;
            --action: #800C0C;
            --topbar: rgba(255, 255, 255, .90);
            --shadow: 0 18px 48px rgba(43, 20, 20, .10);

            /* Variables heredadas de los estilos de la plantilla. */
            --forest: var(--sidebar);
            --forest-dark: #1A0000;
            --pistachio: var(--active-bg);
            --citrus: var(--gold);
            --cream: var(--app-bg);
            --ink: var(--text);
        }

        :root[data-theme="oscuro"] {
            color-scheme: dark;
            --app-bg: #160803;
            --surface: #1F0B05;
            --surface-soft: #2E140B;
            --text: #FFD26A;
            --muted: #E2C7B2;
            --line: #49291E;
            --sidebar: #1F0B05;
            --sidebar-deep: #160803;
            --sidebar-muted: #E2C7B2;
            --active-bg: #D90416;
            --active-text: #FFFFFF;
            --gold: #FDB813;
            --action: #D90416;
            --topbar: rgba(31, 11, 5, .92);
            --shadow: 0 18px 48px rgba(0, 0, 0, .28);

            --forest: var(--sidebar);
            --forest-dark: #1A0000;
            --pistachio: var(--active-bg);
            --citrus: var(--gold);
            --cream: var(--app-bg);
            --ink: var(--text);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            background:
                radial-gradient(ellipse at 90% 5%, rgba(245, 179, 0, .10), transparent 30%),
                var(--app-bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        button,
        a {
            font: inherit;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 264px minmax(0, 1fr);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            color: #FFFFFF;
            background:
                radial-gradient(circle at 100% 0, rgba(255, 199, 44, .12), transparent 28%),
                linear-gradient(155deg, var(--forest), var(--forest-dark));
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 8px 32px;
            color: inherit;
            text-decoration: none;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 17px 12px 17px 12px;
            color: var(--forest-dark);
            background: var(--citrus);
            font-size: 22px;
            font-weight: 900;
            transform: rotate(-4deg);
        }

        .brand-name {
            font-size: 15px;
            font-weight: 800;
        }

        .brand-caption {
            margin-top: 3px;
            color: var(--sidebar-muted);
            font-size: 11px;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .nav-heading {
            margin: 0 12px 10px;
            color: var(--sidebar-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .nav-list {
            display: grid;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-link {
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 13px;
            border-radius: 17px 12px 17px 12px;
            color: var(--sidebar-muted);
            text-decoration: none;
            transition:
                background .2s ease,
                color .2s ease,
                transform .25s cubic-bezier(.2, .8, .2, 1);
        }

        .nav-link:hover {
            color: white;
            background: #ffffff16;
            transform: translateX(3px);
        }

        .nav-link.is-active {
            color: var(--forest-dark);
            background: var(--pistachio);
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .18);
        }

        .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 18px;
        }

        .nav-pending {
            margin-left: auto;
            padding: 4px 7px;
            border-radius: 999px;
            color: var(--sidebar-muted);
            background: #ffffff16;
            font-size: 9px;
            text-transform: uppercase;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 16px 12px 4px;
            color: var(--sidebar-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .main-area {
            min-width: 0;
        }

        .topbar {
            min-height: 78px;
            position: sticky;
            top: 0;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px clamp(18px, 4vw, 48px);
            border-bottom: 1px solid var(--line);
            background: var(--topbar);
            backdrop-filter: blur(18px);
        }

        .menu-toggle {
            width: 42px;
            height: 42px;
            display: none;
            place-items: center;
            border: 0;
            border-radius: 15px;
            color: var(--forest);
            background: var(--surface-soft);
            font-size: 20px;
            cursor: pointer;
        }

        .topbar-title {
            font-weight: 750;
        }

        .topbar-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .user-initial {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 15px 11px 15px 11px;
            color: var(--forest-dark);
            background: var(--citrus);
            font-weight: 850;
        }

        .user-name {
            font-size: 13px;
            font-weight: 750;
        }

        .logout-form {
            margin-left: 8px;
        }

        .logout-button {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--forest);
            background: var(--surface);
            font-size: 12px;
            font-weight: 750;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .profile-link {
            padding: 10px 14px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--action);
            background: var(--surface);
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
        }

        .profile-link:hover {
            background: var(--surface-soft);
        }

        .logout-button:hover {
            background: var(--surface-soft);
            transform: translateY(-1px);
        }

        .page-content {
            width: min(100%, 1440px);
            margin: 0 auto;
            padding: 34px clamp(18px, 4vw, 48px) 48px;
        }

        .page-footer {
            padding: 0 clamp(18px, 4vw, 48px) 24px;
            color: var(--muted);
            font-size: 12px;
        }

        .mobile-backdrop {
            display: none;
        }

        @media (max-width: 820px) {
            .app-shell {
                display: block;
            }

            .sidebar {
                position: fixed;
                z-index: 20;
                top: 12px;
                bottom: 12px;
                left: 12px;
                width: min(280px, calc(100vw - 24px));
                height: auto;
                border-radius: 28px;
                box-shadow: 0 24px 70px rgba(0, 0, 0, .34);
                transform: translateX(calc(-100% - 20px));
                transition: transform .3s cubic-bezier(.2, .8, .2, 1);
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .mobile-backdrop {
                position: fixed;
                z-index: 19;
                inset: 0;
                display: block;
                border: 0;
                background: rgba(22, 8, 3, .60);
                opacity: 0;
                pointer-events: none;
                transition: opacity .25s ease;
            }

            body.sidebar-open .mobile-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .menu-toggle {
                display: grid;
            }

            .topbar {
                min-height: 68px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                gap: 10px;
                padding: 12px 16px;
            }

            .topbar-subtitle,
            .user-name {
                display: none;
            }

            .logout-button {
                padding: 9px 11px;
            }

            .page-content {
                padding-top: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }


        /* Colores de marca y soporte para los modos claro y oscuro. */
        body {
            color: var(--text);
            background:
                radial-gradient(ellipse at 90% 5%, rgba(245, 179, 0, .10), transparent 30%),
                var(--app-bg);
            transition: color .25s ease, background-color .25s ease;
        }

        .sidebar {
            color: var(--sidebar-muted);
            background:
                radial-gradient(circle at 100% 0, rgba(255, 199, 44, .12), transparent 28%),
                linear-gradient(155deg, var(--sidebar), var(--sidebar-deep));
        }

        .brand-caption,
        .nav-heading,
        .nav-link,
        .nav-pending,
        .sidebar-bottom {
            color: var(--sidebar-muted);
        }

        .nav-link:hover {
            color: #FFFFFF;
        }

        .nav-link.is-active {
            color: var(--active-text);
            background: var(--active-bg);
        }

        .topbar {
            border-bottom-color: var(--line);
            background: var(--topbar);
        }

        .menu-toggle,
        .logout-button:hover {
            color: var(--text);
            background: var(--surface-soft);
        }

        .brand-mark,
        .user-initial {
            color: #1A0000;
            background: var(--gold);
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--text);
            background: var(--surface-soft);
            cursor: pointer;
        }

        .logout-button {
            color: var(--action);
            background: var(--surface);
        }

        .mobile-backdrop {
            background: rgba(22, 8, 3, .60);
        }

        @media (max-width: 820px) {
            .sidebar {
                box-shadow: 0 24px 70px rgba(0, 0, 0, .34);
            }
        }

        @media (max-width: 600px) {
            .theme-toggle span:last-child {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button class="mobile-backdrop" id="mobileBackdrop" type="button" aria-label="Cerrar menú"></button>

    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark" aria-hidden="true">P</span>
                <span>
                    <span class="brand-name">Pollo's Ranchero</span>
                    <span class="brand-caption">Panel administrativo</span>
                </span>
            </a>

            @php($tipoUsuario = (int) auth()->user()->tipo)

            <p class="nav-heading">Principal</p>

            <nav aria-label="Navegación principal">
                <ul class="nav-list">
                    <li>
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <span class="nav-icon" aria-hidden="true">⌂</span>
                            <span>Panel</span>
                        </a>
                    </li>

                    @if (in_array($tipoUsuario, [1, 2], true))
                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.punto_venta.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.punto_venta.index') }}">
                                <span class="nav-icon" aria-hidden="true">＋</span>
                                <span>Punto de venta</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.pedidos.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.pedidos.index') }}">
                                <span class="nav-icon" aria-hidden="true">≋</span>
                                <span>Pedidos</span>
                            </a>
                        </li>
                    @endif

                    @if (in_array($tipoUsuario, [1, 3], true))
                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.cocina.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.cocina.index') }}">
                                <span class="nav-icon" aria-hidden="true">◉</span>
                                <span>Cocina</span>
                            </a>
                        </li>
                    @endif
                </ul>

                @if ($tipoUsuario === 1)
                    <p class="nav-heading" style="margin-top: 26px">Administración</p>

                    <ul class="nav-list">
                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.categorias.index') }}">
                                <span class="nav-icon" aria-hidden="true">▦</span>
                                <span>Categorías</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.menu.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.menu.index') }}">
                                <span class="nav-icon" aria-hidden="true">◇</span>
                                <span>Menú</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.reportes.index') }}">
                                <span class="nav-icon" aria-hidden="true">▤</span>
                                <span>Reportes</span>
                            </a>
                        </li>

                        <li>
                            <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'is-active' : '' }}"
                                href="{{ route('admin.usuarios.index') }}">
                                <span class="nav-icon" aria-hidden="true">⚙</span>
                                <span>Usuarios</span>
                            </a>
                        </li>
                    </ul>
                @endif
            </nav>

            <div class="sidebar-bottom">
                Gestión diaria<br>
                <strong>Pollo's Ranchero</strong>
            </div>
        </aside>

        <div class="main-area">
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menú"
                    aria-expanded="false">☰</button>

                <div>
                    <div class="topbar-title">Panel administrativo</div>
                    <div class="topbar-subtitle">Resumen de tu restaurante</div>
                </div>

                <button class="theme-toggle" id="themeToggle" type="button" aria-label="Cambiar al modo oscuro"
                    aria-pressed="false">
                    <span id="themeIcon" aria-hidden="true">☾</span>
                    <span id="themeLabel">Modo oscuro</span>
                </button>

                @php($usuario = auth()->user())

                <div class="topbar-user">
                    <span class="user-initial" aria-hidden="true">
                        {{ strtoupper(substr($usuario->nombre ?? 'A', 0, 1)) }}
                    </span>
                    <span class="user-name">
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </span>
                </div>

                <a class="profile-link" href="{{ route('admin.usuarios.perfil') }}">
                    Mi perfil
                </a>

                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Cerrar sesión</button>
                </form>

            </header>

            <main class="page-content">
                @yield('content')
            </main>

            <footer class="page-footer">
                Pollo's Ranchero · Panel de administración
            </footer>
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileBackdrop = document.getElementById('mobileBackdrop');

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
            menuToggle?.setAttribute('aria-expanded', 'false');
        }

        menuToggle?.addEventListener('click', () => {
            const isOpen = document.body.classList.toggle('sidebar-open');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        });

        mobileBackdrop?.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeSidebar();
        });


        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeLabel = document.getElementById('themeLabel');

        function aplicarTema(tema) {
            document.documentElement.dataset.theme = tema;
            const oscuro = tema === 'oscuro';
            themeIcon.textContent = oscuro ? '☀' : '☾';
            themeLabel.textContent = oscuro ? 'Modo claro' : 'Modo oscuro';
            themeToggle.setAttribute('aria-pressed', String(oscuro));
            themeToggle.setAttribute(
                'aria-label',
                oscuro ? 'Cambiar al modo claro' : 'Cambiar al modo oscuro'
            );

            try {
                localStorage.setItem('pollo-tema', tema);
            } catch (error) {
                // El tema se aplica aunque no pueda guardarse.
            }
        }

        aplicarTema(document.documentElement.dataset.theme || 'claro');

        themeToggle?.addEventListener('click', () => {
            const actual = document.documentElement.dataset.theme;
            aplicarTema(actual === 'oscuro' ? 'claro' : 'oscuro');
        });

    </script>
</body>

</html>