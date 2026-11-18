@extends('layouts.admin')

@section('title', 'Punto de venta')

@section('content')
    <header class="pos-heading">
        <div>
            <span class="eyebrow">Ventas</span>
            <h1>Punto de venta</h1>
            <p>Selecciona los platos y las cantidades del pedido.</p>
        </div>
    </header>

    @if (session('success'))
        <div class="notice" role="status">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="notice notice-error">
            <strong>Revisa los datos del pedido:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="pos-form" method="POST" action="{{ route('admin.punto_venta.store') }}">
        @csrf

        <div class="pos-layout">
            <section class="products-card">
                <h2>Platos disponibles</h2>

                <div class="products-grid">
                    @forelse ($platos as $plato)
                        <article class="product-card"
                                 data-product
                                 data-price="{{ $plato->precio }}">
                            <label class="product-select">
                                <input class="product-checkbox"
                                       type="checkbox"
                                       value="{{ $plato->id }}"
                                       aria-label="Seleccionar {{ $plato->nombre }}">
                                <span class="product-name">{{ $plato->nombre }}</span>
                            </label>

                            <p class="product-category">
                                {{ $plato->categoria?->nombre ?? 'Sin categoría' }}
                            </p>

                            <div class="product-bottom">
                                <strong>Bs {{ number_format((float) $plato->precio, 2) }}</strong>
                                <label class="quantity-label">
                                    Cantidad
                                    <input class="product-quantity"
                                           type="number"
                                           min="1"
                                           max="99"
                                           value="1"
                                           disabled>
                                </label>
                            </div>
                        </article>
                    @empty
                        <p class="empty-state">No hay platos activos disponibles.</p>
                    @endforelse
                </div>
            </section>

            <aside class="order-card">
                <h2>Resumen del pedido</h2>

                <div id="order-summary" class="order-summary">
                    Selecciona uno o más platos.
                </div>

                <div class="total-row">
                    <span>Total</span>
                    <strong id="order-total">Bs 0,00</strong>
                </div>

                <label class="received-label" for="monto_recibido">
                    Monto recibido (Bs)
                </label>
                <input id="monto_recibido"
                       name="monto_recibido"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ old('monto_recibido') }}">

                <button class="pos-submit" type="submit">
                    Registrar pedido
                </button>
            </aside>
        </div>
    </form>

    <style>
        .pos-heading { margin-bottom:24px; }
        .pos-heading h1 { margin:7px 0; font-size:clamp(30px,4vw,40px); }
        .pos-heading p,.product-category { margin:0; color:var(--muted); }
        .eyebrow { color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .pos-layout { display:grid; grid-template-columns:minmax(0,1fr) 320px; align-items:start; gap:20px; }
        .products-card,.order-card { padding:20px; border:1px solid var(--line); border-radius:22px; color:var(--text); background:var(--surface); box-shadow:var(--shadow); }
        .products-card h2,.order-card h2 { margin:0 0 18px; font-size:18px; }
        .products-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:12px; }
        .product-card { padding:16px; border:1px solid var(--line); border-radius:16px; background:var(--surface-soft); }
        .product-select { display:flex; align-items:center; gap:9px; cursor:pointer; }
        .product-checkbox { width:18px; height:18px; accent-color:var(--action); }
        .product-name { font-weight:750; }
        .product-category { margin:8px 0 14px 27px; font-size:12px; }
        .product-bottom { display:flex; align-items:end; justify-content:space-between; gap:10px; }
        .quantity-label { display:grid; gap:4px; color:var(--muted); font-size:11px; }
        .product-quantity { width:72px; padding:7px; border:1px solid var(--line); border-radius:9px; color:var(--text); background:var(--surface); }
        .order-summary { display:grid; gap:10px; min-height:60px; color:var(--muted); font-size:13px; }
        .summary-line { display:flex; justify-content:space-between; gap:12px; color:var(--text); }
        .total-row { display:flex; justify-content:space-between; margin:18px 0; padding-top:16px; border-top:1px solid var(--line); font-size:16px; }
        .received-label { display:block; margin-bottom:7px; color:var(--muted); font-size:12px; }
        #monto_recibido { width:100%; padding:11px; border:1px solid var(--line); border-radius:11px; color:var(--text); background:var(--surface-soft); }
        .pos-submit { width:100%; min-height:44px; margin-top:14px; border:0; border-radius:13px; color:#fff; background:var(--action); font-weight:750; cursor:pointer; }
        .notice { margin-bottom:16px; padding:13px 16px; border:1px solid var(--line); border-radius:14px; color:var(--text); background:var(--surface); }
        .notice-error { border-color:#B42318; }
        .notice ul { margin-bottom:0; }
        .empty-state { color:var(--muted); }
        @media(max-width:900px) { .pos-layout { grid-template-columns:1fr; } }
    </style>

    <script>
        const form = document.getElementById('pos-form');
        const cards = [...document.querySelectorAll('[data-product]')];
        const summary = document.getElementById('order-summary');
        const totalElement = document.getElementById('order-total');

        const formatoDinero = new Intl.NumberFormat('es-BO', {
            style: 'currency',
            currency: 'BOB'
        });

        function actualizarResumen() {
            const seleccionados = cards.filter(card =>
                card.querySelector('.product-checkbox').checked
            );

            let total = 0;

            if (seleccionados.length === 0) {
                summary.textContent = 'Selecciona uno o más platos.';
            } else {
                summary.innerHTML = seleccionados.map(card => {
                    const nombre = card.querySelector('.product-name').textContent.trim();
                    const cantidad = Number(card.querySelector('.product-quantity').value);
                    const precio = Number(card.dataset.price);
                    total += precio * cantidad;

                    return `<div class="summary-line">
                        <span>${cantidad} × ${nombre}</span>
                        <span>${formatoDinero.format(precio * cantidad)}</span>
                    </div>`;
                }).join('');
            }

            totalElement.textContent = formatoDinero.format(total);
        }

        cards.forEach(card => {
            const checkbox = card.querySelector('.product-checkbox');
            const quantity = card.querySelector('.product-quantity');

            checkbox.addEventListener('change', () => {
                quantity.disabled = !checkbox.checked;
                actualizarResumen();
            });

            quantity.addEventListener('input', actualizarResumen);
        });

        form.addEventListener('submit', event => {
            form.querySelectorAll('.generated-item').forEach(input => input.remove());

            const seleccionados = cards.filter(card =>
                card.querySelector('.product-checkbox').checked
            );

            if (seleccionados.length === 0) {
                event.preventDefault();
                alert('Selecciona al menos un plato.');
                return;
            }

            seleccionados.forEach((card, index) => {
                const id = card.querySelector('.product-checkbox').value;
                const cantidad = card.querySelector('.product-quantity').value;

                [
                    [`items[${index}][plato_id]`, id],
                    [`items[${index}][cantidad]`, cantidad]
                ].forEach(([name, value]) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    input.classList.add('generated-item');
                    form.appendChild(input);
                });
            });
        });
    </script>
@endsection