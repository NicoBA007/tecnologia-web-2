<?php
$usuarios = [
  ["nombre" => "María López", "rol" => "Administrativo"],
  ["nombre" => "Marco Aurelio", "rol" => "Docente"],
  ["nombre" => "Sergio Peña", "rol" => "Estudiante"],
  ["nombre" => "Lucía Torres", "rol" => "Estudiante"],
];

$configuracion = [
  "Administrativo" => [
    "acciones" => ["Añadir Usuarios", "Gestionar Pagos", "Ver Reportes"],
    "color" => "red"
  ],
  "Docente" => [
    "acciones" => ["Calificar", "Subir Material", "Pasar Lista"],
    "color" => "yellow"
  ],
  "Estudiante" => [
    "acciones" => ["Ver Notas", "Descargar PDF", "Inscribir Cursos"],
    "color" => "blue"
  ]
];

function obtenerTotales($lista, $roles)
{
  $conteo = [];
  foreach ($roles as $nombreRol => $info) {
    $conteo[$nombreRol] = 0;
  }

  foreach ($lista as $u) {
    $rol = $u['rol'];
    if (isset($conteo[$rol])) {
      $conteo[$rol]++;
    }
  }
  return $conteo;
}

$resumenRoles = obtenerTotales($usuarios, $configuracion);
?>

<x-layout title="Panel de Control Educativo">
  <div class="max-w-6xl mx-auto py-12 px-4">

    <div class="mb-10 text-center">
      <h1 class="text-4xl font-bold text-gray-100 tracking-tight">Gestión de Plataforma</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
      <?php foreach ($configuracion as $rol => $data):
        $c = $data['color'];
        $total = $resumenRoles[$rol];
      ?>
        <div class="bg-<?= $c ?>-500/10 border border-<?= $c ?>-500/40 p-6 rounded-2xl shadow-lg relative overflow-hidden group">
          <h3 class="text-gray-400 text-xs uppercase font-black tracking-widest"><?= $rol ?>s</h3>
          <p class="text-5xl font-black text-<?= $c ?>-400 mt-2"><?= $total ?></p>

          <div class="mt-6 pt-4 border-t border-white/5">
            <p class="text-[10px] font-bold text-gray-500 uppercase mb-3 tracking-wider">Permisos:</p>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($data['acciones'] as $accion): ?>
                <span class="text-[10px] px-2 py-1 rounded bg-black/40 text-<?= $c ?>-300 border border-<?= $c ?>-500/20">
                  <?= $accion ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl mb-10">
      <div class="p-6 border-b border-gray-800 bg-black/20 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-200">Usuarios Registrados</h2>
        <span class="text-xs text-gray-500 font-mono">Total: <?= count($usuarios) ?></span>
      </div>
      <table class="w-full text-left">
        <thead class="bg-black/40 text-gray-500 text-xs uppercase font-black">
          <tr>
            <th class="p-5">Nombre Completo</th>
            <th class="p-5 text-center">Rol Asignado</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <?php foreach ($usuarios as $u):
            $col = $configuracion[$u['rol']]['color'];
          ?>
            <tr class="hover:bg-white/[0.02] transition-colors">
              <td class="p-5 text-gray-200 font-medium italic">"<?= $u['nombre'] ?>"</td>
              <td class="p-5 text-center">
                <span class="px-4 py-1 rounded-lg text-[10px] font-bold bg-<?= $col ?>-500/20 text-<?= $col ?>-400 border border-<?= $col ?>-500/30">
                  <?= strtoupper($u['rol']) ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-8">
      <a href="{{ url('/a2') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors font-semibold group">
        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver al listado de Actividad 2
      </a>
    </div>

  </div>
</x-layout>