<x-layout title="Listado Actividad 2">
    <section class="w-full py-20 px-4">
        <div class="max-w-6xl mx-auto">
            
            <div class="mb-12 border-b border-base-borde pb-6">
                <a href="{{ url('/') }}" class="text-accent-main hover:text-accent-hover text-sm font-medium mb-4 inline-block">&larr; Volver al Inicio</a>
                <h1 class="text-4xl font-bold text-text-beige">Ejercicios - Actividad 2</h1>
                <p class="text-text-muted mt-2 text-lg">Selecciona un ejercicio para ver la resolución.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @for ($i = 1; $i <= 15; $i++)
                            <a href="{{ url('/a2/ejercicio'.$i) }}" class="block group">                        <div class="bg-base-superficie border border-base-borde rounded p-6 h-full transition-all duration-300 hover:border-accent-main flex flex-col justify-center items-center text-center">
                            <span class="text-3xl font-bold text-text-beige group-hover:text-accent-hover transition-colors">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-xs text-text-muted mt-2 uppercase tracking-widest group-hover:text-text-arena transition-colors">
                                Ejercicio
                            </span>
                        </div>
                    </a>
                @endfor
            </div>

        </div>
    </section>
</x-layout>