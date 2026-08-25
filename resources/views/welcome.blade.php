<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'FitnessProgreso') }} - Seguimiento y Rendimiento</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                color: #0f172a;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                overflow-x: hidden;
            }
            .hero-section {
                padding: 120px 0 80px 0;
            }
            .glass-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                padding: 40px;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
                transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            }
            .glass-card:hover {
                transform: translateY(-5px);
                border-color: #cbd5e1;
                box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
            }
            .gradient-text {
                background: linear-gradient(90deg, #0f172a 0%, #334155 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .btn-gradient {
                background: #0f172a;
                border: 1px solid #0f172a;
                color: #ffffff;
                font-weight: 600;
                padding: 12px 30px;
                border-radius: 10px;
                transition: all 0.3s ease;
            }
            .btn-gradient:hover {
                background: #1e293b;
                border-color: #1e293b;
                color: white;
                box-shadow: 0 4px 15px rgba(15, 23, 42, 0.15);
            }
            .btn-outline-glass {
                background: transparent;
                border: 1px solid #cbd5e1;
                color: #0f172a;
                font-weight: 600;
                padding: 12px 30px;
                border-radius: 10px;
                transition: background 0.3s ease, border-color 0.3s ease;
            }
            .btn-outline-glass:hover {
                background: #f1f5f9;
                border-color: #cbd5e1;
                color: #0f172a;
            }
            .feature-icon {
                font-size: 2.5rem;
                margin-bottom: 20px;
                display: inline-block;
            }
            .text-secondary {
                color: #475569 !important;
            }
        </style>
    </head>
    <body class="min-vh-screen">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent pt-4">
            <div class="container">
                <a class="navbar-brand fw-bold fs-3 text-dark" href="/">
                    🏋️ <span class="gradient-text">FitProgreso</span>
                </a>
                <div class="ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ Auth::user()->dashboardRoute() }}" class="btn btn-gradient btn-sm">Ir al Panel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link text-dark text-decoration-none me-3 fw-semibold">Iniciar Sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-glass btn-sm">Registrarse</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container hero-section my-auto">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-extrabold text-dark mb-4">
                        Lleva tu rendimiento al <span class="gradient-text">siguiente nivel</span>
                    </h1>
                    <p class="lead text-secondary mb-5">
                        Plataforma inteligente de seguimiento y progreso fitness. Planifica rutinas con tu entrenador, registra entrenamientos atómicos en tiempo real con control de RIR/RPE y visualiza tus métricas corporales de forma profesional.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ Auth::user()->dashboardRoute() }}" class="btn btn-gradient px-4 py-3 fs-5">
                                Entrar a mi Panel de Control
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-gradient px-4 py-3 fs-5">
                                Comenzar Ahora
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-glass px-4 py-3 fs-5">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="glass-card">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="feature-icon">📊</div>
                                <h3 class="h5 fw-bold text-dark mb-2">Bitácora en Tiempo Real</h3>
                                <p class="text-sm text-secondary mb-0">Registra tus series, peso, repeticiones y esfuerzo percibido (RPE/RIR) de forma interactiva.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-icon">🤝</div>
                                <h3 class="h5 fw-bold text-dark mb-2">Conexión con tu Coach</h3>
                                <p class="text-sm text-secondary mb-0">Recibe rutinas personalizadas directo de tu entrenador y comparte comentarios y sensaciones.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-icon">💪</div>
                                <h3 class="h5 fw-bold text-dark mb-2">Catálogo Maestro</h3>
                                <p class="text-sm text-secondary mb-0">Acceso a un catálogo administrable de ejercicios ordenados por grupos musculares y dificultad.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-icon">📈</div>
                                <h3 class="h5 fw-bold text-dark mb-2">Progreso Visual</h3>
                                <p class="text-sm text-secondary mb-0">Seguimiento constante de tu composición corporal, peso y volumen de entrenamiento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-4 mt-5 border-top border-secondary/20">
            <div class="container text-center text-secondary">
                <p class="m-0 text-sm">&copy; {{ date('Y') }} FitProgreso. Todos los derechos reservados. Diseñado para atletas y entrenadores de alto rendimiento.</p>
            </div>
        </footer>

        <!-- Bootstrap 5 Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
