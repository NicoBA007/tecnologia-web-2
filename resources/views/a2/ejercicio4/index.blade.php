<x-layout title="Ejercicio 4 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">4. Control de inventario de almacén</h1>

    <p class="text-text-muted mb-8">
      El sistema identifica productos que necesitan reposición basándose en un nivel mínimo de stock, 
      calcula el total de existencias y genera alertas de bajo inventario.
    </p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Definimos el inventario inicial (ID => [Nombre, Cantidad Actual, Stock Mínimo])
        $inventario_inicial = [
          1 => ["Procesadores", 10, 5],
          2 => ["Memorias RAM", 3, 8],
          3 => ["Discos SSD", 15, 10],
          4 => ["Tarjetas Gráficas", 2, 5],
          5 => ["Fuentes de Poder", 12, 6]
        ];

        // 2. Recuperamos modificaciones de la URL (para simular persistencia de cambios)
        // Estructura del historial: id:cantidad,id:cantidad...
        $cambios_str = $_GET['cambios'] ?? '';
        $inventario = $inventario_inicial;

        if ($cambios_str) {
          $pares = explode(',', $cambios_str);
          foreach ($pares as $par) {
            list($id, $cant) = explode(':', $par);
            if (isset($inventario[$id])) {
              $inventario[$id][1] = (int)$cant;
            }
          }
        }

        // 3. Procesar nuevo registro de stock
        if (isset($_GET['id_prod']) && isset($_GET['nueva_cantidad'])) {
          $id_edit = $_GET['id_prod'];
          $nueva_cant = (int)$_GET['nueva_cantidad'];
          
          if (isset($inventario[$id_edit])) {
            $inventario[$id_edit][1] = $nueva_cant;
            
            // Re-generar el string de cambios para el formulario
            $temp_cambios = [];
            foreach ($inventario as $id => $datos) {
              $temp_cambios[] = "$id:" . $datos[1];
            }
            $cambios_str = implode(',', $temp_cambios);
          }
        }

        // 4. Lógica de cálculo
        $total_unidades = 0;
        $productos_bajo_stock = [];

        foreach ($inventario as $id => $datos) {
          $total_unidades += $datos[1];
          if ($datos[1] < $datos[2]) {
            $productos_bajo_stock[] = [
              'nombre' => $datos[0],
              'actual' => $datos[1],
              'minimo' => $datos[2]
            ];
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- INVENTARIO ACTUAL ---</p>
        <div class="overflow-x-auto mb-8">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="text-accent-main border-b border-base-borde">
                <th class="py-2 px-2">ID</th>
                <th class="py-2">Producto</th>
                <th class="py-2 text-center">Stock</th>
                <th class="py-2 text-center">Mínimo</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($inventario as $id => $datos)
                <tr class="border-b border-base-borde/50">
                  <td class="py-2 px-2 text-accent-main">[{{ $id }}]</td>
                  <td class="py-2">{{ $datos[0] }}</td>
                  <td class="py-2 text-center {{ $datos[1] < $datos[2] ? 'text-red-400 font-bold' : '' }}">
                    {{ $datos[1] }}
                  </td>
                  <td class="py-2 text-center text-text-muted">{{ $datos[2] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <style>
          input[type="number"]::-webkit-inner-spin-button,
          input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none; margin: 0;
          }
          input[type="number"] { -moz-appearance: textfield; }
        </style>

        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
          <input type="hidden" name="cambios" value="{{ $cambios_str }}">
          
          <div class="flex flex-col gap-2">
            <label class="text-xs text-text-muted uppercase">ID Producto</label>
            <input type="number" name="id_prod" required placeholder="Ej: 1"
              class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-xs text-text-muted uppercase">Nueva Cantidad</label>
            <input type="number" name="nueva_cantidad" required placeholder="0"
              class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
          </div>

          <div class="flex items-end">
            <button type="submit"
              class="w-full border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded py-2">
              Actualizar Stock
            </button>
          </div>
        </form>

        <p class="mb-4 text-text-muted">--- REPORTE DE ALMACÉN ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4">
          <p class="mb-2">Total de unidades en inventario: <span class="text-accent-main font-bold">{{ $total_unidades }}</span></p>
          
          <p class="text-text-muted mt-4 mb-2">Alertas de Reposición:</p>
          @if (count($productos_bajo_stock) > 0)
            @foreach ($productos_bajo_stock as $prod)
              <p class="pl-2 text-red-400">
                ⚠️ <span class="font-bold">{{ $prod['nombre'] }}</span>: 
                Existencia crítica ({{ $prod['actual'] }} de {{ $prod['minimo'] }} requeridos)
              </p>
            @endforeach
          @else
            <p class="pl-2 text-accent-main italic">✓ Todos los productos cuentan con stock suficiente.</p>
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