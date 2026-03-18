<x-layout title="Ejercicio 8 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">8. Análisis de temperaturas</h1>

    <p class="text-text-muted mb-8">El sistema analiza las temperaturas, calcula promedios por ciudad, determina la
      temperatura máxima registrada y detecta posibles valores extremos.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Definimos las ciudades (puedes agregar más si quieres)
        $ciudades = [
          1 => "Cochabamba",
          2 => "La Paz",
          3 => "Santa Cruz"
        ];

        // 2. Recuperamos y limpiamos el historial de la URL de forma segura
        $historial_str = $_GET['historial'] ?? '';
        $registros = $historial_str ? array_filter(explode(',', $historial_str)) : [];

        // 3. Registrar una nueva lectura si se envió el formulario
        if (isset($_GET['ciudad']) && isset($_GET['temp']) && isset($ciudades[$_GET['ciudad']])) {
          $nueva_temp = floatval($_GET['temp']); // Permite decimales
          $registros[] = $_GET['ciudad'] . ':' . $nueva_temp;
          $historial_str = implode(',', $registros);
        }

        // 4. Variables para nuestro análisis
        $datos_por_ciudad = [];
        $temp_maxima = -999; // Empezamos muy bajo para que cualquier lectura lo supere
        $valores_extremos = [];

        // 5. Lógica de procesamiento de todos los registros
        foreach ($registros as $registro) {
          $partes = explode(':', $registro);

          // Validación: Si el registro está corrupto o incompleto, lo saltamos
          if (count($partes) !== 2) {
            continue;
          }

          $id_ciudad = $partes[0];
          $temp = floatval($partes[1]);

          // Validación: Si la ciudad no existe en nuestra lista, la saltamos
          if (!isset($ciudades[$id_ciudad])) {
            continue;
          }

          $nombre = $ciudades[$id_ciudad];

          // Agrupar temperaturas por ciudad para sacar el promedio después
          if (!isset($datos_por_ciudad[$nombre])) {
            $datos_por_ciudad[$nombre] = [];
          }
          $datos_por_ciudad[$nombre][] = $temp;

          // Determinar la temperatura máxima registrada
          if ($temp > $temp_maxima) {
            $temp_maxima = $temp;
          }

          // Detectar valores extremos (consideramos extremo < 0°C o > 35°C)
          if ($temp < 0 || $temp > 35) {
            // Aquí usamos {$temp} con llaves para evitar el error de variable indefinida
            $valores_extremos[] = "{$temp}°C en $nombre";
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- ESTACIONES DISPONIBLES ---</p>
        <div class="pl-4 mb-6 flex gap-4">
          @php
            foreach ($ciudades as $id => $nombre) {
              echo "<span><span class='text-accent-main'>[$id]</span> $nombre</span>";
            }
          @endphp
        </div>

        <style>
          input[type="number"]::-webkit-inner-spin-button,
          input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
          }

          input[type="number"] {
            -moz-appearance: textfield;
          }
        </style>

        <form method="GET" action="" class="flex items-center gap-4 mb-8">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label class="text-text-arena">> Estación:</label>
          <select name="ciudad"
            class="bg-base-superficie border border-base-borde rounded px-2 py-1 text-text-arena focus:outline-none focus:border-accent-main">
            @foreach($ciudades as $id => $nombre)
              <option value="{{ $id }}">{{ $nombre }}</option>
            @endforeach
          </select>

          <label class="text-text-arena">> Temp (°C):</label>
          <input type="number" step="0.1" name="temp" required
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-24 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Registrar Lectura
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- ANÁLISIS METEOROLÓGICO ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @php
            if (count($datos_por_ciudad) > 0) {
              // 1. Mostrar la temperatura máxima
              echo "<p class='mb-3'>Temperatura Máxima Registrada: <span class='text-accent-main font-bold'>{$temp_maxima}°C</span></p>";

              // 2. Calcular y mostrar promedios
              echo "<p class='text-text-muted mb-1'>Promedio de temperatura por ciudad:</p>";
              foreach ($datos_por_ciudad as $ciudad => $temps) {
                $promedio = round(array_sum($temps) / count($temps), 1);
                echo "<p class='pl-2'>- $ciudad: {$promedio}°C</p>";
              }

              // 3. Mostrar alertas de valores extremos si existen
              if (count($valores_extremos) > 0) {
                echo "<hr class='my-3 border-base-borde'>";
                echo "<p class='text-red-500 font-bold mb-1'>[!] ALERTAS DE VALORES EXTREMOS DETECTADOS</p>";
                // Usamos array_unique para no repetir la misma alerta si ingresan la misma temperatura extrema dos veces
                foreach (array_unique($valores_extremos) as $extremo) {
                  echo "<p class='pl-2 text-red-400'>- Registrado: $extremo</p>";
                }
              }
            } else {
              echo "<p class='text-text-muted italic'>El sistema está en espera de la primera lectura de temperatura...</p>";
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