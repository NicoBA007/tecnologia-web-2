<x-layout title="Ejercicio 11 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">Ejercicio 11</h1>
    <p class="text-text-muted mb-8">Una institución registra las notas de los estudiantes en varias materias.
El sistema debe calcular el promedio por materia, determinar qué materia tiene el promedio
más alto y cuántos estudiantes aprobaron cada materia.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      <style>
        /* Estilos para quitar las flechas del input numérico */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }

        input[type="number"] {
          -moz-appearance: textfield;
        }
      </style>

      @php
        // 1. Definimos las materias disponibles y la nota mínima para aprobar
        $materias = [
          1 => "Matemáticas",
          2 => "Física",
          3 => "Programación Web",
          4 => "Bases de Datos"
        ];
        $nota_minima_aprobacion = 51;

        // 2. Recuperamos el historial de la URL. Formato esperado: "1:85,2:40,1:90" (MateriaID:Nota)
        $historial_str = $_GET['historial'] ?? '';
        $lista_registros = $historial_str ? explode(',', $historial_str) : [];

        // 3. Verificamos si el usuario envió un nuevo registro válido
        if (isset($_GET['materia_id']) && isset($_GET['nota'])) {
          $m_id = $_GET['materia_id'];
          $nota = (int) $_GET['nota'];

          // Validamos que la materia exista y la nota esté entre 0 y 100
          if (isset($materias[$m_id]) && $nota >= 0 && $nota <= 100) {
            $lista_registros[] = $m_id . ':' . $nota;
            $historial_str = implode(',', $lista_registros); // Actualizamos el historial
          }
        }

        // 4. Preparamos un arreglo para agrupar los datos procesados por materia
        $datos_procesados = [];
        foreach ($materias as $id => $nombre) {
          // Inicializamos los contadores en cero para cada materia
          $datos_procesados[$nombre] = [
            'suma_notas' => 0,
            'cantidad_notas' => 0,
            'aprobados' => 0,
            'promedio' => 0
          ];
        }

        // 5. Procesamos el historial para hacer los cálculos
        $total_registros_generales = 0;

        foreach ($lista_registros as $registro) {
          // Separamos el ID de la materia y la nota (ej: de "1:85" sacamos 1 y 85)
          list($id_materia, $nota_estudiante) = explode(':', $registro);
          $nombre_mat = $materias[$id_materia];

          // Aumentamos los contadores
          $datos_procesados[$nombre_mat]['suma_notas'] += $nota_estudiante;
          $datos_procesados[$nombre_mat]['cantidad_notas']++;
          $total_registros_generales++;

          // Condicional para verificar si aprobó
          if ($nota_estudiante >= $nota_minima_aprobacion) {
            $datos_procesados[$nombre_mat]['aprobados']++;
          }
        }

        // 6. Calcular promedios y encontrar la materia con el mejor promedio
        $materia_mejor_promedio = "Ninguna";
        $max_promedio = -1; // Iniciamos en -1 para que cualquier nota lo supere

        foreach ($datos_procesados as $nombre => $datos) {
          if ($datos['cantidad_notas'] > 0) {
            // Calculamos el promedio: Suma total / cantidad de alumnos
            $promedio = $datos['suma_notas'] / $datos['cantidad_notas'];
            $datos_procesados[$nombre]['promedio'] = $promedio;

            // Verificamos si este promedio es el más alto hasta ahora
            if ($promedio > $max_promedio) {
              $max_promedio = $promedio;
              $materia_mejor_promedio = $nombre;
            }
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- REGISTRO DE NOTAS ---</p>
        <form method="GET" action="" class="flex items-center gap-4 mb-8 flex-wrap">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label for="materia_id" class="text-text-arena">> Materia:</label>
          <select name="materia_id" id="materia_id" required
            class="bg-transparent border border-base-borde rounded px-2 py-1 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            @php
              foreach ($materias as $id => $nombre) {
                echo "<option value='$id' style='background-color: #1a1a1a;'>$nombre</option>";
              }
            @endphp
          </select>

          <label for="nota" class="text-text-arena">> Nota (0-100):</label>
          <input type="number" name="nota" id="nota" required min="0" max="100" autofocus
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-20 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Guardar Nota
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- REPORTE ACADÉMICO ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @php
            if ($total_registros_generales > 0) {
              echo "<p class='mb-2'>Total de notas registradas en el sistema: <span class='text-accent-main font-bold'>$total_registros_generales</span></p>";

              // Formateamos el promedio a 2 decimales para que se vea más limpio
              $promedio_formateado = number_format($max_promedio, 2);
              echo "<p class='mb-4'>Materia con el promedio más alto: <span class='text-accent-main font-bold'>$materia_mejor_promedio</span> ($promedio_formateado)</p>";

              echo "<p class='text-text-muted mb-2'>Detalle por materia:</p>";

              // Imprimimos los resultados usando un ciclo
              foreach ($datos_procesados as $nombre => $datos) {
                if ($datos['cantidad_notas'] > 0) {
                  $prom_mat = number_format($datos['promedio'], 2);
                  echo "<div class='pl-2 mb-2 border-l-2 border-base-borde pb-1'>";
                  echo "<p class='text-accent-main'>[ $nombre ]</p>";
                  echo "<p class='pl-4'>- Promedio: $prom_mat</p>";
                  echo "<p class='pl-4'>- Estudiantes aprobados: " . $datos['aprobados'] . " de " . $datos['cantidad_notas'] . "</p>";
                  echo "</div>";
                } else {
                  echo "<div class='pl-2 mb-2 border-l-2 border-base-borde pb-1'>";
                  echo "<p class='text-accent-main'>[ $nombre ]</p>";
                  echo "<p class='pl-4 text-text-muted italic'>Sin registros aún.</p>";
                  echo "</div>";
                }
              }
            } else {
              echo "<p class='text-text-muted italic'>Esperando el registro de la primera nota...</p>";
            }
          @endphp
        </div>
      </div>
    </div>

    <div class="mt-8">
      <a href="{{ url('/a2') }}" class="text-accent-main hover:text-accent-hover transition-colors font-medium"> &larr;
        Volver al listado de Actividad 2 </a>
    </div>
  </div>
</x-layout>