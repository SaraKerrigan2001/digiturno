<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisión de Módulos — DigiTurno APE SENA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sena-green:  #39A900;
            --sena-dark:   #1e3a1e;
            --sena-orange: #FF6B00;
            --bg:          #0d1117;
            --surface:     #161b22;
            --surface2:    #1c2128;
            --border:      #30363d;
            --text:        #e6edf3;
            --text-muted:  #8b949e;
            --danger:      #f85149;
            --warning:     #d29922;
            --success:     #3fb950;
            --info:        #388bfd;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, var(--sena-dark) 0%, #0d2a0d 100%);
            border-bottom: 2px solid var(--sena-green);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-brand { display: flex; align-items: center; gap: 1rem; }
        .header-brand img { width: 48px; height: 48px; object-fit: contain; }
        .header-brand h1 { font-size: 1.25rem; font-weight: 700; color: var(--sena-green); }
        .header-brand p { font-size: 0.75rem; color: var(--text-muted); }
        .header-nav { display: flex; gap: 0.75rem; }
        .btn-nav {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-secondary { background: var(--surface2); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { color: var(--text); border-color: var(--sena-green); }

        /* ── Layout ── */
        .container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        .section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
        .grid-full { grid-column: 1 / -1; }

        /* ── Cards ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .card-title { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .card-subtitle { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.2rem; }

        /* ── Estado Módulos ── */
        .modulo-card {
            background: var(--surface2);
            border-radius: 10px;
            padding: 1.25rem;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .modulo-card.atendiendo { border-color: var(--success); }
        .modulo-card.pausa      { border-color: var(--warning); }
        .modulo-card.libre      { border-color: var(--info); }
        .modulo-card.sin-asignar{ border-color: var(--border); }

        .modulo-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            text-transform: uppercase;
        }
        .badge-atendiendo { background: rgba(63,185,80,0.15); color: var(--success); }
        .badge-pausa      { background: rgba(210,153,34,0.15); color: var(--warning); }
        .badge-libre      { background: rgba(56,139,253,0.15); color: var(--info); }
        .badge-sin-asignar{ background: rgba(139,148,158,0.15); color: var(--text-muted); }

        .modulo-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
        .modulo-avatar {
            width: 52px; height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }
        .modulo-id {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--sena-green);
        }
        .modulo-name { font-size: 0.85rem; font-weight: 600; }
        .modulo-sub  { font-size: 0.7rem; color: var(--text-muted); }

        .modulo-stats { display: flex; gap: 1rem; }
        .stat-item { text-align: center; }
        .stat-value { font-size: 1.25rem; font-weight: 700; color: var(--text); }
        .stat-label { font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; }

        .turno-activo {
            background: rgba(56,139,253,0.08);
            border: 1px solid rgba(56,139,253,0.2);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            margin-top: 0.75rem;
            font-size: 0.78rem;
        }
        .turno-numero { font-weight: 700; color: var(--sena-green); font-size: 1rem; }

        /* ── Meta Emprendedores ── */
        .meta-progress-bg {
            height: 12px;
            background: var(--surface2);
            border-radius: 999px;
            overflow: hidden;
            margin: 0.75rem 0;
        }
        .meta-progress-fill {
            height: 100%;
            border-radius: 999px;
            transition: width 1s ease;
            background: linear-gradient(90deg, var(--sena-green), #5cd600);
        }
        .meta-numbers {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }
        .meta-actual { font-size: 2.5rem; font-weight: 800; color: var(--sena-green); }
        .meta-total  { font-size: 0.8rem; color: var(--text-muted); }
        .meta-pct    { font-size: 0.9rem; font-weight: 600; color: var(--text-muted); }

        /* ── Alertas Espera >20 min ── */
        .alerta-turno {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(248,81,73,0.3);
            background: rgba(248,81,73,0.06);
            margin-bottom: 0.6rem;
            animation: pulse-alert 2s infinite;
        }
        @keyframes pulse-alert {
            0%, 100% { border-color: rgba(248,81,73,0.3); }
            50%       { border-color: rgba(248,81,73,0.7); }
        }
        .alerta-turno-num { font-weight: 700; color: var(--danger); font-size: 1rem; }
        .alerta-turno-info { font-size: 0.78rem; color: var(--text-muted); }
        .alerta-tiempo {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--danger);
            background: rgba(248,81,73,0.12);
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
        }
        .no-alertas {
            text-align: center;
            padding: 2rem;
            color: var(--success);
            font-size: 0.9rem;
        }
        .no-alertas .icon { font-size: 2.5rem; margin-bottom: 0.5rem; }

        /* ── Rotación Personal ── */
        .rotacion-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border);
        }
        .rotacion-row:last-child { border-bottom: none; }
        .rotacion-nombre { font-size: 0.82rem; font-weight: 500; }
        .rotacion-vigencia { font-size: 0.72rem; color: var(--text-muted); }
        .dias-pill {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
        }
        .dias-ok      { background: rgba(63,185,80,0.12);  color: var(--success); }
        .dias-warning { background: rgba(210,153,34,0.12); color: var(--warning); }
        .dias-danger  { background: rgba(248,81,73,0.12);  color: var(--danger);  }
        .rotacion-alerta {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            background: rgba(248,81,73,0.15);
            color: var(--danger);
            text-transform: uppercase;
        }

        /* ── Timestamp ── */
        .timestamp-bar {
            text-align: center;
            padding: 0.75rem;
            font-size: 0.72rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            margin-top: 2rem;
        }
        #reloj { color: var(--sena-green); font-weight: 600; }

        @media (max-width: 900px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="header-brand">
        <div>
            <h1>🎯 Supervisión de Módulos — CU-04</h1>
            <p>APE SENA · Panel de Coordinación en Tiempo Real</p>
        </div>
    </div>
    <nav class="header-nav">
        <a href="{{ route('coordinador.dashboard') }}" class="btn-nav btn-secondary">← Dashboard</a>
        <a href="{{ route('coordinador.modulos') }}"   class="btn-nav btn-secondary">Módulos</a>
    </nav>
</header>

<div class="container">

    <!-- ── SECCIÓN 1: Estado de Módulos 15 y 19 ── -->
    <div class="section-title">🖥️ Estado de Módulos en Tiempo Real</div>
    <div class="grid-2" style="margin-bottom:2rem;">
        @foreach($modulosVigilancia as $modId)
        @php
            $mod    = $estadoModulos[$modId];
            $estado = strtolower(str_replace(' ', '-', $mod['estado']));
            $badgeClass = match($mod['estado']) {
                'Atendiendo'  => 'badge-atendiendo',
                'Pausa'       => 'badge-pausa',
                'Libre'       => 'badge-libre',
                default       => 'badge-sin-asignar',
            };
            $cardClass = match($mod['estado']) {
                'Atendiendo' => 'atendiendo',
                'Pausa'      => 'pausa',
                'Libre'      => 'libre',
                default      => 'sin-asignar',
            };
        @endphp
        <div class="modulo-card {{ $cardClass }}">
            <span class="modulo-badge {{ $badgeClass }}">{{ $mod['estado'] }}</span>

            <div class="modulo-header">
                <div class="modulo-id">{{ $modId }}</div>
                <div>
                    <div class="modulo-name">{{ $mod['nombre'] }}</div>
                    <div class="modulo-sub">Módulo de Vigilancia</div>
                </div>
            </div>

            <div class="modulo-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $mod['atencionesDia'] }}</div>
                    <div class="stat-label">Atend. Hoy</div>
                </div>
                @if($mod['pausaActiva'])
                <div class="stat-item">
                    <div class="stat-value" style="color:var(--warning);">
                        ☕
                    </div>
                    <div class="stat-label">En receso desde {{ \Carbon\Carbon::parse($mod['pausaActiva']->hora_inicio)->format('H:i') }}</div>
                </div>
                @endif
            </div>

            @if($mod['atencionActiva'])
            <div class="turno-activo">
                <div class="turno-numero">{{ $mod['atencionActiva']->turno->tur_numero ?? '—' }}</div>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px;">
                    @php
                        $persona = $mod['atencionActiva']->turno->solicitante->persona ?? null;
                    @endphp
                    {{ $persona ? $persona->pers_nombres . ' ' . $persona->pers_apellidos : 'Ciudadano en atención' }}
                    · Inició {{ \Carbon\Carbon::parse($mod['atencionActiva']->atnc_hora_inicio)->format('H:i') }}
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- ── SECCIÓN 2: Meta Emprendedores + Alertas ── -->
    <div class="grid-2" style="margin-bottom:2rem;">

        <!-- Meta Emprendedores -->
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">🚀 Meta Semanal — Emprendedores</div>
                    <div class="card-subtitle">Semana {{ now()->startOfWeek()->format('d/m') }} – {{ now()->endOfWeek()->format('d/m/Y') }}</div>
                </div>
                <span style="font-size:1.8rem;">📊</span>
            </div>
            <div class="meta-numbers">
                <div>
                    <span class="meta-actual">{{ $emprendedoresSemana }}</span>
                    <span class="meta-total"> / {{ $metaEmprendedores }} ciudadanos</span>
                </div>
                <div class="meta-pct">{{ $porcentajeMeta }}%</div>
            </div>
            <div class="meta-progress-bg">
                <div class="meta-progress-fill" style="width: {{ $porcentajeMeta }}%;"></div>
            </div>
            @if($porcentajeMeta >= 100)
                <div style="font-size:0.8rem;color:var(--success);font-weight:600;text-align:center;margin-top:0.5rem;">✅ ¡Meta cumplida esta semana!</div>
            @elseif($porcentajeMeta >= 75)
                <div style="font-size:0.8rem;color:var(--warning);text-align:center;margin-top:0.5rem;">⚠️ Falta{{ $metaEmprendedores - $emprendedoresSemana }} para completar la meta</div>
            @else
                <div style="font-size:0.8rem;color:var(--text-muted);text-align:center;margin-top:0.5rem;">Faltan {{ $metaEmprendedores - $emprendedoresSemana }} emprendedores para alcanzar la meta</div>
            @endif
            <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border);">
                <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:0.5rem;text-transform:uppercase;font-weight:600;">Servicio: Emprendimiento</div>
                <div style="font-size:0.78rem;color:var(--text-muted);">Los turnos con servicio "Emprendimiento" cuentan hacia esta meta. Módulos 15 y 19 son los responsables de este proceso.</div>
            </div>
        </div>

        <!-- Alertas Espera >20 min -->
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title" style="color:{{ $turnosEspera20->count() > 0 ? 'var(--danger)' : 'var(--text)' }}">
                        ⏱️ Alertas de Espera &gt; 20 min
                    </div>
                    <div class="card-subtitle">
                        {{ $turnosEspera20->count() }} turno(s) con espera crítica ahora
                    </div>
                </div>
                @if($turnosEspera20->count() > 0)
                    <span style="font-size:1.8rem;animation:pulse-alert 1.5s infinite;">🚨</span>
                @else
                    <span style="font-size:1.8rem;">✅</span>
                @endif
            </div>
            @forelse($turnosEspera20 as $t)
            <div class="alerta-turno">
                <div>
                    <div class="alerta-turno-num">{{ $t->tur_numero }}</div>
                    <div class="alerta-turno-info">
                        @php $per = $t->solicitante->persona ?? null; @endphp
                        {{ $per ? $per->pers_nombres . ' ' . $per->pers_apellidos : 'Ciudadano' }}
                        — {{ $t->tur_perfil }} | {{ $t->tur_servicio }}
                    </div>
                </div>
                <div class="alerta-tiempo">{{ $t->minutos_espera }} min</div>
            </div>
            @empty
            <div class="no-alertas">
                <div class="icon">✅</div>
                <div>Todos los turnos en espera son <strong>&lt; 20 minutos</strong>.</div>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.4rem;">Operación dentro de los parámetros normales</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- ── SECCIÓN 3: Rotación Bimestral ── -->
    <div class="section-title">🔄 Indicador de Rotación Bimestral del Personal</div>
    <div class="card" style="margin-bottom:2rem;">
        <div class="card-header">
            <div>
                <div class="card-title">Personal — Vigencia de Contrato</div>
                <div class="card-subtitle">Se marca como "Rotación requerida" cuando la vigencia es ≤ 60 días • Para el personal de vigilancia</div>
            </div>
            @php $requierenRotacion = $asesoresRotacion->where('requiere_rotacion', true)->count(); @endphp
            @if($requierenRotacion > 0)
                <span style="font-size:0.8rem;font-weight:700;color:var(--danger);background:rgba(248,81,73,0.1);padding:0.3rem 0.8rem;border-radius:6px;">
                    ⚠️ {{ $requierenRotacion }} requiere(n) rotación
                </span>
            @else
                <span style="font-size:0.8rem;font-weight:700;color:var(--success);background:rgba(63,185,80,0.1);padding:0.3rem 0.8rem;border-radius:6px;">
                    ✅ Sin rotaciones pendientes
                </span>
            @endif
        </div>

        @forelse($asesoresRotacion as $ase)
        <div class="rotacion-row">
            <div>
                <div class="rotacion-nombre">{{ $ase['nombre'] }}</div>
                <div class="rotacion-vigencia">Vigencia: {{ $ase['vigencia'] }} · ID asesor: {{ $ase['ase_id'] }}</div>
            </div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                @php
                    $dias = $ase['dias_restantes'];
                    $pillClass = $dias > 90 ? 'dias-ok' : ($dias > 30 ? 'dias-warning' : 'dias-danger');
                @endphp
                <span class="dias-pill {{ $pillClass }}">
                    {{ $dias >= 0 ? $dias . ' días' : 'Vencido' }}
                </span>
                @if($ase['requiere_rotacion'])
                    <span class="rotacion-alerta">Rotar</span>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:0.85rem;">
            No hay asesores con vigencia registrada.
        </div>
        @endforelse
    </div>

</div>

<!-- Barra de timestamp -->
<div class="timestamp-bar">
    DigiTurno APE SENA — Actualizado automáticamente cada 60 seg &nbsp;|&nbsp; Hora local: <span id="reloj">--:--:--</span>
    &nbsp;|&nbsp; <a href="{{ route('coordinador.supervision') }}" style="color:var(--sena-green);text-decoration:none;">🔄 Actualizar</a>
</div>

<script>
    // Reloj en tiempo real
    function actualizarReloj() {
        const ahora = new Date();
        document.getElementById('reloj').textContent =
            ahora.toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    actualizarReloj();
    setInterval(actualizarReloj, 1000);

    // Auto-refresh cada 60 segundos
    setTimeout(() => location.reload(), 60000);
</script>
</body>
</html>
