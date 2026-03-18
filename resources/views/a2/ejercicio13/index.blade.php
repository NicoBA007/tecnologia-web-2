<x-layout title="Ejercicio 13 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">Ejercicio 13</h1>
    <p class="text-text-muted mb-8">Una tienda en línea permite a los usuarios calificar productos. El sistema debe almacenar las calificaciones, calcular el promedio por producto, identificar el 
producto mejor valorado y detectar productos con baja calificación.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">

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

      @php
        // 1. Catálogo de productos disponibles
$productos_disponibles = [
    "Laptop Asus", "Mouse Gamer", "Teclado Mecánico", "Monitor Samsung", "Airpods",
    "Mando PS5", "Webcam Logitech", "Micrófono HyperX", "SSD Kingston 1TB", "iPad Air"];
        // 2. Recuperamos el historial de la URL. Formato: "Producto:Calificacion,Producto:Calificacion"
        $historial_str = $_GET['historial'] ?? '';
        $lista_calificaciones = $historial_str ? explode(',', $historial_str) : [];

        // 3. Procesar nueva calificación
        if (isset($_GET['producto']) && isset($_GET['puntos'])) {
          $prod_nuevo = $_GET['producto'];
          $puntos_nuevos = (int) $_GET['puntos'];

          // Validamos que el producto exista y la nota sea entre 1 y 5
          if (in_array($prod_nuevo, $productos_disponibles) && $puntos_nuevos >= 1 && $puntos_nuevos <= 5) {
            $lista_calificaciones[] = $prod_nuevo . ':' . $puntos_nuevos;
            $historial_str = implode(',', $lista_calificaciones);
          }
        }

        // 4. Variables de análisis
        $acumulador_puntos = []; // Para sumar puntos por producto
        $conteo_votos = [];      // Para saber cuántas veces se calificó cada uno
        $promedios = [];

        // 5. Procesamos el historial
        foreach ($lista_calificaciones as $registro) {
          list($nombre, $puntos) = explode(':', $registro);
          $puntos = (int) $puntos;

          if (!isset($acumulador_puntos[$nombre])) {
            $acumulador_puntos[$nombre] = 0;
            $conteo_votos[$nombre] = 0;
          }
          $acumulador_puntos[$nombre] += $puntos;
          $conteo_votos[$nombre]++;
        }

        // 6. Calcular promedios e identificar mejor/peor
        $mejor_producto = "N/A";
        $mejor_promedio = -1;
        $productos_bajos = []; // Calificación menor a 3

        foreach ($acumulador_puntos as $nombre => $total) {
          $promedio = $total / $conteo_votos[$nombre];
          $promedios[$nombre] = $promedio;

          if ($promedio > $mejor_promedio) {
            $mejor_promedio = $promedio;
            $mejor_producto = $nombre;
          }

          if ($promedio < 3.0) {
            $productos_bajos[] = $nombre;
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- EVALUACIÓN DE PRODUCTOS ---</p>
        <form method="GET" action="" class="flex items-center gap-4 mb-8 flex-wrap">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label for="producto" class="text-text-arena">> Producto:</label>
          <select name="producto" id="producto" required
            class="bg-transparent border border-base-borde rounded px-2 py-1 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            @foreach ($productos_disponibles as $p)
              <option value="{{ $p }}" style="background-color: #1a1a1a;">{{ $p }}</option>
            @endforeach
          </select>

          <label for="puntos" class="text-text-arena">> Calificación (1-5):</label>
          <input type="number" name="puntos" id="puntos" required min="1" max="5"
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-16 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Enviar Calificación
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- RESULTADOS DEL SISTEMA ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @if (count($promedios) > 0)
            <p class='mb-2'>Producto Estrella: <span class='text-accent-main font-bold'>{{ $mejor_producto }}</span> ({{ number_format($mejor_promedio, 1) }} ⭐)</p>

            <p class='text-text-muted mb-2'>Alertas de Calidad:</p>
            @if (count($productos_bajos) > 0)
              @foreach ($productos_bajos as $pb)
                <p class='pl-2 text-red-400'>[!] CRÍTICO: El producto <span class='font-bold'>{{ $pb }}</span> tiene un promedio bajo ({{ number_format($promedios[$pb], 1) }}).</p>
              @endforeach
            @else
              <p class='pl-2 text-green-400'>[OK] Todos los productos mantienen estándares aceptables.</p>
            @endif

            <br>
            <p class='text-text-muted mb-2'>Resumen de Promedios:</p>
            @foreach ($promedios as $nombre => $prom)
              <p class='pl-2'>- {{ $nombre }}: {{ number_format($prom, 1) }} ⭐ ({{ $conteo_votos[$nombre] }} votos)</p>
            @endforeach
          @else
            <p class='text-text-muted italic'>No hay calificaciones registradas aún.</p>
          @endif
        </div>
      </div>

    </div>

    <div class="mt-8">
      <a href="{{ url('/a2') }}" class="text-accent-main hover:text-accent-hover transition-colors font-medium"> &larr;
        Volver al listado de Actividad 2 </a>
    </div>
  </div>
</x-layout>