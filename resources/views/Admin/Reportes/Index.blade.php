@extends('layouts.admin')
@section('title', 'Reportes')
@section('content')
<h5 class="fw-600 mb-4">Reportes del negocio</h5>
<div class="row g-4">

    {{-- VENTAS POR MES --}}
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-graph-up me-2 text-danger"></i>Ventas por mes (últimos 12 meses)</h6>
            </div>
            <div class="p-3"><canvas id="chartVentas" height="80"></canvas></div>
        </div>
    </div>

    {{-- PRODUCTOS MÁS VENDIDOS --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header"><h6><i class="bi bi-trophy me-2 text-warning"></i>Productos más vendidos</h6></div>
            <table class="table table-admin">
                <thead><tr><th>#</th><th>Producto</th><th class="text-end">Unidades</th><th class="text-end pe-4">Facturado</th></tr></thead>
                <tbody>
                    @forelse($masVendidos as $i => $item)
                    <tr>
                        <td class="fw-600 text-muted">{{ $i+1 }}</td>
                        <td class="fw-500">{{ $item->product->name ?? '—' }}</td>
                        <td class="text-end fw-600">{{ $item->unidades }}</td>
                        <td class="text-end pe-4">${{ number_format($item->facturado,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin datos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MEJORES CLIENTES --}}
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header"><h6><i class="bi bi-star me-2 text-warning"></i>Mejores clientes</h6></div>
            <table class="table table-admin">
                <thead><tr><th>#</th><th>Cliente</th><th class="text-end">Órdenes</th><th class="text-end pe-4">Total gastado</th></tr></thead>
                <tbody>
                    @forelse($mejoresClientes as $i => $c)
                    <tr>
                        <td class="fw-600 text-muted">{{ $i+1 }}</td>
                        <td>
                            <div class="fw-500">{{ $c->user->name ?? '—' }}</div>
                            <small class="text-muted">{{ $c->user->email ?? '' }}</small>
                        </td>
                        <td class="text-end">{{ $c->ordenes }}</td>
                        <td class="text-end pe-4 fw-600">${{ number_format($c->total_gastado,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin datos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SIN STOCK --}}
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header"><h6><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Productos sin stock</h6></div>
            <table class="table table-admin">
                <thead><tr><th>Producto</th><th>Categoría</th><th>SKU</th><th class="text-end pe-4">Acciones</th></tr></thead>
                <tbody>
                    @forelse($sinStock as $p)
                    <tr>
                        <td class="fw-500">{{ $p->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $p->category->name }}</span></td>
                        <td class="text-muted small">{{ $p->sku ?? '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-sm btn-red">
                                <i class="bi bi-pencil me-1"></i>Reponer
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">¡Todos los productos tienen stock!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chartVentas'), {
    type: 'line',
    data: {
        labels: @json($ventasPorMes->pluck('mes')),
        datasets: [{
            label: 'Facturación ($)',
            data: @json($ventasPorMes->pluck('monto')),
            borderColor: '#e63946',
            backgroundColor: 'rgba(230,57,70,.1)',
            fill: true, tension: 0.4, pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color:'rgba(0,0,0,.05)' }, ticks: { font: { size:11 } } },
            x: { grid: { display:false }, ticks: { font: { size:11 } } }
        }
    }
});
</script>
@endpush