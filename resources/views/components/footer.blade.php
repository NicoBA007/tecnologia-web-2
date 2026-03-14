<footer class="bg-brand-bg py-20 px-6 border-t border-brand-border mt-auto">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
        <div data-purpose="footer-info">
            <div class="text-brand-accent font-black text-2xl mb-6 italic tracking-tighter">TW2.SYS</div>
            <p class="text-brand-muted text-sm leading-relaxed max-w-xs">
                Repositorio académico dedicado al estudio y aplicación de estándares modernos de desarrollo para la web industrial.
            </p>
        </div>
        
        <div data-purpose="footer-links">
            <h5 class="text-brand-heading text-xs font-bold uppercase tracking-[0.2em] mb-6">Navegación</h5>
            <ul class="space-y-4 text-sm">
                <li><a class="hover:text-brand-accent transition-colors" href="#actividades">Actividades</a></li>
                <li><a class="hover:text-brand-accent transition-colors" href="https://github.com/NicoBA007/tecnologia-web-2" target="_blank">Repositorio GitHub</a></li>
                <!-- <li><a class="hover:text-brand-accent transition-colors" href="#">Documentación</a></li>-->
            </ul>
        </div>
        
        <div data-purpose="footer-uni">
            <h5 class="text-brand-heading text-xs font-bold uppercase tracking-[0.2em] mb-6">Universidad</h5>
            <p class="text-brand-muted text-sm mb-2">Facultad de Ingeniería</p>
            <p class="text-brand-muted text-sm">Tecnología Web 2 &mdash; {{ date('Y') }}</p>
            
            <div class="mt-8 pt-8 border-t border-brand-border/30">
                <p class="text-[10px] text-brand-muted uppercase tracking-widest">&copy; {{ date('Y') }} Built with Industrial Precision.</p>
            </div>
        </div>
    </div>
</footer>