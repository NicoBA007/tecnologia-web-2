<x-layout title="Ejercicio 15 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">Ejercicio 15</h1>
    <p class="text-text-muted mb-8">Gestión de equipos en torneo deportivo. Registra resultados y genera la tabla de posiciones completa (Límite: 99 goles por equipo).</p>

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
        // 1. Equipos del torneo
        $equipos_torneo = ["Real Madrid", "FC Barcelona", "Manchester City", "Bayern Munich", "PSG", "Liverpool"];

        // 2. Recuperamos el historial de la URL
        $historial_str = $_GET['historial'] ?? '';
        $lista_partidos = $historial_str ? explode(',', $historial_str) : [];

        // 3. Procesar nuevo partido con límite de 99
        if (isset($_GET['eq1'], $_GET['g1'], $_GET['eq2'], $_GET['g2'])) {
            $e1 = $_GET['eq1'];
            $g1 = (int)$_GET['g1'];
            $e2 = $_GET['eq2'];
            $g2 = (int)$_GET['g2'];

            // Validación de seguridad en el servidor
            if ($g1 > 99) $g1 = 99;
            if ($g2 > 99) $g2 = 99;

            if ($e1 !== $e2 && in_array($e1, $equipos_torneo) && in_array($e2, $equipos_torneo)) {
                $lista_partidos[] = "$e1:$g1:$e2:$g2";
                $historial_str = implode(',', $lista_partidos);
            }
        }

        // 4. Inicializar tabla con todas las estadísticas
        $tabla = [];
        foreach ($equipos_torneo as $equipo) {
            $tabla[$equipo] = ['pj' => 0, 'pg' => 0, 'pe' => 0, 'pp' => 0, 'gf' => 0, 'gc' => 0, 'pts' => 0];
        }

        // 5. Procesar historial para llenar la tabla
        foreach ($lista_partidos as $partido) {
            list($home, $gh, $away, $ga) = explode(':', $partido);
            $gh = (int)$gh;
            $ga = (int)$ga;

            $tabla[$home]['pj']++;
            $tabla[$away]['pj']++;
            $tabla[$home]['gf'] += $gh;
            $tabla[$home]['gc'] += $ga;
            $tabla[$away]['gf'] += $ga;
            $tabla[$away]['gc'] += $gh;

            if ($gh > $ga) { 
                $tabla[$home]['pg']++; $tabla[$home]['pts'] += 3;
                $tabla[$away]['pp']++;
            } elseif ($gh < $ga) { 
                $tabla[$away]['pg']++; $tabla[$away]['pts'] += 3;
                $tabla[$home]['pp']++;
            } else { 
                $tabla[$home]['pe']++; $tabla[$home]['pts'] += 1;
                $tabla[$away]['pe']++; $tabla[$away]['pts'] += 1;
            }
        }

        // 6. Ordenar por puntos y diferencia de goles
        uasort($tabla, function($a, $b) {
            if ($a['pts'] === $b['pts']) {
                return ($b['gf'] - $b['gc']) <=> ($a['gf'] - $a['gc']);
            }
            return $b['pts'] <=> $a['pts'];
        });
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- REGISTRAR RESULTADO (Máx 99) ---</p>
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border border-base-borde p-4 rounded">
          <input type="hidden" name="historial" value="{{ $historial_str }}">

          <div class="flex flex-col gap-2">
            <label class="text-xs text-text-muted">EQUIPO LOCAL</label>
            <div class="flex gap-2">
                <select name="eq1" required class="bg-transparent border border-base-borde rounded px-2 py-1 flex-1 text-text-arena focus:border-accent-main outline-none">
                    @foreach($equipos_torneo as $eq) <option value="{{$eq}}" style="background:#1a1a1a">{{$eq}}</option> @endforeach
                </select>
                <input type="number" name="g1" placeholder="0" required min="0" max="99"
                  oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);"
                  class="bg-transparent border border-base-borde rounded w-16 text-center focus:border-accent-main outline-none">
            </div>
          </div>

          <div class="flex flex-col gap-2">
            <label class="text-xs text-text-muted">EQUIPO VISITANTE</label>
            <div class="flex gap-2">
                <select name="eq2" required class="bg-transparent border border-base-borde rounded px-2 py-1 flex-1 text-text-arena focus:border-accent-main outline-none">
                    @foreach($equipos_torneo as $eq) <option value="{{$eq}}" style="background:#1a1a1a">{{$eq}}</option> @endforeach
                </select>
                <input type="number" name="g2" placeholder="0" required min="0" max="99"
                  oninput="if(this.value.length > 2) this.value = this.value.slice(0,2);"
                  class="bg-transparent border border-base-borde rounded w-16 text-center focus:border-accent-main outline-none">
            </div>
          </div>

          <div class="md:col-span-2 flex justify-center">
            <button type="submit" class="border border-base-borde text-accent-main hover:bg-accent-main hover:text-base-fondo transition-all font-medium rounded px-6 py-2">
                Finalizar Partido
            </button>
          </div>
        </form>

        <p class="mb-4 text-text-muted">--- TABLA DE POSICIONES COMPLETA ---</p>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="text-text-muted border-b border-base-borde">
                <th class="py-2">Equipo</th>
                <th class="py-2 text-center">PJ</th>
                <th class="py-2 text-center">G</th>
                <th class="py-2 text-center">E</th>
                <th class="py-2 text-center">P</th>
                <th class="py-2 text-center">GF</th>
                <th class="py-2 text-center">GC</th>
                <th class="py-2 text-center text-accent-main">PTS</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tabla as $nombre => $stats)
                <tr class="border-b border-base-borde/50 hover:bg-white/5">
                  <td class="py-2 font-bold text-text-beige">{{ $nombre }}</td>
                  <td class="py-2 text-center">{{ $stats['pj'] }}</td>
                  <td class="py-2 text-center">{{ $stats['pg'] }}</td>
                  <td class="py-2 text-center">{{ $stats['pe'] }}</td>
                  <td class="py-2 text-center">{{ $stats['pp'] }}</td>
                  <td class="py-2 text-center">{{ $stats['gf'] }}</td>
                  <td class="py-2 text-center">{{ $stats['gc'] }}</td>
                  <td class="py-2 text-center font-bold text-accent-main">{{ $stats['pts'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <div class="mt-8">
      <a href="{{ url('/a2') }}" class="text-accent-main hover:text-accent-hover transition-colors font-medium"> &larr;
        Volver al listado de Actividad 2 </a>
    </div>
  </div>
</x-layout>