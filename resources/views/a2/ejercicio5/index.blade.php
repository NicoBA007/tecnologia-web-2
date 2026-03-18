<x-layout title="Ejercicio 5 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">5. Sistema de cálculo de salarios</h1>

    <p class="text-text-muted mb-8">
      Cálculo de remuneraciones basado en horas trabajadas y bonificaciones por desempeño. 
      El sistema determina el salario individual y el gasto operativo total.
    </p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Configuración de parámetros de la empresa
        $pago_por_hora = 13.75; // Ejemplo: 13.75 Bs/hr
        $porcentaje_bono = 0.15; // 15% de bono por buen desempeño

        // 2. Recuperamos el historial de la URL
        // Estructura: Nombre|Horas|Bono(0 o 1),...
        $historial_str = $_GET['historial'] ?? '';
        $empleados = $historial_str ? explode(',', $historial_str) : [];

        // 3. Procesar nuevo registro
        if (isset($_GET['nombre'], $_GET['horas'])) {
          $nuevo_nombre = $_GET['nombre'];
          $nuevas_horas = (int)$_GET['horas'];
          $tiene_bono = isset($_GET['bono']) ? 1 : 0;
          
          $empleados[] = "$nuevo_nombre|$nuevas_horas|$tiene_bono";
          $historial_str = implode(',', $empleados);
        }

        // 4. Lógica de cálculo y procesamiento
        $detalle_nominas = [];
        $gasto_total = 0;

        foreach ($empleados as $registro) {
          list($nom, $hrs, $bono_flag) = explode('|', $registro);
          
          $salario_base = $hrs * $pago_por_hora;
          $monto_bono = ($bono_flag == 1) ? ($salario_base * $porcentaje_bono) : 0;
          $salario_total = $salario_base + $monto_bono;
          
          $gasto_total += $salario_total;
          $detalle_nominas[] = [
            'nombre' => $nom,
            'horas' => $hrs,
            'bono' => $monto_bono,
            'total' => $salario_total
          ];
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- REGISTRO DE NUEVO EMPLEADO ---</p>
        
        <form method="GET" action="" class="space-y-4 mb-10">
          <input type="hidden" name="historial" value="{{ $historial_str }}">
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col gap-2">
              <label class="text-xs text-text-muted uppercase">Nombre del Empleado</label>
              <input type="text" name="nombre" required placeholder="Ej: Luis Camacho"
                class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-xs text-text-muted uppercase">Horas Trabajadas</label>
              <input type="number" name="horas" required placeholder="0"
                class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
            </div>
          </div>

          <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 cursor-pointer group">
              <input type="checkbox" name="bono" value="1" class="accent-accent-main w-4 h-4">
              <span class="text-sm text-text-muted group-hover:text-text-arena transition-colors">¿Aplicar bonificación por desempeño? (15%)</span>
            </label>
            
            <button type="submit"
              class="ml-auto border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-6 py-2">
              Calcular y Registrar
            </button>
          </div>
        </form>

        <p class="mb-4 text-text-muted">--- PLANILLA DE SALARIOS ---</p>
        <div class="overflow-x-auto mb-8 bg-base-superficie border border-base-borde rounded p-4">
          @if (count($detalle_nominas) > 0)
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-text-muted border-b border-base-borde text-xs uppercase">
                  <th class="py-2">Empleado</th>
                  <th class="py-2 text-center">Hrs</th>
                  <th class="py-2 text-right">Bono</th>
                  <th class="py-2 text-right">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($detalle_nominas as $emp)
                  <tr class="border-b border-base-borde/30 hover:bg-white/5 transition-colors">
                    <td class="py-2 text-text-arena">{{ $emp['nombre'] }}</td>
                    <td class="py-2 text-center">{{ $emp['horas'] }}</td>
                    <td class="py-2 text-right text-accent-main">{{ $emp['bono'] > 0 ? '+'.number_format($emp['bono'], 2) : '-' }}</td>
                    <td class="py-2 text-right font-bold text-text-beige">{{ number_format($emp['total'], 2) }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr class="text-accent-main">
                  <td colspan="3" class="py-4 font-bold text-right uppercase">Gasto Total Empresa:</td>
                  <td class="py-4 text-right font-bold text-xl underline decoration-double">
                    {{ number_format($gasto_total, 2) }}
                  </td>
                </tr>
              </tfoot>
            </table>
          @else
            <p class="text-text-muted italic text-center py-4">No hay empleados registrados en el ciclo actual.</p>
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