<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión | Gestión de Bienes</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/static/img/icons/icon-48x48.png') ?>" />

    <!-- Estilos de AdminKit -->
    <link href="<?= base_url('public/static/css/app.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Video de fondo */
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            object-fit: cover;
        }

        /* Capa oscura encima del video */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .logo-login {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- 🎥 Video de fondo -->
    <video autoplay muted loop playsinline class="video-bg">
        <source src="<?= base_url('public/static/img/ISTVL.mp4') ?>" type="video/mp4">
        Tu navegador no soporta videos HTML5.
    </video>
    <div class="overlay"></div>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="card mt-3">
                            <div class="card-header text-center bg-transparent border-0">
                                <img src="<?= base_url('public/static/img/icons/logo.png') ?>" alt="Logo"
                                    class="logo-login mb-3">
                                <h1 class="h3 text-dark">Bienvenido</h1>
                                <p class="text-muted">Ingrese sus credenciales para continuar</p>
                            </div>
                            <div class="card-body">
                                <form method="post" action="<?= site_url('login') ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Usuario</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input class="form-control" type="text" name="usuario"
                                                placeholder="Ingrese su usuario" required autofocus />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input class="form-control" type="password" name="password" id="password"
                                                placeholder="Ingrese su contraseña" required />
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div class="d-grid gap-2 mt-4">
                                            <button type="submit" class="btn btn-lg btn-primary">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-light mt-3">
                        <small>&copy; <?= date('Y') ?> - Sistema de Gestión de Bienes</small>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="<?= base_url('public/static/js/app.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // 👁️ Mostrar/Ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            const isHidden = passwordField.type === 'password';
            passwordField.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });

        // 🔔 Configuración de Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000",
            "extendedTimeOut": "1000",
            "showDuration": "300",
            "hideDuration": "1000"
        };

        // ⚙️ Mostrar mensajes flash si existen
        <?php if (session()->getFlashdata('error')): ?>
            toastr.error("<?= esc(session()->getFlashdata('error')) ?>");
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            toastr.success("<?= esc(session()->getFlashdata('success')) ?>");
        <?php endif; ?>
    </script>
</body>

</html>