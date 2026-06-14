@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['icon'=>'bi-box-seam',          'bg'=>'#fff0f0', 'color'=>'#e63946', 'value'=>$stats['productos'],       'label'=>'Productos activos'],
        ['icon'=>'bi-people',            'bg'=>'#f0f4ff', 'color'=>'#4361ee', 'value'=>$stats['usuarios'],        'label'=>'Clientes'],
        ['icon'=>'bi-bag-check',         'bg'=>'#f0fff4', 'color'=>'#2d6a4f', 'value'=>$stats['ventas'],          'label'=>'Ventas'],
        ['icon'=>'bi-chat-dots',         'bg'=>'#fffbf0', 'color'=>'#e9c46a', 'value'=>$stats['consultas'],       'label'=>'Consultas'],
        ['icon'=>'bi-currency-dollar',   'bg'=>'#f5f0ff', 'color'=>'#7b2d8b', 'value'=>'$'.number_format($stats['facturacion_mes'],0,',','.'), 'label'=>'Facturación mes'],
        ['icon'=>'bi-exclamation-triangle','bg'=>'#fff4f0','color'=>'#e05b2a','value'=>$stats['sin_stock'],       'label'=>'Sin stock'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-md-4 col-xl-2">
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

    {{-- GRÁFICO --}}
    <div class="col-12 col-lg-7">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-bar-chart me-2 text-danger"></i>Ventas últimos 6 meses</h6>
            </div>
            <div class="p-3">
                <canvas id="chartVentas" height="140"></canvas>
            </div>
        </div>
    </div>

    {{-- ÚLTIMAS VENTAS --}}
    <div class="col-12 col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-clock-history me-2 text-danger"></i>Últimas ventas</h6>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-sm btn-outline-secondary">Ver todas</a>
            </div>

            {{-- Desktop --}}
            <div class="d-none d-sm-block">
                <table class="table table-admin">
                    <tbody>
                        @foreach($ultimasVentas as $v)
                        @php $colors=['pendiente'=>'warning','confirmado'=>'info','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger','preparando'=>'secondary']; @endphp
                        <tr>
                            <td>
                                <div class="fw-500 small">#{{ $v->id }} — {{ $v->user->name }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $v->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="text-end">
                                <div class="fw-600 small">${{ number_format($v->total,0,',','.') }}</div>
                                <span class="badge bg-{{ $colors[$v->status] ?? 'secondary' }} mt-1" style="font-size:.65rem">{{ $v->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Móvil --}}
            <div class="d-sm-none p-2">
                @foreach($ultimasVentas as $v)
                @php $colors=['pendiente'=>'warning','confirmado'=>'info','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger','preparando'=>'secondary']; @endphp
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-600 small">#{{ str_pad($v->id,5,'0',STR_PAD_LEFT) }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $v->user->name }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-600 small text-danger">${{ number_format($v->total,0,',','.') }}</div>
                        <span class="badge bg-{{ $colors[$v->status] ?? 'secondary' }}" style="font-size:.6rem">{{ $v->status }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- STOCK BAJO --}}
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Productos con stock bajo</h6>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
            </div>

            {{-- Desktop --}}
            <div class="d-none d-md-block table-responsive-admin">
                <table class="table table-admin">
                    <thead><tr><th>Producto</th><th>Categoría</th><th>Stock</th><th>Mínimo</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($stockBajo as $p)
                        <tr>
                            <td class="fw-500">{{ $p->name }}</td>
                            <td class="text-muted small">{{ $p->category->name }}</td>
                            <td><span class="fw-600 {{ $p->stock == 0 ? 'text-danger' : 'text-warning' }}">{{ $p->stock }}</span></td>
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

            {{-- Móvil --}}
            <div class="d-md-none p-2">
                @forelse($stockBajo as $p)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-600 small">{{ $p->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $p->category->name }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-700 {{ $p->stock == 0 ? 'text-danger' : 'text-warning' }}">{{ $p->stock }} uds</div>
                        @if($p->stock == 0)
                            <span class="badge bg-danger" style="font-size:.65rem">Sin stock</span>
                        @else
                            <span class="badge bg-warning text-dark" style="font-size:.65rem">Stock bajo</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">¡Todo el stock está en orden!</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const meses  = @json($ventasMes->pluck('mes'));
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
            y: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 11 }, callback: v => '$'+v.toLocaleString('es-AR') } },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});
</script>
@endpush