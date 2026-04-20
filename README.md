# 🚦 DigiTurno APE - SENA

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) 
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white) 
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white) 
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

Sistema Digital de Turnos (DigiTurno) desarrollado para la **Agencia Pública de Empleo (APE) del SENA**. Este software profesional facilita la asignación, monitoreo y gestión de citas de atención al ciudadano en tiempo real, priorizando el enfoque diferencial.

---

## ✨ Características Principales

*   **Punto de Autogestión (Kiosco):** Interfaz táctil y minimalista donde los ciudadanos pueden registrar su documento y seleccionar el tipo de servicio.
*   **Enfoque Diferencial (Prioridad Automática):** 
    1.  Atención a Víctimas (Prioridad Máxima - Etiqueta `A`)
    2.  Atención Prioritaria (Etiqueta `B`)
    3.  Atención General (Etiqueta `C`)
*   **Pantalla Pública en Tiempo Real:** Interfaz en vivo con llamadas por síntesis de voz (Web Audio API) y alertas visuales automáticas utilizando *polling asíncrono* sin sobrecargar el servidor.
*   **Panel de Asesor:** Sistema de *caja* (módulos) con protección de concurrencia y bloqueos transaccionales para que dos asesores no puedan llamar al mismo turno.
*   **Dashboard Gerencial (Coordinador):** Tablero de control con métricas exactas: turnos atendidos, tiempos de espera, saturación por sede y alertas predictivas automatizadas.
*   **Arquitectura Limpia:** Estructura basada en los patrones MVC y Repositorios (`TurnoRepository`) de Laravel para alta escalabilidad y mantenibilidad.

---

## 🏗 Arquitectura y Estructura

El sistema se diseñó bajo los estándares de desarrollo de **Laravel 11+**, agrupando el código en módulos semánticos:

```text
resources/views/
├── asesor/          # Vistas privadas (Panel de atención, manual)
├── coordinador/     # Dashboard en tiempo real, configuración, reportes
├── kiosco/          # Interfaz pública táctil (Punto de acceso)
├── layouts/         # Plantillas globales maestras
└── pantalla/        # Display público de llamados (Web/TV)
```

Las bases de datos y scripts de prueba se encuentran ubicados en `database/sql/`.

---

## 🚀 Requisitos e Instalación

### Requisitos Previos
*   PHP ^8.1
*   Composer
*   MySQL o MariaDB
*   Servidor Web (Apache/Nginx o Laravel Valet/Sail)

### Pasos de Instalación

1.  **Clonar este repositorio:**
    ```bash
    git clone https://github.com/chaustrexp/ape-sena-DigiTurno.git
    cd ape-sena-DigiTurno
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Configurar Variables de Entorno:**
    Duplicar el archivo `.env.example` y nombrarlo `.env`. Luego, configurar las credenciales de base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4.  **Generar la clave de la aplicación:**
    ```bash
    php artisan key:generate
    ```

5.  **Correr el Servidor de Pruebas:**
    ```bash
    php artisan serve
    ```

El kiosco público se ejecutará de forma predeterminada en `http://localhost:8000/`.

---

## 🔒 Control de Concurrencia

Este proyecto implementa tecnología **Pessimistic Locking** (`lockForUpdate()`) a nivel de base de datos. Esto asegura que en escenarios de alto tráfico, la base de datos se vuelva estrictamente ACID para la asginación de turnos, y en el caso de llamados, garantice que diferentes módulos (asesores) no llamen a un ciudadano duplicado o rompan el esquema *FIFO*.

---

## 📝 Documentación
Este sistema cuenta con documentación estática autogenerada ubicada internamente para los administradores que deseen revisar las API expuestas o el manual avanzado de consultas SQL.

---

> Desarrollado bajo las guías de usabilidad visual de Identidad Digital del **SENA**. Uso exclusivo institucional.
