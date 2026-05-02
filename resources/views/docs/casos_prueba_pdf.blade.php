<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Casos de Prueba - DigiTurno SENA APE</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; background: #fff; padding: 20px; }
  .header { background: #000080; color: white; padding: 20px 24px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 16px; }
  .header h1 { font-size: 20px; font-weight: 900; letter-spacing: 1px; }
  .header p { font-size: 11px; opacity: 0.7; margin-top: 4px; }
  .badge { background: #39A900; color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: bold; display: inline-block; margin-top: 6px; }
  .summary { display: flex; gap: 12px; margin-bottom: 20px; }
  .summary-card { flex: 1; padding: 12px; border-radius: 8px; text-align: center; }
  .summary-card.total { background: #f0f5ff; border: 1px solid #c6d4ff; }
  .summary-card.pass { background: #f0fdf4; border: 1px solid #86efac; }
  .summary-card.pending { background: #fffbeb; border: 1px solid #fcd34d; }
  .summary-card .num { font-size: 28px; font-weight: 900; }
  .summary-card .lbl { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
  .module-title { background: #f8fafc; border-left: 4px solid #000080; padding: 8px 14px; margin: 20px 0 10px; font-size: 13px; font-weight: 900; color: #000080; border-radius: 0 6px 6px 0; }
  .case { border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; overflow: hidden; page-break-inside: avoid; }
  .case-header { display: flex; align-items: center; gap: 10px; padding: 8px 14px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
  .case-id { background: #000080; color: white; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 900; }
  .case-title { font-size: 12px; font-weight: 800; flex: 1; }
  .prio-alta { background: #fef2f2; color: #dc2626; padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; }
  .prio-media { background: #fffbeb; color: #d97706; padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; }
  .status-pass { background: #dcfce7; color: #16a34a; padding: 2px 10px; border-radius: 4px; font-size: 10px; font-weight: 900; }
  .status-pending { background: #fef9c3; color: #ca8a04; padding: 2px 10px; border-radius: 4px; font-size: 10px; font-weight: 900; }
  table.detail { width: 100%; border-collapse: collapse; }
  table.detail td { padding: 5px 14px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
  table.detail td:first-child { width: 160px; font-weight: 700; color: #64748b; font-size: 10px; text-transform: uppercase; background: #fafafa; }
  table.detail tr:last-child td { border-bottom: none; }
  .obs { background: #f0f5ff; border: 1px solid #c6d4ff; border-radius: 8px; padding: 14px; margin-top: 20px; }
  .obs h3 { color: #000080; font-size: 12px; margin-bottom: 8px; }
  .obs li { margin-left: 16px; margin-bottom: 4px; line-height: 1.5; }
  .footer { text-align: center; margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 9px; }
  @media print { body { padding: 0; } .case { page-break-inside: avoid; } }
</style>
</head>
<body>

<div class="header">
  <div>
    <h1>DOCUMENTO DE CASOS DE PRUEBA</h1>
    <p>Sistema Digital de Gestión de Turnos — SENA APE</p>
    <span class="badge">v4.5.0 &nbsp;|&nbsp; 29/04/2026</span>
  </div>
</div>

<div class="summary">
  <div class="summary-card total"><div class="num" style="color:#000080">18</div><div class="lbl" style="color:#000080">Total Casos</div></div>
  <div class="summary-card pass"><div class="num" style="color:#16a34a">16</div><div class="lbl" style="color:#16a34a">✅ Pasan</div></div>
  <div class="summary-card pending"><div class="num" style="color:#ca8a04">2</div><div class="lbl" style="color:#ca8a04">⚠️ Pendientes</div></div>
</div>

<!-- MÓDULO 1 -->
<div class="module-title">MÓDULO 1 — Kiosco / Generación de Turnos</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-001</span><span class="case-title">Validación de Turno Duplicado en el Día</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Generación de Turnos</td></tr>
    <tr><td>Precondiciones</td><td>El ciudadano con doc 12345678 ya tiene un turno activo hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema no permita generar un segundo turno para el mismo ciudadano en el mismo día</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 12345678, tur_tipo: General</td></tr>
    <tr><td>Resultado Esperado</td><td>"Ya tienes un turno activo para hoy. Espera a ser atendido."</td></tr>
    <tr><td>Resultado Actual</td><td>Sistema retorna redirect con sesión error con el mensaje esperado</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-002</span><span class="case-title">Generación de Turno General</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Generación de Turnos</td></tr>
    <tr><td>Precondiciones</td><td>No existe turno activo para el documento ingresado hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema genere correctamente un turno de tipo General con prefijo G</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 99887766, pers_tipodoc: CC, tur_tipo: General</td></tr>
    <tr><td>Resultado Esperado</td><td>Turno generado con número G-001 (o correlativo), mensaje de éxito</td></tr>
    <tr><td>Resultado Actual</td><td>Turno creado con número G-XXX, sesión success con el número asignado</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-003</span><span class="case-title">Generación de Turno Prioritario</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Generación de Turnos</td></tr>
    <tr><td>Precondiciones</td><td>No existe turno activo para el documento ingresado hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema genere un turno Prioritario con prefijo P</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 11223344, tur_tipo: Prioritario</td></tr>
    <tr><td>Resultado Esperado</td><td>Turno generado con número P-XXX</td></tr>
    <tr><td>Resultado Actual</td><td>Turno creado con prefijo P y número correlativo del día</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-004</span><span class="case-title">Generación de Turno Víctima (Normalización)</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Generación de Turnos</td></tr>
    <tr><td>Precondiciones</td><td>No existe turno activo para el documento ingresado hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema normalice Victima → Victimas y genere prefijo V</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 55443322, tur_tipo: Victima</td></tr>
    <tr><td>Resultado Esperado</td><td>Turno generado con número V-XXX, tipo almacenado como Victimas</td></tr>
    <tr><td>Resultado Actual</td><td>Normalización aplicada correctamente, turno V-XXX creado</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-005</span><span class="case-title">Validación de Documento Requerido</span><span class="prio-media">MEDIA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Validación de Formulario</td></tr>
    <tr><td>Precondiciones</td><td>Ninguna</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema rechace el formulario si pers_doc está vacío</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: (vacío), tur_tipo: General</td></tr>
    <tr><td>Resultado Esperado</td><td>Error de validación 422, campo requerido</td></tr>
    <tr><td>Resultado Actual</td><td>Laravel retorna errores de validación, modal de error mostrado en kiosco</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-006</span><span class="case-title">Numeración Correlativa por Tipo</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Kiosco / Numeración</td></tr>
    <tr><td>Precondiciones</td><td>Ya existe 1 turno General hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que el segundo turno General del día sea G-002</td></tr>
    <tr><td>Datos de Entrada</td><td>Segundo ciudadano con tur_tipo: General</td></tr>
    <tr><td>Resultado Esperado</td><td>Turno G-002 generado</td></tr>
    <tr><td>Resultado Actual</td><td>Contador por tipo funciona correctamente con lockForUpdate()</td></tr>
  </table>
</div>

<!-- MÓDULO 2 -->
<div class="module-title">MÓDULO 2 — Asesor / Gestión de Atención</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-007</span><span class="case-title">Login Asesor con Credenciales Correctas</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Autenticación Asesor</td></tr>
    <tr><td>Precondiciones</td><td>Asesor registrado con doc 12345678 y contraseña sena2026</td></tr>
    <tr><td>Descripción</td><td>Verificar que el asesor pueda iniciar sesión con credenciales válidas</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 12345678, password: sena2026</td></tr>
    <tr><td>Resultado Esperado</td><td>Redirección a /asesor, sesión ase_id establecida</td></tr>
    <tr><td>Resultado Actual</td><td>Login exitoso, sesión creada con ase_id, ase_nombre, ase_foto</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-008</span><span class="case-title">Login Asesor con Credenciales Incorrectas</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Autenticación Asesor</td></tr>
    <tr><td>Precondiciones</td><td>Ninguna</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema rechace credenciales inválidas</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 12345678, password: claveincorrecta</td></tr>
    <tr><td>Resultado Esperado</td><td>"Credenciales incorrectas. Verifique su documento y contraseña."</td></tr>
    <tr><td>Resultado Actual</td><td>Redirect con sesión error y mensaje esperado</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-009</span><span class="case-title">Llamar Siguiente Turno — CU-02</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Asesor / Llamado de Turno</td></tr>
    <tr><td>Precondiciones</td><td>Asesor logueado tipo OT, existe turno General en espera</td></tr>
    <tr><td>Descripción</td><td>Verificar que el asesor OT llame el siguiente turno Prioritario/General en orden FIFO</td></tr>
    <tr><td>Datos de Entrada</td><td>POST /asesor/llamar con sesión activa</td></tr>
    <tr><td>Resultado Esperado</td><td>Atención creada, turno asignado, tur_hora_llamado registrado</td></tr>
    <tr><td>Resultado Actual</td><td>Transacción exitosa, registro en tabla atencion creado</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-010</span><span class="case-title">Bloqueo de Llamado en Pausa — CU-03</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Asesor / Receso</td></tr>
    <tr><td>Precondiciones</td><td>Asesor tiene pausa activa sin finalizar</td></tr>
    <tr><td>Descripción</td><td>Verificar que el sistema no asigne turnos a un asesor en receso</td></tr>
    <tr><td>Datos de Entrada</td><td>POST /asesor/llamar con pausa activa</td></tr>
    <tr><td>Resultado Esperado</td><td>Retorna null, mensaje: "No hay turnos disponibles"</td></tr>
    <tr><td>Resultado Actual</td><td>TurnoRepository::callNextTurn() retorna null si hay pausa activa</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-011</span><span class="case-title">Iniciar Receso con Atención Activa — CU-03</span><span class="prio-media">MEDIA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Asesor / Receso</td></tr>
    <tr><td>Precondiciones</td><td>Asesor tiene atención activa sin finalizar</td></tr>
    <tr><td>Descripción</td><td>Verificar que no se pueda iniciar receso con atención en curso</td></tr>
    <tr><td>Datos de Entrada</td><td>POST /asesor/receso/iniciar con atención activa</td></tr>
    <tr><td>Resultado Esperado</td><td>"No puedes iniciar un receso mientras tienes una atención activa"</td></tr>
    <tr><td>Resultado Actual</td><td>Repositorio retorna string de error, redirect con sesión error</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-012</span><span class="case-title">Finalizar Atención</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Asesor / Finalización</td></tr>
    <tr><td>Precondiciones</td><td>Existe atención activa con atnc_id válido</td></tr>
    <tr><td>Descripción</td><td>Verificar que al finalizar se registre atnc_hora_fin</td></tr>
    <tr><td>Datos de Entrada</td><td>POST /asesor/finalizar/{atnc_id}</td></tr>
    <tr><td>Resultado Esperado</td><td>atnc_hora_fin actualizado con timestamp actual</td></tr>
    <tr><td>Resultado Actual</td><td>Campo actualizado correctamente, redirect con mensaje de éxito</td></tr>
  </table>
</div>

<!-- MÓDULO 3 -->
<div class="module-title">MÓDULO 3 — Coordinador</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-013</span><span class="case-title">Login Coordinador con Credenciales Correctas</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Autenticación Coordinador</td></tr>
    <tr><td>Precondiciones</td><td>Coordinador registrado con email coordinador@sena.edu.co</td></tr>
    <tr><td>Descripción</td><td>Verificar login exitoso del coordinador</td></tr>
    <tr><td>Datos de Entrada</td><td>email: coordinador@sena.edu.co, password: sena2026</td></tr>
    <tr><td>Resultado Esperado</td><td>Redirección a /dashboard-coordinador, sesión coordinador_id establecida</td></tr>
    <tr><td>Resultado Actual</td><td>Login exitoso, sesión creada</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-014</span><span class="case-title">Registro de Nuevo Asesor</span><span class="prio-media">MEDIA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Coordinador / Gestión de Módulos</td></tr>
    <tr><td>Precondiciones</td><td>Coordinador logueado, documento no registrado previamente</td></tr>
    <tr><td>Descripción</td><td>Verificar que el coordinador pueda registrar un nuevo asesor</td></tr>
    <tr><td>Datos de Entrada</td><td>pers_doc: 87654321, ase_correo: nuevo@sena.edu.co, ase_password: test123</td></tr>
    <tr><td>Resultado Esperado</td><td>Asesor creado en BD, mensaje de éxito</td></tr>
    <tr><td>Resultado Actual</td><td>Persona y Asesor creados en transacción, contraseña hasheada con bcrypt</td></tr>
  </table>
</div>

<!-- MÓDULO 4 -->
<div class="module-title">MÓDULO 4 — Pantalla Pública / API</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-015</span><span class="case-title">API Datos de Pantalla</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>API / Pantalla Pública</td></tr>
    <tr><td>Precondiciones</td><td>Ninguna</td></tr>
    <tr><td>Descripción</td><td>Verificar que el endpoint /api/pantalla/data retorne estructura correcta</td></tr>
    <tr><td>Datos de Entrada</td><td>GET /api/pantalla/data</td></tr>
    <tr><td>Resultado Esperado</td><td>JSON con success, turnoActual, turnosEnEspera, timestamp</td></tr>
    <tr><td>Resultado Actual</td><td>Respuesta JSON con estructura esperada</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-016</span><span class="case-title">API Último Turno Generado</span><span class="prio-media">MEDIA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>API / Kiosco → Pantalla</td></tr>
    <tr><td>Precondiciones</td><td>Al menos un turno generado hoy</td></tr>
    <tr><td>Descripción</td><td>Verificar que /api/pantalla/ultimo-turno retorne el turno más reciente</td></tr>
    <tr><td>Datos de Entrada</td><td>GET /api/pantalla/ultimo-turno</td></tr>
    <tr><td>Resultado Esperado</td><td>JSON con tur_id, tur_numero, tur_perfil, tur_hora del último turno</td></tr>
    <tr><td>Resultado Actual</td><td>Retorna el turno con mayor tur_id del día actual</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-017</span><span class="case-title">Prioridad de Atención OT vs OV — CU-02</span><span class="prio-alta">ALTA</span><span class="status-pass">✅ PASA</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Repositorio / Lógica de Negocio</td></tr>
    <tr><td>Precondiciones</td><td>Existen turnos General, Prioritario y Víctima en espera</td></tr>
    <tr><td>Descripción</td><td>Verificar que asesor OT atienda Prioritario antes que General, y OV atienda Víctima antes que Empresario</td></tr>
    <tr><td>Datos de Entrada</td><td>callNextTurn() con asesor tipo OT y tipo OV</td></tr>
    <tr><td>Resultado Esperado</td><td>OT → Prioritario primero; OV → Víctima primero</td></tr>
    <tr><td>Resultado Actual</td><td>Orden de prioridad aplicado con orderByRaw CASE WHEN</td></tr>
  </table>
</div>

<div class="case">
  <div class="case-header"><span class="case-id">CP-018</span><span class="case-title">Supervisión Módulos 15 y 19 — CU-04</span><span class="prio-media">MEDIA</span><span class="status-pending">⚠️ PENDIENTE</span></div>
  <table class="detail">
    <tr><td>Módulo</td><td>Coordinador / Supervisión</td></tr>
    <tr><td>Precondiciones</td><td>Coordinador logueado, asesores con ID 15 y 19 registrados en BD</td></tr>
    <tr><td>Descripción</td><td>Verificar que la vista de supervisión muestre estado de módulos 15 y 19</td></tr>
    <tr><td>Datos de Entrada</td><td>GET /coordinador/supervision</td></tr>
    <tr><td>Resultado Esperado</td><td>Vista con estado de módulos, meta semanal de emprendedores, alertas de espera mayor a 20 min</td></tr>
    <tr><td>Resultado Actual</td><td>Vista renderizada pero módulos 15 y 19 no existen en BD de prueba</td></tr>
  </table>
</div>

<div class="obs">
  <h3>⚠️ Observaciones Generales</h3>
  <ul>
    <li><strong>Throttle Kiosco:</strong> La ruta /turno/solicitar tiene middleware throttle:kiosk. Verificar configuración en config/app.php para entornos de producción.</li>
    <li><strong>Módulos 15 y 19:</strong> CP-018 requiere que existan asesores con ase_id = 15 y ase_id = 19 en la BD para prueba completa.</li>
    <li><strong>Audio Pantalla:</strong> La voz (SpeechSynthesis) requiere interacción previa del usuario en el navegador. El chime (Web Audio API) funciona sin interacción.</li>
    <li><strong>Encoding BD:</strong> La base de datos "ape sena" (con espacio) puede causar problemas en algunos entornos. Recomendado renombrar a ape_sena.</li>
  </ul>
</div>

<div class="footer">
  Documento generado automáticamente — Sistema DigiTurno APE SENA v4.5.0 &nbsp;|&nbsp; 29/04/2026
</div>

</body>
</html>

