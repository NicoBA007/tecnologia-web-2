<!DOCTYPE html>
<html class="scroll-smooth" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'Tecnología Web 2 | Portafolio Industrial' }}</title>
    <meta content="Showcase de actividades prácticas para la asignatura Tecnología Web 2" name="description" />
    
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            bg: '#1D1815',
                            surface: '#37312D',
                            border: '#56514B',
                            accent: '#BF4A5B',
                            hover: '#FFA9BA',
                            heading: '#F5F0EB',
                            muted: '#9C998F',
                            secondary: '#A89E8B',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <style data-purpose="custom-scroll">
        /* Custom Dark Scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #1D1815; }
        ::-webkit-scrollbar-thumb { background: #56514B; border: 2px solid #1D1815; }
        ::-webkit-scrollbar-thumb:hover { background: #BF4A5B; }
    </style>
    
    <style data-purpose="industrial-effects">
        /* Grid Overlay for Hero */
        .grid-pattern {
            background-image: radial-gradient(#56514B 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        /* Reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        /* Card Hover Interaction */
        .activity-card { transition: transform 0.2s ease; }
        .activity-card:hover { border-left: 4px solid #BF4A5B; }
    </style>
</head>

<body class="bg-brand-bg text-brand-secondary font-sans selection:bg-brand-accent selection:text-white min-h-screen flex flex-col">
    
    <nav class="fixed top-0 left-0 w-full z-50 bg-brand-bg/95 border-b border-brand-border backdrop-blur-sm" data-purpose="main-navigation">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="bg-brand-accent text-brand-heading px-3 py-1 font-bold tracking-tighter text-xl">
                TW2
            </div>
            <div class="hidden md:flex gap-8 items-center text-sm font-medium uppercase tracking-widest">
                <a class="text-brand-muted hover:text-brand-hover transition-colors" href="#actividades">Actividades</a>
                <a class="text-brand-muted hover:text-brand-hover transition-colors" href="#equipo">Integrantes</a>
                <a class="flex items-center gap-2 text-brand-heading hover:text-brand-hover transition-colors" href="https://github.com/NicoBA007/tecnologia-web-2" target="_blank">
                    GITHUB
                    <svg class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"></path>
                    </svg>
                </a>
            </div>
            <button class="md:hidden text-brand-heading">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </button>
        </div>
    </nav>

    <main class="flex-grow pt-20"> {{ $slot }}
    </main>

    <script data-purpose="reveal-animations">
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
    <script data-purpose="smooth-scroll-fix">
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80, // Offset for fixed navbar
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>