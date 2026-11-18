<!DOCTYPE html>
<html lang="es" data-theme="claro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar | Pollo's Ranchero</title>

    <script>
        try {
            const temaGuardado = localStorage.getItem('pollo-tema');
            if (temaGuardado === 'claro' || temaGuardado === 'oscuro') {
                document.documentElement.dataset.theme = temaGuardado;
            }
        } catch (error) {
            // Se usa el modo claro si el navegador bloquea localStorage.
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
            --brand-panel: linear-gradient(145deg, #800C0C, #96040C);
            --gold: #F5B300;
            --action: #800C0C;
            --action-hover: #65080A;
            --ambient-one: #FFC72C;
            --ambient-two: #D96200;
            --input-icon: #805E54;
            --shadow: 0 28px 80px rgba(43, 20, 20, .14);
        }

        :root[data-theme="oscuro"] {
            color-scheme: dark;
            --app-bg: #160803;
            --surface: #1F0B05;
            --surface-soft: #2E140B;
            --text: #FFD26A;
            --muted: #E2C7B2;
            --line: #49291E;
            --brand-panel: linear-gradient(145deg, #D90416, #A33600, #290C03);
            --gold: #FDB813;
            --action: #D90416;
            --action-hover: #A90A14;
            --ambient-one: #D90416;
            --ambient-two: #A33600;
            --input-icon: #E2C7B2;
            --shadow: 0 28px 80px rgba(0, 0, 0, .45);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 28px;
            overflow-x: hidden;
            color: var(--text);
            background:
                radial-gradient(ellipse at 10% 15%, color-mix(in srgb, var(--ambient-one) 18%, transparent), transparent 32%),
                radial-gradient(ellipse at 88% 82%, color-mix(in srgb, var(--ambient-two) 15%, transparent), transparent 34%),
                var(--app-bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
            transition: color .25s ease, background-color .25s ease;
        }

        button,
        input {
            font: inherit;
        }

        .theme-toggle {
            position: fixed;
            z-index: 5;
            top: 22px;
            right: 22px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--text);
            background: var(--surface);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            cursor: pointer;
            transition: transform .2s ease, border-color .2s ease;
        }

        .theme-toggle:hover {
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .theme-toggle:focus-visible,
        .toggle-password:focus-visible,
        .login-button:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 3px;
        }

        .theme-icon {
            font-size: 17px;
        }

        .theme-label {
            font-size: 12px;
            font-weight: 750;
        }

        .ambient {
            position: fixed;
            z-index: -1;
            width: 230px;
            aspect-ratio: 1;
            border-radius: 42% 58% 67% 33% / 47% 38% 62% 53%;
            filter: blur(3px);
            opacity: .35;
            animation: float 9s ease-in-out infinite alternate;
        }

        .ambient-one {
            top: 5%;
            right: 8%;
            background: var(--ambient-one);
        }

        .ambient-two {
            bottom: 2%;
            left: 4%;
            width: 180px;
            background: var(--ambient-two);
            animation-delay: -3s;
        }

        .login-shell {
            width: min(100%, 980px);
            min-height: 590px;
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 38px 26px 38px 26px;
            background: var(--surface);
            box-shadow: var(--shadow);
            animation: arrive .7s cubic-bezier(.2, .8, .2, 1) both;
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 590px;
            padding: 42px;
            overflow: hidden;
            color: #FFFFFF;
            background: var(--brand-panel);
        }

        .brand-panel::before,
        .brand-panel::after {
            position: absolute;
            content: "";
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 44% 56% 63% 37% / 41% 42% 58% 59%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 310px;
            height: 310px;
            top: 25%;
            right: -135px;
            transform: rotate(-24deg);
        }

        .brand-panel::after {
            width: 230px;
            height: 230px;
            top: 34%;
            right: -94px;
            transform: rotate(28deg);
        }

        .brand-top,
        .brand-message,
        .brand-bottom {
            position: relative;
            z-index: 1;
        }

        .brand-top {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-symbol {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 18px 12px 18px 12px;
            color: #1A0000;
            background: var(--gold);
            font-size: 25px;
            font-weight: 900;
            transform: rotate(-5deg);
        }

        .brand-name {
            font-weight: 800;
            letter-spacing: .02em;
        }

        .brand-caption {
            margin-top: 3px;
            color: rgba(255, 255, 255, .78);
            font-size: 12px;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .brand-message {
            max-width: 360px;
            margin: auto 0;
            padding: 42px 0;
        }

        .brand-message .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 999px;
            color: #FFFFFF;
            background: rgba(255, 255, 255, .10);
            font-size: 13px;
        }

        .eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 14px var(--gold);
        }

        .brand-message h1 {
            margin: 24px 0 14px;
            font-size: clamp(36px, 4.6vw, 54px);
            line-height: 1.02;
            letter-spacing: -.055em;
        }

        .brand-message p {
            max-width: 300px;
            margin: 0;
            color: rgba(255, 255, 255, .86);
            font-size: 16px;
            line-height: 1.65;
        }

        .brand-bottom {
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(32px, 6vw, 68px);
            background: var(--surface);
        }

        .form-heading {
            margin-bottom: 34px;
        }

        .form-heading .overline {
            margin: 0 0 10px;
            color: var(--action);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .form-heading h2 {
            margin: 0;
            color: var(--text);
            font-size: clamp(30px, 3.4vw, 40px);
            line-height: 1.1;
            letter-spacing: -.045em;
        }

        .form-heading p {
            margin: 12px 0 0;
            color: var(--muted);
            line-height: 1.55;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: var(--text);
            font-size: 14px;
            font-weight: 750;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 58px;
            padding: 0 16px;
            border: 1px solid var(--line);
            border-radius: 20px 14px 20px 14px;
            background: var(--surface-soft);
            transition:
                border-color .2s ease,
                box-shadow .25s cubic-bezier(.2, .8, .2, 1),
                transform .25s cubic-bezier(.2, .8, .2, 1);
        }

        .input-wrap:focus-within {
            border-color: var(--action);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--gold) 28%, transparent);
            transform: translateY(-1px);
        }

        .input-icon {
            flex: 0 0 auto;
            color: var(--input-icon);
        }

        .input-wrap input {
            width: 100%;
            min-width: 0;
            padding: 16px 0;
            border: 0;
            outline: 0;
            color: var(--text);
            background: transparent;
            font-size: 15px;
        }

        .input-wrap input::placeholder {
            color: var(--muted);
            opacity: .72;
        }

        .toggle-password {
            flex: 0 0 auto;
            padding: 7px;
            border: 0;
            border-radius: 50%;
            color: var(--action);
            background: transparent;
            cursor: pointer;
        }

        .toggle-password:hover {
            background: color-mix(in srgb, var(--gold) 18%, transparent);
        }

        .field-error {
            margin: 8px 0 0 4px;
            color: #B42318;
            font-size: 13px;
        }

        :root[data-theme="oscuro"] .field-error {
            color: #FF8A80;
        }

        .login-button {
            width: 100%;
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            margin-top: 8px;
            border: 0;
            border-radius: 22px 15px 22px 15px;
            color: #FFFFFF;
            background: var(--action);
            box-shadow: 0 9px 20px rgba(128, 12, 12, .2);
            font-weight: 800;
            cursor: pointer;
            transition:
                transform .25s cubic-bezier(.2, .8, .2, 1),
                background .2s ease,
                box-shadow .25s ease;
        }

        .login-button:hover {
            background: var(--action-hover);
            box-shadow: 0 13px 25px rgba(128, 12, 12, .28);
            transform: translateY(-2px);
        }

        .login-button:active {
            transform: scale(.985);
        }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 22px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .security-dot {
            color: var(--gold);
        }

        @keyframes arrive {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.99);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float {
            from {
                transform: translate3d(0, 0, 0) rotate(0);
            }
            to {
                transform: translate3d(12px, -18px, 0) rotate(12deg);
            }
        }

        @media (max-width: 760px) {
            body {
                padding: 16px;
            }

            .theme-toggle {
                top: 12px;
                right: 12px;
            }

            .login-shell {
                max-width: 470px;
                grid-template-columns: 1fr;
                border-radius: 30px 22px 30px 22px;
            }

            .brand-panel {
                min-height: auto;
                padding: 26px;
            }

            .brand-message {
                padding: 34px 0 18px;
            }

            .brand-message h1 {
                max-width: 340px;
                margin-top: 18px;
                font-size: 39px;
            }

            .brand-message p,
            .brand-bottom {
                display: none;
            }

            .form-panel {
                padding: 30px 26px 34px;
            }

            .form-heading {
                margin-bottom: 26px;
            }
        }

        @media (max-width: 420px) {
            .theme-label {
                display: none;
            }

            .theme-toggle {
                width: 44px;
                justify-content: center;
                padding: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <button class="theme-toggle" id="themeToggle" type="button"
            aria-label="Cambiar al modo oscuro" aria-pressed="false">
        <span class="theme-icon" id="themeIcon" aria-hidden="true">☾</span>
        <span class="theme-label" id="themeLabel">Modo oscuro</span>
    </button>

    <div class="ambient ambient-one" aria-hidden="true"></div>
    <div class="ambient ambient-two" aria-hidden="true"></div>

    <main class="login-shell">
        <section class="brand-panel" aria-label="Pollo's Ranchero">
            <div class="brand-top">
                <div class="brand-symbol" aria-hidden="true">P</div>
                <div>
                    <div class="brand-name">Pollo's Ranchero</div>
                    <div class="brand-caption">Sabor de casa</div>
                </div>
            </div>

            <div class="brand-message">
                <span class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    Panel de administración
                </span>
                <h1>Todo listo para atender.</h1>
                <p>Ingresa para gestionar el menú y los pedidos del restaurante.</p>
            </div>

            <div class="brand-bottom">Gestión sencilla para cada jornada.</div>
        </section>

        <section class="form-panel">
            <header class="form-heading">
                <p class="overline">Bienvenido</p>
                <h2>Inicia sesión</h2>
                <p>Usa tus credenciales de administrador para continuar.</p>
            </header>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="nombre_usuario">Usuario</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="21" height="21" viewBox="0 0 24 24"
                             fill="none" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.5"
                                    stroke="currentColor" stroke-width="1.8"/>
                            <path d="M5 20c.5-3.2 3.1-5.2 7-5.2s6.5 2 7 5.2"
                                  stroke="currentColor" stroke-width="1.8"
                                  stroke-linecap="round"/>
                        </svg>
                        <input
                            id="nombre_usuario"
                            name="nombre_usuario"
                            type="text"
                            value="{{ old('nombre_usuario') }}"
                            placeholder="Ej.: administrador"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>
                    @error('nombre_usuario')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <div class="input-wrap">
                        <svg class="input-icon" width="21" height="21" viewBox="0 0 24 24"
                             fill="none" aria-hidden="true">
                            <rect x="5" y="10" width="14" height="10" rx="2.5"
                                  stroke="currentColor" stroke-width="1.8"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"
                                  stroke="currentColor" stroke-width="1.8"
                                  stroke-linecap="round"/>
                            <circle cx="12" cy="15" r="1" fill="currentColor"/>
                        </svg>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Escribe tu contraseña"
                            autocomplete="current-password"
                            required
                        >
                        <button class="toggle-password" type="button"
                                id="togglePassword"
                                aria-label="Mostrar contraseña"
                                aria-pressed="false">
                            <svg width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" aria-hidden="true">
                                <path d="M2.5 12s3.3-6 9.5-6 9.5 6 9.5 6-3.3 6-9.5 6-9.5-6-9.5-6Z"
                                      stroke="currentColor" stroke-width="1.8"/>
                                <circle cx="12" cy="12" r="2.5"
                                        stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button class="login-button" type="submit">
                    Ingresar al panel
                    <svg width="20" height="20" viewBox="0 0 24 24"
                         fill="none" aria-hidden="true">
                        <path d="M5 12h13m-5-5 5 5-5 5"
                              stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <p class="security-note">
                    <span class="security-dot" aria-hidden="true">●</span>
                    Acceso protegido para el personal autorizado
                </p>
            </form>
        </section>
    </main>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeLabel = document.getElementById('themeLabel');

        function aplicarTema(tema) {
            document.documentElement.dataset.theme = tema;

            const estaOscuro = tema === 'oscuro';
            themeIcon.textContent = estaOscuro ? '☀' : '☾';
            themeLabel.textContent = estaOscuro ? 'Modo claro' : 'Modo oscuro';
            themeToggle.setAttribute('aria-pressed', String(estaOscuro));
            themeToggle.setAttribute(
                'aria-label',
                estaOscuro ? 'Cambiar al modo claro' : 'Cambiar al modo oscuro'
            );

            try {
                localStorage.setItem('pollo-tema', tema);
            } catch (error) {
                // El tema se aplica aunque no pueda guardarse.
            }
        }

        aplicarTema(document.documentElement.dataset.theme || 'claro');

        themeToggle.addEventListener('click', () => {
            const temaActual = document.documentElement.dataset.theme;
            aplicarTema(temaActual === 'oscuro' ? 'claro' : 'oscuro');
        });

        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const mostrando = passwordInput.type === 'password';
            passwordInput.type = mostrando ? 'text' : 'password';
            togglePassword.setAttribute('aria-pressed', String(mostrando));
            togglePassword.setAttribute(
                'aria-label',
                mostrando ? 'Ocultar contraseña' : 'Mostrar contraseña'
            );
        });
    </script>
</body>
</html>