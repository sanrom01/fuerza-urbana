@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['icon'=>'bi-box-seam',       'bg'=>'#fff0f0', 'color'=>'#e63946', 'value'=> $stats['productos'],       'label'=>'Productos activos'],
        ['icon'=>'bi-people',         'bg'=>'#f0f4ff', 'color'=>'#4361ee', 'value'=> $stats['usuarios'],        'label'=>'Clientes registrados'],
        ['icon'=>'bi-bag-check',      'bg'=>'#f0fff4', 'color'=>'#2d6a4f', 'value'=> $stats['ventas'],          'label'=>'Ventas realizadas'],
        ['icon'=>'bi-chat-dots',      'bg'=>'#fffbf0', 'color'=>'#e9c46a', 'value'=> $stats['consultas'],       'label'=>'Consultas pendientes'],
        ['icon'=>'bi-currency-dollar','bg'=>'#f5f0ff', 'color'=>'#7b2d8b', 'value'=> '$'.number_format($stats['facturacion_mes'],0,',','.'), 'label'=>'Facturación del mes'],
        ['icon'=>'bi-exclamation-triangle','bg'=>'#fff4f0','color'=>'#e05b2a','value'=> $stats['sin_stock'],    'label'=>'Productos sin stock'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon mb-2" style="background:{{ $c['bg'] }}">
                <i class="bi {{ $c['icon'] }}" style="color:{{ $c['color'] }}"></i>
            </div>
            <div class="stat-value">{{ $c['value'] }}</div>
            <div class="stat-label">{{ $c['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-3">

    {{-- GRÁFICO DE VENTAS --}}
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-bar-chart me-2 text-danger"></i>Ventas últimos 6 meses</h6>
            </div>
            <div class="p-3">
                <canvas id="chartVentas" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- ÚLTIMAS VENTAS --}}
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-clock-history me-2 text-danger"></i>Últimas ventas</h6>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-sm btn-outline-secondary">Ver todas</a>
            </div>
            <table class="table table-admin">
                <tbody>
                    @foreach($ultimasVentas as $v)
                    <tr>
                        <td>
                            <div class="fw-500 small">#{{ $v->id }} — {{ $v->user->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $v->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="text-end">
                            <div class="fw-600 small">${{ number_format($v->total,0,',','.') }}</div>
                            @php
                            $colors = ['pendiente'=>'warning','confirmado'=>'info','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger','preparando'=>'secondary'];
                            @endphp
                            <span class="badge bg-{{ $colors[$v->status] ?? 'secondary' }} mt-1" style="font-size:.65rem">{{ $v->status }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- STOCK BAJO --}}
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Productos con stock bajo</h6>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
            </div>
            <table class="table table-admin">
                <thead><tr><th>Producto</th><th>Categoría</th><th>Stock</th><th>Mínimo</th><th>Estado</th></tr></thead>
                <tbody>
                    @forelse($stockBajo as $p)
                    <tr>
                        <td class="fw-500">{{ $p->name }}</td>
                        <td class="text-muted small">{{ $p->category->name }}</td>
                        <td>
                            <span class="fw-600 {{ $p->stock == 0 ? 'text-danger' : 'text-warning' }}">
                                {{ $p->stock }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $p->stock_min }}</td>
                        <td>
                            @if($p->stock == 0)
                                <span class="badge bg-danger">Sin stock</span>
                            @else
                                <span class="badge bg-warning text-dark">Stock bajo</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">¡Todo el stock está en orden!</td></tr>
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
const meses = @json($ventasMes->pluck('mes'));
const montos = @json($ventasMes->pluck('monto'));

new Chart(document.getElementById('chartVentas'), {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [{
            label: 'Facturación ($)',
            data: montos,
            backgroundColor: 'rgba(230,57,70,.75)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endpush