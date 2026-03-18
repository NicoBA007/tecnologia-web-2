<x-layout title="Ejercicio 14 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">Ejercicio 14</h1>
    <p class="text-text-muted mb-8">Una persona registra sus gastos diarios en diferentes categorías. El programa debe calcular el total gastado por categoría, el gasto total mensual y determinar 
en qué categoría se gastó más dinero.</p>

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
        // 1. Categorías de gastos definidas
        $categorias_disponibles = ["Alimentación", "Transporte", "Vivienda", "Entretenimiento", "Salud", "Educación", "Iversiones", "Pasatiempo", "Ropa"];

        // 2. Recuperamos el historial de la URL. Formato: "Categoria:Monto,Categoria:Monto"
        $historial_str = $_GET['historial'] ?? '';
        $lista_gastos = $historial_str ? explode(',', $historial_str) : [];

        // 3. Procesar nuevo gasto
        if (isset($_GET['categoria']) && isset($_GET['monto'])) {
          $cat_nueva = $_GET['categoria'];
          $monto_nuevo = (float) $_GET['monto'];

          if (in_array($cat_nueva, $categorias_disponibles) && $monto_nuevo > 0) {
            $lista_gastos[] = $cat_nueva . ':' . $monto_nuevo;
            $historial_str = implode(',', $lista_gastos);
          }
        }

        // 4. Variables de procesamiento
        $gastos_por_categoria = [];
        $gasto_total_mensual = 0;

        // 5. Procesamos el historial para agrupar datos
        foreach ($lista_gastos as $registro) {
          list($cat, $monto) = explode(':', $registro);
          $monto = (float) $monto;

          if (!isset($gastos_por_categoria[$cat])) {
            $gastos_por_categoria[$cat] = 0;
          }
          
          $gastos_por_categoria[$cat] += $monto;
          $gasto_total_mensual += $monto;
        }

        // 6. Determinar la categoría con mayor gasto
        $categoria_mayor_gasto = "Ninguna";
        $max_monto = -1;

        foreach ($gastos_por_categoria as $c => $total_c) {
          if ($total_c > $max_monto) {
            $max_monto = $total_c;
            $categoria_mayor_gasto = $c;
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- REGISTRO DE GASTOS DIARIOS ---</p>
        <form method="GET" action="" class="flex items-center gap-4 mb-8 flex-wrap">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label for="categoria" class="text-text-arena">> Categoría:</label>
          <select name="categoria" id="categoria" required
            class="bg-transparent border border-base-borde rounded px-2 py-1 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            @foreach ($categorias_disponibles as $cat)
              <option value="{{ $cat }}" style="background-color: #1a1a1a;">{{ $cat }}</option>
            @endforeach
          </select>

          <label for="monto" class="text-text-arena">> Monto ($):</label>
          <input type="number" name="monto" id="monto" required min="0.01" step="0.01"
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-24 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Registrar Gasto
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- REPORTE FINANCIERO ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @if ($gasto_total_mensual > 0)
            <p class='mb-2'>Gasto Total Mensual: <span class='text-accent-main font-bold'>${{ number_format($gasto_total_mensual, 2) }}</span></p>
            <p class='mb-4'>Categoría de mayor impacto: <span class='text-red-400 font-bold'>{{ $categoria_mayor_gasto }}</span> (${{ number_format($max_monto, 2) }})</p>

            <p class='text-text-muted mb-2'>Desglose por categoría:</p>
            @foreach ($gastos_por_categoria as $c => $total_c)
              @php 
                $porcentaje = ($total_c / $gasto_total_mensual) * 100;
              @endphp
              <p class='pl-2'>
                - {{ $c }}: <span class="text-text-beige">${{ number_format($total_c, 2) }}</span> 
                <span class="text-xs text-text-muted">({{ number_format($porcentaje, 1) }}%)</span>
              </p>
            @endforeach
          @else
            <p class='text-text-muted italic'>No se han registrado gastos todavía.</p>
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