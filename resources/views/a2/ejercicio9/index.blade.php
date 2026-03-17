<x-layout title="Ejercicio 9 - A2">
  <div class="max-w-4xl mx-auto py-20 px-4">
    <h1 class="text-4xl font-bold text-text-beige mb-2">9. Sistema básico de autenticación</h1>

    <p class="text-text-muted mb-8">El programa valida credenciales contra una lista de usuarios registrados, permite o
      deniega el acceso y contabiliza los intentos fallidos consecutivos.</p>

    <div class="bg-base-superficie border border-base-borde rounded p-8">
      @php
        // 1. Base de datos simulada de usuarios (usuario => contraseña)
        $usuarios_registrados = [
          'admin' => 'supersecreto',
          'profesor' => 'docente123',
          'estudiante' => 'aprobado2024'
        ];

        // 2. Recuperar el estado actual de los intentos fallidos (0 por defecto)
        $intentos_fallidos = isset($_GET['intentos']) ? (int) $_GET['intentos'] : 0;

        $estado = null;
        $mensaje = "";

        // 3. Lógica de Autenticación
        // Verificamos que se haya enviado el formulario haciendo clic en el botón
        if (isset($_GET['btn_login'])) {
          $user_input = trim($_GET['usuario'] ?? '');
          $pass_input = trim($_GET['password'] ?? '');

          // Validar si el usuario existe y si la contraseña coincide exactamente
          if (array_key_exists($user_input, $usuarios_registrados) && $usuarios_registrados[$user_input] === $pass_input) {
            $estado = 'success';
            $mensaje = "¡Bienvenido al sistema, $user_input!";
            // Si entra con éxito, reiniciamos el contador de errores a 0
            $intentos_fallidos = 0;
          } else {
            $estado = 'error';
            $mensaje = "Credenciales incorrectas. Verifique su usuario o contraseña.";
            // Si falla, sumamos 1 al contador
            $intentos_fallidos++;
          }
        }
      @endphp

      <div class="mt-6 text-text-arena" style="font-family: monospace;">

        <p class="mb-4 text-text-muted">--- TERMINAL DE ACCESO SEGURA ---</p>
        <p class="mb-6 text-sm text-text-muted">
          *Usuarios de prueba: admin (supersecreto), profesor (docente123), estudiante (aprobado2024)
        </p>

        <form method="GET" action="" class="flex flex-col gap-5 mb-8 w-72">
          <input type="hidden" name="intentos" value="{{ $intentos_fallidos }}">

          <div class="flex flex-col gap-1">
            <label for="usuario" class="text-text-arena">> Nombre de Usuario:</label>
            <input type="text" name="usuario" id="usuario" required autocomplete="off"
              class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
          </div>

          <div class="flex flex-col gap-1">
            <label for="password" class="text-text-arena">> Contraseña:</label>
            <input type="password" name="password" id="password" required
              class="bg-transparent border border-base-borde rounded px-3 py-2 text-text-arena focus:outline-none focus:border-accent-main transition-colors">
          </div>

          <button type="submit" name="btn_login" value="1"
            class="border border-base-borde text-accent-main hover:text-accent-hover transition-colors font-medium rounded px-4 py-2 mt-2">
            Iniciar Sesión
          </button>
        </form>

        <p class="mb-4 text-text-muted">--- RESPUESTA DEL SERVIDOR ---</p>
        <div class="pl-4 bg-base-superficie border border-base-borde rounded p-4 h-32 flex flex-col justify-center">
          @php
            if ($estado === 'success') {
              echo "<p class='text-green-500 font-bold mb-1'>[ V ] ACCESO CONCEDIDO</p>";
              echo "<p class='text-text-beige'>$mensaje</p>";
            } elseif ($estado === 'error') {
              echo "<p class='text-red-500 font-bold mb-1'>[ X ] ACCESO DENEGADO</p>";
              echo "<p class='text-text-beige'>$mensaje</p>";
            } else {
              echo "<p class='text-text-muted italic'>Esperando credenciales de acceso...</p>";
            }

            // Mostrar la alerta de intentos si es mayor a 0
            if ($intentos_fallidos > 0) {
              echo "<hr class='my-2 border-base-borde'>";
              echo "<p class='text-red-400 text-sm font-bold'>Intentos fallidos consecutivos: $intentos_fallidos</p>";

              if ($intentos_fallidos >= 3) {
                echo "<p class='text-red-500 text-xs mt-1 blink'>ADVERTENCIA: Posible intento de intrusión detectado.</p>";
              }
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