<x-layout title="Ejercicio 6 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">6. Gestión de préstamos en biblioteca</h1>

    <p class="text-text-muted mb-8">
      Monitoreo de circulación de textos. El sistema contabiliza los préstamos totales, 
      lista los libros en posesión de usuarios e identifica al lector con mayor actividad.
    </p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Catálogo de libros disponibles (Aquí puedes añadir más libros fácilmente)
        $catalogo = [
          "Cien Años de Soledad",
          "El Principito",
          "Cálculo de Stewart",
          "Redes de Computadoras (Tanenbaum)",
          "Don Quijote de la Mancha",
          "Clean Code (Robert C. Martin)"
        ];

        // 2. Recuperamos el historial de la URL
        $historial_str = $_GET['historial'] ?? '';
        $prestamos = $historial_str ? explode(',', $historial_str) : [];

        // 3. Procesar nuevo préstamo
        if (!empty($_GET['usuario']) && !empty($_GET['libro'])) {
          $nuevo_usuario = htmlspecialchars($_GET['usuario']);
          $nuevo_libro = htmlspecialchars($_GET['libro']);
          
          $prestamos[] = "$nuevo_usuario|$nuevo_libro";
          $historial_str = implode(',', $prestamos);
        }

        // 4. Lógica de análisis
        $conteo_usuarios = [];
        $libros_prestados = [];
        foreach ($prestamos as $registro) {
          list($u, $l) = explode('|', $registro);
          $conteo_usuarios[$u] = ($conteo_usuarios[$u] ?? 0) + 1;
          $libros_prestados[] = ['titulo' => $l, 'lector' => $u];
        }

        // 5. Usuario con más libros
        $usuario_top = "N/A";
        $max_libros = 0;
        foreach ($conteo_usuarios as $nombre => $cantidad) {
          if ($cantidad > $max_libros) {
            $max_libros = $cantidad;
            $usuario_top = $nombre;
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">
        <p class="mb-4 text-text-muted">--- REGISTRAR PRESTAMO ---</p>
        
        <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-10">
          <input type="hidden" name="historial" value="{{ $historial_str }}">
          
          <div class="md:col-span-2 flex flex-col gap-2">
            <label class="text-xs text-text-muted uppercase">Lector</label>
            <input type="text" name="usuario" required placeholder="Nombre del alumno"
              class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
          </div>

          <div class="md:col-span-2 flex flex-col gap-2">
            <label class="text-xs text-text-muted uppercase">Seleccionar Libro</label>
            <select name="libro" required 
              class="bg-base-superficie border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
              <option value="" disabled selected>-- Elegir libro --</option>
              @foreach($catalogo as $item)
                <option value="{{ $item }}">{{ $item }}</option>
              @endforeach
            </select>
          </div>

          <div class="flex items-end">
            <button type="submit"
              class="w-full border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded py-2">
              Registrar
            </button>
          </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <p class="mb-4 text-text-muted">--- ESTADÍSTICAS ---</p>
            <div class="bg-base-superficie border border-base-borde rounded p-4 space-y-3">
              <p>Total de préstamos: <span class="text-accent-main font-bold">{{ count($prestamos) }}</span></p>
              <p>Lector más frecuente: <br> 
                <span class="text-accent-main font-bold">
                  {{ $usuario_top }} 
                  @if($max_libros > 0) ({{ $max_libros }} libros) @endif
                </span>
              </p>
            </div>
          </div>

          <div>
            <p class="mb-4 text-text-muted">--- LIBROS PRESTADOS ---</p>
            <div class="max-h-60 overflow-y-auto border-l border-base-borde pl-4 space-y-2 text-sm">
              @forelse ($libros_prestados as $lp)
                <div>
                  <span class="text-accent-main">»</span> {{ $lp['titulo'] }} 
                  <br><span class="text-text-muted text-xs pl-4">En posesión de: {{ $lp['lector'] }}</span>
                </div>
              @empty
                <p class="text-text-muted italic">No hay libros fuera de biblioteca.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>