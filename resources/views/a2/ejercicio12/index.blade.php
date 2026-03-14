<x-layout title="Ejercicio 12 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">Ejercicio 12</h1>
    <p class="text-text-muted mb-8">Un sitio web registra la cantidad de visitas recibidas por día y por página.
      El programa debe analizar los registros, determinar qué página tiene más visitas, calcular el
      total de visitas del sitio y detectar días con tráfico inusualmente alto.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">

      <style>
        /* Estilos para quitar las flechas de los inputs numéricos */
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
        // 1. Definimos las páginas de nuestro sitio web
        $paginas_disponibles = ["Inicio", "Productos", "Servicios", "Blog", "Contacto"];

        // 2. Recuperamos el historial de la URL. Formato: "Dia:Pagina:Visitas,Dia:Pagina:Visitas"
        $historial_str = $_GET['historial'] ?? '';
        $lista_registros = $historial_str ? explode(',', $historial_str) : [];

        // 3. Verificamos si el usuario envió un nuevo registro válido
        if (isset($_GET['dia']) && isset($_GET['pagina']) && isset($_GET['visitas'])) {
          $dia_ingresado = (int) $_GET['dia'];
          $pagina_ingresada = $_GET['pagina'];
          $visitas_ingresadas = (int) $_GET['visitas'];

          // Validamos que los datos tengan sentido antes de guardarlos
          if ($dia_ingresado > 0 && in_array($pagina_ingresada, $paginas_disponibles) && $visitas_ingresadas >= 0) {
            // Guardamos con el formato "Dia:Pagina:Visitas"
            $lista_registros[] = $dia_ingresado . ':' . $pagina_ingresada . ':' . $visitas_ingresadas;
            $historial_str = implode(',', $lista_registros);
          }
        }

        // 4. Variables para procesar los datos
        $total_visitas_sitio = 0;
        $visitas_por_pagina = [];
        $visitas_por_dia = [];

        // 5. Procesamos el historial usando ciclos
        foreach ($lista_registros as $registro) {
          // Separamos los 3 datos de cada registro
          list($dia, $pagina, $visitas) = explode(':', $registro);
          $visitas = (int) $visitas;

          // Sumamos al total general
          $total_visitas_sitio += $visitas;

          // Agrupamos las visitas por página
          if (!isset($visitas_por_pagina[$pagina])) {
            $visitas_por_pagina[$pagina] = 0;
          }
          $visitas_por_pagina[$pagina] += $visitas;

          // Agrupamos las visitas por día (para calcular el tráfico inusual)
          if (!isset($visitas_por_dia[$dia])) {
            $visitas_por_dia[$dia] = 0;
          }
          $visitas_por_dia[$dia] += $visitas;
        }

        // 6. Determinar qué página tiene más visitas
        $pagina_mas_visitada = "Ninguna";
        $max_visitas_pagina = -1;

        foreach ($visitas_por_pagina as $pag => $vis) {
          if ($vis > $max_visitas_pagina) {
            $max_visitas_pagina = $vis;
            $pagina_mas_visitada = $pag;
          }
        }

        // 7. Detectar días con tráfico inusualmente alto
        $dias_inusuales = [];
        $cantidad_dias_registrados = count($visitas_por_dia);

        // Solo podemos detectar tráfico inusual si tenemos datos de más de 1 día para comparar
        if ($cantidad_dias_registrados > 1) {
          $promedio_diario = $total_visitas_sitio / $cantidad_dias_registrados;

          // Regla: Es inusual si supera el 50% extra del promedio (promedio * 1.5)
          $umbral_inusual = $promedio_diario * 1.5;

          foreach ($visitas_por_dia as $dia => $total_visitas_dia) {
            if ($total_visitas_dia > $umbral_inusual) {
              // Guardamos el día y cuántas visitas tuvo
              $dias_inusuales[$dia] = $total_visitas_dia;
            }
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- INGRESO DE TRÁFICO WEB ---</p>
        <form method="GET" action="" class="flex items-center gap-4 mb-8 flex-wrap">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label for="dia" class="text-text-arena">> Día (número):</label>
          <input type="number" name="dia" id="dia" required min="1" autofocus
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-16 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <label for="pagina" class="text-text-arena">> Página:</label>
          <select name="pagina" id="pagina" required
            class="bg-transparent border border-base-borde rounded px-2 py-1 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            @php
              foreach ($paginas_disponibles as $pag) {
                echo "<option value='$pag' style='background-color: #1a1a1a;'>$pag</option>";
              }
            @endphp
          </select>

          <label for="visitas" class="text-text-arena">> Visitas:</label>
          <input type="number" name="visitas" id="visitas" required min="0"
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-20 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Registrar Tráfico
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- ANÁLISIS DE DATOS ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @php
            if ($total_visitas_sitio > 0) {
              echo "<p class='mb-2'>Visitas totales del sitio: <span class='text-accent-main font-bold'>$total_visitas_sitio</span></p>";
              echo "<p class='mb-4'>Página más popular: <span class='text-accent-main font-bold'>$pagina_mas_visitada</span> ($max_visitas_pagina visitas)</p>";

              // Mostrar alertas de tráfico inusual
              echo "<p class='text-text-muted mb-2'>Alertas del sistema:</p>";

              if ($cantidad_dias_registrados <= 1) {
                echo "<p class='pl-2 text-yellow-500'>[!] Se necesitan datos de al menos 2 días distintos para detectar tráfico inusual.</p>";
              } else if (count($dias_inusuales) > 0) {
                foreach ($dias_inusuales as $dia => $vis) {
                  echo "<p class='pl-2 text-red-400'>[!] ALERTA: Tráfico inusualmente alto el <span class='font-bold'>Día $dia</span> con $vis visitas.</p>";
                }
              } else {
                echo "<p class='pl-2 text-green-400'>[OK] El tráfico se mantiene dentro de los promedios normales.</p>";
              }

              echo "<br><p class='text-text-muted mb-2'>Resumen por día:</p>";
              foreach ($visitas_por_dia as $dia => $vis) {
                echo "<p class='pl-2'>- Día $dia: $vis visitas totales</p>";
              }

            } else {
              echo "<p class='text-text-muted italic'>Sin datos de tráfico registrados.</p>";
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