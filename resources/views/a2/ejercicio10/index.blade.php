<x-layout title="Ejercicio 10 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">10. Registro de pedidos de restaurante</h1>

    <p class="text-text-muted mb-8">El sistema debe contabilizar los pedidos de cada plato, calcular el total de pedidos
      y
      determinar cuál fue el plato más solicitado.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Definimos nuestro menú (El número es la clave)
        $menu = [
          1 => "Hamburguesa",
          2 => "Pizza",
          3 => "Ensalada",
          4 => "Tacos",
          5 => "Agua"
        ];

        // 2. Recuperamos el historial de pedidos de la URL
        $historial_str = $_GET['historial'] ?? '';
        $lista_pedidos = $historial_str ? explode(',', $historial_str) : [];

        // 3. Verificamos si el usuario envió un nuevo pedido válido
        if (isset($_GET['nuevo_pedido']) && isset($menu[$_GET['nuevo_pedido']])) {
          $lista_pedidos[] = $_GET['nuevo_pedido'];
          $historial_str = implode(',', $lista_pedidos);
        }

        // 4. Lógica de procesamiento (Contabilizar)
        $conteo_platos = [];
        $total_pedidos = count($lista_pedidos);

        foreach ($lista_pedidos as $id_plato) {
          $nombre_plato = $menu[$id_plato];
          if (isset($conteo_platos[$nombre_plato])) {
            $conteo_platos[$nombre_plato]++;
          } else {
            $conteo_platos[$nombre_plato] = 1;
          }
        }

        // 5. Encontrar el plato más solicitado
        $plato_mas_solicitado = "Ninguno";
        $max_pedidos = 0;

        foreach ($conteo_platos as $nombre => $cantidad) {
          if ($cantidad > $max_pedidos) {
            $max_pedidos = $cantidad;
            $plato_mas_solicitado = $nombre;
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- MENÚ DISPONIBLE ---</p>
        <div class="pl-4 mb-6">
          @php
            foreach ($menu as $numero => $nombre) {
              echo "<span class='text-accent-main'>[$numero]</span> $nombre <br>";
            }
          @endphp
        </div>
        <style>
          /* Quita las flechas en Chrome, Safari, Edge y Opera */
          input[type="number"]::-webkit-inner-spin-button,
          input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
          }

          /* Quita las flechas en Firefox */
          input[type="number"] {
            -moz-appearance: textfield;
          }
        </style>

        <form method="GET" action="" class="flex items-center gap-4 mb-8">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <label for="nuevo_pedido" class="text-text-arena">> Ingrese el número del plato:</label>

          <input type="number" name="nuevo_pedido" id="nuevo_pedido" required autofocus
            class="bg-transparent border border-base-borde rounded px-3 py-1 text-center w-20 text-text-arena focus:outline-none focus:border-accent-main transition-colors">

          <button type="submit"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-1">
            Registrar
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- ESTADO DE LOS PEDIDOS ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          @php
            if ($total_pedidos > 0) {
              echo "<p class='mb-2'>Total de pedidos registrados: <span class='text-accent-main font-bold'>$total_pedidos</span></p>";
              echo "<p class='mb-4'>Plato más solicitado: <span class='text-accent-main font-bold'>$plato_mas_solicitado</span> ($max_pedidos veces)</p>";

              echo "<p class='text-text-muted mb-1'>Detalle contable:</p>";
              foreach ($conteo_platos as $nombre => $cantidad) {
                echo "<p class='pl-2'>- $nombre: $cantidad</p>";
              }
            } else {
              echo "<p class='text-text-muted italic'>Esperando el primer pedido...</p>";
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