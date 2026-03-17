<x-layout title="Ejercicio 7 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">7. Control de asistencia</h1>

    <p class="text-text-muted mb-8">El programa calcula el porcentaje de asistencia, identifica asistencias insuficientes (< 75%) y el promedio del curso.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        $estudiantes = [
          1 => "Ana Rojas",
          2 => "Luis Mercado",
          3 => "María López",
          4 => "Carlos Pinto"
        ];

        // Estado actual desde la URL
        $total_clases = isset($_GET['clases']) ? (int)$_GET['clases'] : 0;
        $asistencias_str = $_GET['asistencias'] ?? '';
        $lista_asistencias = $asistencias_str ? explode(',', $asistencias_str) : [];

        // Registrar nueva clase
        if (isset($_GET['nueva_clase'])) {
            $total_clases++;
        }

        // Registrar asistencia de un estudiante
        if (isset($_GET['id_estudiante']) && isset($estudiantes[$_GET['id_estudiante']])) {
            $lista_asistencias[] = $_GET['id_estudiante'];
            $asistencias_str = implode(',', $lista_asistencias);
        }

        // Cálculos
        $conteo_asistencias = array_count_values($lista_asistencias);
        $suma_porcentajes = 0;
        $total_estudiantes = count($estudiantes);
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- LISTA DE ESTUDIANTES ---</p>
        <div class="pl-4 mb-6">
          @php
            foreach ($estudiantes as $id => $nombre) {
              echo "<span class='text-accent-main'>[$id]</span> $nombre <br>";
            }
          @endphp
        </div>

        <style>
          input[type="number"]::-webkit-inner-spin-button,
          input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
          input[type="number"] { -moz-appearance: textfield; }
        </style>

        <div class="flex flex-col gap-4 mb-8">
            <form method="GET" action="" class="flex items-center gap-4">
                <input type="hidden" name="clases" value="{{ $total_clases }}">
                <input type="hidden" name="asistencias" value="{{ $asistencias_str }}">
                <button type="submit" name="nueva_clase" value="1" class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
                    + Registrar Nueva Clase Impartida
                </button>
                <span class="text-text-muted">(Total actuales: {{ $total_clases }})</span>
            </form>

            <form method="GET" action="" class="flex items-center gap-4">
                <input type="hidden" name="clases" value="{{ $total_clases }}">
                <input type="hidden" name="asistencias" value="{{ $asistencias_str }}">
                <label for="id_estudiante" class="text-text-arena">> ID del estudiante que asistió:</label>
                <input type="number" name="id_estudiante" required class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-20 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
                <button type="submit" class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
                    Marcar Asistencia
                </button>
            </form>
        </div>

        <p class="mb-4 text-text-muted">--- REPORTE DE ASISTENCIA ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @php
            if ($total_clases > 0) {
              foreach ($estudiantes as $id => $nombre) {
                  $asistidas = $conteo_asistencias[$id] ?? 0;
                  // Evitar que tengan más asistencias que clases
                  if($asistidas > $total_clases) $asistidas = $total_clases; 
                  
                  $porcentaje = round(($asistidas / $total_clases) * 100);
                  $suma_porcentajes += $porcentaje;
                  $estado = $porcentaje < 75 ? "<span class='text-red-500'>[INSUFICIENTE]</span>" : "<span class='text-green-500'>[AL DÍA]</span>";
                  
                  echo "<p class='mb-1'>- $nombre: $asistidas/$total_clases ($porcentaje%) $estado</p>";
              }
              $promedio_curso = round($suma_porcentajes / $total_estudiantes);
              echo "<hr class='my-2 border-base-borde'>";
              echo "<p class='font-bold text-accent-main'>Promedio general del curso: $promedio_curso%</p>";
            } else {
              echo "<p class='text-text-muted italic'>No hay clases registradas aún...</p>";
            }
          @endphp
        </div>
      </div>
    </div>

    <div class="mt-8">
      <a href="{{ url('/a2') }}" class="text-accent-main hover:text-accent-hover transition-colors font-medium"> &larr; Volver al listado de Actividad 2 </a>
    </div>
  </div>
</x-layout>