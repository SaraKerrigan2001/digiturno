 # ðŸ“‹ Documento de Casos de Prueba â€” Sistema DigiTurno SENA APE

**Proyecto:** Sistema Digital de GestiÃ³n de Turnos â€” SENA APE  
**VersiÃ³n:** 4.5.0  
**Fecha:** 29/04/2026  
**Responsable:** Equipo de Desarrollo APE SENA  

---

## Resumen de Resultados

| Total Casos | âœ… Pasan | âŒ Fallan | âš ï¸ Pendiente |
|-------------|---------|---------|------------|
| 18 | 16 | 0 | 2 |

---

## MÃ“DULO 1 â€” Kiosco (GeneraciÃ³n de Turnos)

---

### CP-001 â€” ValidaciÃ³n de Turno Duplicado en el DÃ­a
| Campo | Detalle |
|-------|---------|
| **ID** | CP-001 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Kiosco / GeneraciÃ³n de Turnos |
| **Precondiciones** | El ciudadano con doc `12345678` ya tiene un turno activo hoy |
| **DescripciÃ³n** | Verificar que el sistema no permita generar un segundo turno para el mismo ciudadano en el mismo dÃ­a |
| **Datos de Entrada** | `pers_doc: 12345678`, `tur_tipo: General` |
| **Resultado Esperado** | Mensaje: *"Ya tienes un turno activo para hoy. Espera a ser atendido."* |
| **Resultado Actual** | Sistema retorna redirect con sesiÃ³n `error` con el mensaje esperado |
| **Estado** | âœ… **PASA** |

---

### CP-002 â€” GeneraciÃ³n de Turno General
| Campo | Detalle |
|-------|---------|
| **ID** | CP-002 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Kiosco / GeneraciÃ³n de Turnos |
| **Precondiciones** | No existe turno activo para el documento ingresado hoy |
| **DescripciÃ³n** | Verificar que el sistema genere correctamente un turno de tipo General con prefijo G |
| **Datos de Entrada** | `pers_doc: 99887766`, `pers_tipodoc: CC`, `tur_tipo: General` |
| **Resultado Esperado** | Turno generado con nÃºmero `G-001` (o correlativo), mensaje de Ã©xito |
| **Resultado Actual** | Turno creado con nÃºmero `G-XXX`, sesiÃ³n `success` con el nÃºmero asignado |
| **Estado** | âœ… **PASA** |

---

### CP-003 â€” GeneraciÃ³n de Turno Prioritario
| Campo | Detalle |
|-------|---------|
| **ID** | CP-003 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Kiosco / GeneraciÃ³n de Turnos |
| **Precondiciones** | No existe turno activo para el documento ingresado hoy |
| **DescripciÃ³n** | Verificar que el sistema genere un turno Prioritario con prefijo P |
| **Datos de Entrada** | `pers_doc: 11223344`, `tur_tipo: Prioritario` |
| **Resultado Esperado** | Turno generado con nÃºmero `P-XXX` |
| **Resultado Actual** | Turno creado con prefijo `P` y nÃºmero correlativo del dÃ­a |
| **Estado** | âœ… **PASA** |

---

### CP-004 â€” GeneraciÃ³n de Turno VÃ­ctima
| Campo | Detalle |
|-------|---------|
| **ID** | CP-004 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Kiosco / GeneraciÃ³n de Turnos |
| **Precondiciones** | No existe turno activo para el documento ingresado hoy |
| **DescripciÃ³n** | Verificar que el sistema normalice `Victima` â†’ `Victimas` y genere prefijo V |
| **Datos de Entrada** | `pers_doc: 55443322`, `tur_tipo: Victima` |
| **Resultado Esperado** | Turno generado con nÃºmero `V-XXX`, tipo almacenado como `Victimas` |
| **Resultado Actual** | NormalizaciÃ³n aplicada correctamente, turno `V-XXX` creado |
| **Estado** | âœ… **PASA** |

---

### CP-005 â€” ValidaciÃ³n de Documento Requerido
| Campo | Detalle |
|-------|---------|
| **ID** | CP-005 |
| **Prioridad** | Media |
| **MÃ³dulo** | Kiosco / ValidaciÃ³n de Formulario |
| **Precondiciones** | Ninguna |
| **DescripciÃ³n** | Verificar que el sistema rechace el formulario si `pers_doc` estÃ¡ vacÃ­o |
| **Datos de Entrada** | `pers_doc: (vacÃ­o)`, `tur_tipo: General` |
| **Resultado Esperado** | Error de validaciÃ³n 422, campo requerido |
| **Resultado Actual** | Laravel retorna errores de validaciÃ³n, modal de error mostrado en kiosco |
| **Estado** | âœ… **PASA** |

---

### CP-006 â€” NumeraciÃ³n Correlativa por Tipo
| Campo | Detalle |
|-------|---------|
| **ID** | CP-006 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Kiosco / NumeraciÃ³n |
| **Precondiciones** | Ya existe 1 turno General hoy |
| **DescripciÃ³n** | Verificar que el segundo turno General del dÃ­a sea G-002 |
| **Datos de Entrada** | Segundo ciudadano con `tur_tipo: General` |
| **Resultado Esperado** | Turno `G-002` generado |
| **Resultado Actual** | Contador por tipo funciona correctamente con `lockForUpdate()` |
| **Estado** | âœ… **PASA** |

---

## MÃ“DULO 2 â€” Asesor (GestiÃ³n de AtenciÃ³n)

---

### CP-007 â€” Login Asesor con Credenciales Correctas
| Campo | Detalle |
|-------|---------|
| **ID** | CP-007 |
| **Prioridad** | Alta |
| **MÃ³dulo** | AutenticaciÃ³n Asesor |
| **Precondiciones** | Asesor registrado con doc `12345678` y contraseÃ±a `sena2026` |
| **DescripciÃ³n** | Verificar que el asesor pueda iniciar sesiÃ³n con credenciales vÃ¡lidas |
| **Datos de Entrada** | `pers_doc: 12345678`, `password: sena2026` |
| **Resultado Esperado** | RedirecciÃ³n a `/asesor`, sesiÃ³n `ase_id` establecida |
| **Resultado Actual** | Login exitoso, sesiÃ³n creada con `ase_id`, `ase_nombre`, `ase_foto` |
| **Estado** | âœ… **PASA** |

---

### CP-008 â€” Login Asesor con Credenciales Incorrectas
| Campo | Detalle |
|-------|---------|
| **ID** | CP-008 |
| **Prioridad** | Alta |
| **MÃ³dulo** | AutenticaciÃ³n Asesor |
| **Precondiciones** | Ninguna |
| **DescripciÃ³n** | Verificar que el sistema rechace credenciales invÃ¡lidas |
| **Datos de Entrada** | `pers_doc: 12345678`, `password: claveincorrecta` |
| **Resultado Esperado** | Mensaje: *"Credenciales incorrectas. Verifique su documento y contraseÃ±a."* |
| **Resultado Actual** | Redirect con sesiÃ³n `error` y mensaje esperado |
| **Estado** | âœ… **PASA** |

---

### CP-009 â€” Llamar Siguiente Turno (CU-02)
| Campo | Detalle |
|-------|---------|
| **ID** | CP-009 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Asesor / Llamado de Turno |
| **Precondiciones** | Asesor logueado tipo OT, existe turno General en espera |
| **DescripciÃ³n** | Verificar que el asesor OT llame el siguiente turno Prioritario/General en orden FIFO |
| **Datos de Entrada** | POST `/asesor/llamar` con sesiÃ³n activa |
| **Resultado Esperado** | AtenciÃ³n creada, turno asignado al asesor, `tur_hora_llamado` registrado |
| **Resultado Actual** | TransacciÃ³n exitosa, registro en tabla `atencion` creado |
| **Estado** | âœ… **PASA** |

---

### CP-010 â€” Bloqueo de Llamado en Pausa (CU-03)
| Campo | Detalle |
|-------|---------|
| **ID** | CP-010 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Asesor / Receso |
| **Precondiciones** | Asesor tiene pausa activa sin finalizar |
| **DescripciÃ³n** | Verificar que el sistema no asigne turnos a un asesor en receso |
| **Datos de Entrada** | POST `/asesor/llamar` con pausa activa |
| **Resultado Esperado** | Retorna `null`, mensaje: *"No hay turnos disponibles"* |
| **Resultado Actual** | `TurnoRepository::callNextTurn()` retorna `null` si hay pausa activa |
| **Estado** | âœ… **PASA** |

---

### CP-011 â€” Iniciar Receso con AtenciÃ³n Activa
| Campo | Detalle |
|-------|---------|
| **ID** | CP-011 |
| **Prioridad** | Media |
| **MÃ³dulo** | Asesor / Receso (CU-03) |
| **Precondiciones** | Asesor tiene atenciÃ³n activa sin finalizar |
| **DescripciÃ³n** | Verificar que no se pueda iniciar receso con atenciÃ³n en curso |
| **Datos de Entrada** | POST `/asesor/receso/iniciar` con atenciÃ³n activa |
| **Resultado Esperado** | Mensaje: *"No puedes iniciar un receso mientras tienes una atenciÃ³n activa"* |
| **Resultado Actual** | Repositorio retorna string de error, redirect con sesiÃ³n `error` |
| **Estado** | âœ… **PASA** |

---

### CP-012 â€” Finalizar AtenciÃ³n
| Campo | Detalle |
|-------|---------|
| **ID** | CP-012 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Asesor / FinalizaciÃ³n |
| **Precondiciones** | Existe atenciÃ³n activa con `atnc_id` vÃ¡lido |
| **DescripciÃ³n** | Verificar que al finalizar se registre `atnc_hora_fin` |
| **Datos de Entrada** | POST `/asesor/finalizar/{atnc_id}` |
| **Resultado Esperado** | `atnc_hora_fin` actualizado con timestamp actual |
| **Resultado Actual** | Campo actualizado correctamente, redirect con mensaje de Ã©xito |
| **Estado** | âœ… **PASA** |

---

## MÃ“DULO 3 â€” Coordinador

---

### CP-013 â€” Login Coordinador con Credenciales Correctas
| Campo | Detalle |
|-------|---------|
| **ID** | CP-013 |
| **Prioridad** | Alta |
| **MÃ³dulo** | AutenticaciÃ³n Coordinador |
| **Precondiciones** | Coordinador registrado con email `coordinador@sena.edu.co` |
| **DescripciÃ³n** | Verificar login exitoso del coordinador |
| **Datos de Entrada** | `email: coordinador@sena.edu.co`, `password: sena2026` |
| **Resultado Esperado** | RedirecciÃ³n a `/dashboard-coordinador`, sesiÃ³n `coordinador_id` establecida |
| **Resultado Actual** | Login exitoso, sesiÃ³n creada |
| **Estado** | âœ… **PASA** |

---

### CP-014 â€” Registro de Nuevo Asesor
| Campo | Detalle |
|-------|---------|
| **ID** | CP-014 |
| **Prioridad** | Media |
| **MÃ³dulo** | Coordinador / GestiÃ³n de MÃ³dulos |
| **Precondiciones** | Coordinador logueado, documento no registrado previamente |
| **DescripciÃ³n** | Verificar que el coordinador pueda registrar un nuevo asesor |
| **Datos de Entrada** | `pers_doc: 87654321`, `ase_correo: nuevo@sena.edu.co`, `ase_password: test123` |
| **Resultado Esperado** | Asesor creado en BD, mensaje de Ã©xito |
| **Resultado Actual** | Persona y Asesor creados en transacciÃ³n, contraseÃ±a hasheada con bcrypt |
| **Estado** | âœ… **PASA** |

---

## MÃ“DULO 4 â€” Pantalla PÃºblica / API

---

### CP-015 â€” API Datos de Pantalla
| Campo | Detalle |
|-------|---------|
| **ID** | CP-015 |
| **Prioridad** | Alta |
| **MÃ³dulo** | API / Pantalla PÃºblica |
| **Precondiciones** | Ninguna |
| **DescripciÃ³n** | Verificar que el endpoint `/api/pantalla/data` retorne estructura correcta |
| **Datos de Entrada** | GET `/api/pantalla/data` |
| **Resultado Esperado** | JSON con `success`, `turnoActual`, `turnosEnEspera`, `timestamp` |
| **Resultado Actual** | Respuesta JSON con estructura esperada |
| **Estado** | âœ… **PASA** |

---

### CP-016 â€” API Ãšltimo Turno Generado
| Campo | Detalle |
|-------|---------|
| **ID** | CP-016 |
| **Prioridad** | Media |
| **MÃ³dulo** | API / Kiosco â†’ Pantalla |
| **Precondiciones** | Al menos un turno generado hoy |
| **DescripciÃ³n** | Verificar que `/api/pantalla/ultimo-turno` retorne el turno mÃ¡s reciente |
| **Datos de Entrada** | GET `/api/pantalla/ultimo-turno` |
| **Resultado Esperado** | JSON con `tur_id`, `tur_numero`, `tur_perfil`, `tur_hora` del Ãºltimo turno |
| **Resultado Actual** | Retorna el turno con mayor `tur_id` del dÃ­a actual |
| **Estado** | âœ… **PASA** |

---

### CP-017 â€” Prioridad de AtenciÃ³n OT vs OV (CU-02)
| Campo | Detalle |
|-------|---------|
| **ID** | CP-017 |
| **Prioridad** | Alta |
| **MÃ³dulo** | Repositorio / LÃ³gica de Negocio |
| **Precondiciones** | Existen turnos General, Prioritario y VÃ­ctima en espera |
| **DescripciÃ³n** | Verificar que asesor OT atienda Prioritario antes que General, y OV atienda VÃ­ctima antes que Empresario |
| **Datos de Entrada** | `callNextTurn()` con asesor tipo OT y tipo OV |
| **Resultado Esperado** | OT â†’ Prioritario primero; OV â†’ VÃ­ctima primero |
| **Resultado Actual** | Orden de prioridad aplicado con `orderByRaw CASE WHEN` |
| **Estado** | âœ… **PASA** |

---

### CP-018 â€” SupervisiÃ³n MÃ³dulos 15 y 19 (CU-04)
| Campo | Detalle |
|-------|---------|
| **ID** | CP-018 |
| **Prioridad** | Media |
| **MÃ³dulo** | Coordinador / SupervisiÃ³n |
| **Precondiciones** | Coordinador logueado |
| **DescripciÃ³n** | Verificar que la vista de supervisiÃ³n muestre estado de mÃ³dulos 15 y 19 |
| **Datos de Entrada** | GET `/coordinador/supervision` |
| **Resultado Esperado** | Vista con estado de mÃ³dulos, meta semanal de emprendedores, alertas de espera >20 min |
| **Resultado Actual** | Vista renderizada con datos de mÃ³dulos vigilancia y KPIs |
| **Estado** | âš ï¸ **PENDIENTE** â€” Requiere mÃ³dulos 15 y 19 registrados en BD |

---

## Observaciones Generales

1. **Throttle Kiosco** â€” La ruta `/turno/solicitar` tiene middleware `throttle:kiosk`. Verificar configuraciÃ³n en `config/app.php` para entornos de producciÃ³n.
2. **MÃ³dulos 15 y 19** â€” CP-018 requiere que existan asesores con `ase_id = 15` y `ase_id = 19` en la BD para prueba completa.
3. **Audio Pantalla** â€” La voz (`SpeechSynthesis`) requiere interacciÃ³n previa del usuario en el navegador. El chime (Web Audio API) funciona sin interacciÃ³n.
4. **Encoding BD** â€” La base de datos `ape sena` (con espacio) puede causar problemas en algunos entornos. Recomendado renombrar a `ape_sena`.

---

*Documento generado automÃ¡ticamente â€” Sistema DigiTurno APE SENA v4.5.0*

