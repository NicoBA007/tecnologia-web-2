<?php
$estudiantes = [
  "Ana García"      => [85, 90, 78, 92], 
  "Juan Pérez"      => [45, 50, 60, 55],
  "Carla Méndez"    => [100, 95, 98, 100],
  "Luis Torrico"    => [70, 65, 80, 75],
  "Roberto Gómez"   => [30, 40, 50, 20]
];

function procesarAcademicos($datos)
{
  $reporte = [
    "lista" => [],
    "mejor_estudiante" => "",
    "promedio_maximo" => 0
  ];

  foreach ($datos as $nombre => $notas) {
    $promedio = array_sum($notas) / count($notas);

    $estado = ($promedio >= 51) ? "Aprobado" : "Reprobado";

    $reporte["lista"][$nombre] = [
      "promedio" => round($promedio, 2),
      "estado"   => $estado
    ];

    if ($promedio > $reporte["promedio_maximo"]) {
      $reporte["promedio_maximo"] = round($promedio, 2);
      $reporte["mejor_estudiante"] = $nombre;
    }
  }
  return $reporte;
}

$resultado = procesarAcademicos($estudiantes);
?>

<x-layout title="Ejercicio 3 - Evaluación Académica">
  <div class="max-w-6xl mx-auto py-12 px-4">

    <div class="mb-10 text-center">
      <h1 class="text-4xl font-bold text-gray-100 tracking-tight">Evaluación Académica</h1>
      <p class="text-gray-400 mt-2 italic text-sm">Procesamiento de calificaciones y promedios finales</p>
    </div>

    <div class="mb-12">
      <div class="bg-amber-500/10 border border-amber-500/40 p-8 rounded-3xl shadow-xl flex flex-col md:flex-row items-center justify-between">
        <div>
          <h3 class="text-amber-400 text-xs uppercase font-black tracking-widest">Estudiante con Mayor Promedio</h3>
          <p class="text-4xl font-black text-white mt-2"><?= $resultado['mejor_estudiante'] ?></p>
        </div>
        <div class="mt-4 md:mt-0 text-center md:text-right">
          <span class="text-5xl font-black text-amber-500"><?= $resultado['promedio_maximo'] ?></span>
          <p class="text-amber-400 text-xs font-bold uppercase">Puntaje Final</p>
        </div>
      </div>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl mb-10">
      <div class="p-6 border-b border-gray-800 bg-black/20">
        <h2 class="text-xl font-semibold text-gray-200">Registro de Notas</h2>
      </div>
      <table class="w-full text-left">
        <thead class="bg-black/40 text-gray-500 text-xs uppercase font-black">
          <tr>
            <th class="p-5">Estudiante</th>
            <th class="p-5 text-center">Calificaciones</th>
            <th class="p-5 text-center">Promedio</th>
            <th class="p-5 text-right">Condición</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <?php foreach ($resultado['lista'] as $nombre => $info): ?>
            <tr class="hover:bg-white/[0.02] transition-colors">
              <td class="p-5 text-gray-200 font-bold"><?= $nombre ?></td>
              <td class="p-5 text-center text-gray-500 text-xs">
                <?= implode(" - ", $estudiantes[$nombre]) ?>
              </td>
              <td class="p-5 text-center font-mono text-xl font-bold <?= $info['promedio'] >= 51 ? 'text-blue-400' : 'text-red-400' ?>">
                <?= $info['promedio'] ?>
              </td>
              <td class="p-5 text-right">
                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black border uppercase
                  <?= $info['estado'] === 'Aprobado'
                    ? 'bg-green-500/20 text-green-400 border-green-500/30'
                    : 'bg-red-500/20 text-red-400 border-red-500/30' ?>">
                  <?= $info['estado'] ?>
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