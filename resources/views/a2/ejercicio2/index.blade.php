<?php
$precios = [
  "Laptop Pro"    => 1200,
  "Mouse Optico"  => 25,
  "Monitor 4K"    => 400,
  "Teclado RGB"   => 75,
  "Auriculares"   => 120
];

$cantidadesVendidas = [
  "Laptop Pro"    => [1, 0, 2, 1, 0, 3, 1], 
  "Mouse Optico"  => [5, 12, 8, 4, 10, 20, 15],
  "Monitor 4K"    => [2, 1, 0, 3, 1, 4, 2],
  "Teclado RGB"   => [3, 2, 5, 8, 10, 15, 7],
  "Auriculares"   => [4, 5, 2, 3, 8, 12, 6]
];

function procesarVentas($cantidades, $precios)
{
  $reporte = [
    "detalles" => [],
    "total_general" => 0,
    "mejor_producto" => "",
    "max_ingreso" => 0
  ];

  foreach ($cantidades as $producto => $unidadesDiarias) {
    $totalUnidades = array_sum($unidadesDiarias); 
    $precioUnitario = $precios[$producto];
    $ingresoTotal = $totalUnidades * $precioUnitario; 

    $reporte["detalles"][$producto] = [
      "unidades" => $totalUnidades,
      "ingreso"  => $ingresoTotal
    ];

    $reporte["total_general"] += $ingresoTotal;

    if ($ingresoTotal > $reporte["max_ingreso"]) {
      $reporte["max_ingreso"] = $ingresoTotal;
      $reporte["mejor_producto"] = $producto;
    }
  }
  return $reporte;
}

$resultado = procesarVentas($cantidadesVendidas, $precios);
?>

<x-layout title="Ejercicio 2 - Análisis de Ventas">
  <div class="max-w-6xl mx-auto py-12 px-4">

    <div class="mb-10 text-center">
      <h1 class="text-4xl font-bold text-gray-100 tracking-tight">Reporte de Ventas Semanales</h1>
      <p class="text-gray-400 mt-2 italic text-sm">Cálculo basado en Cantidad Vendida × Precio Unitario</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
      <div class="bg-indigo-500/10 border border-indigo-500/40 p-8 rounded-3xl shadow-xl">
        <h3 class="text-indigo-400 text-xs uppercase font-black tracking-widest">Ingresos Totales</h3>
        <p class="text-6xl font-black text-white mt-2">
          <span class="text-indigo-500 text-3xl">$</span><?= number_format($resultado['total_general'], 2) ?>
        </p>
      </div>

      <div class="bg-emerald-500/10 border border-emerald-500/40 p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <h3 class="text-emerald-400 text-xs uppercase font-black tracking-widest">Producto Líder en Ventas</h3>
        <p class="text-4xl font-black text-white mt-2"><?= $resultado['mejor_producto'] ?></p>
        <p class="text-emerald-500 font-bold mt-1 uppercase text-xs tracking-tighter">
          Generó un total de $<?= number_format($resultado['max_ingreso'], 2) ?>
        </p>
      </div>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl mb-10">
      <table class="w-full text-left">
        <thead class="bg-black/40 text-gray-500 text-xs uppercase font-black">
          <tr>
            <th class="p-5">Producto</th>
            <th class="p-5 text-center">Unidades Vendidas</th>
            <th class="p-5 text-center">Precio Unit.</th>
            <th class="p-5 text-right">Total Ingresos</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <?php foreach ($resultado['detalles'] as $nombre => $datos): ?>
            <tr class="hover:bg-white/[0.02] transition-colors">
              <td class="p-5 text-gray-200 font-bold"><?= $nombre ?></td>
              <td class="p-5 text-center text-gray-400"><?= $datos['unidades'] ?> uds.</td>
              <td class="p-5 text-center text-gray-500 font-mono">$<?= number_format($precios[$nombre], 2) ?></td>
              <td class="p-5 text-right font-mono text-indigo-400 font-bold">
                $<?= number_format($datos['ingreso'], 2) ?>
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