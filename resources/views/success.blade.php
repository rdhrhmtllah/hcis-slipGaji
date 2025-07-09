<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Berhasil Diubah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            margin-top: 100px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        #countdown {
            font-weight: bold;
            color: #0d6efd;
            font-size: 1.2em;
        }
        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            background-color: #28a745;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Toast Notification -->
    @if (session('success'))
    <div class="toast-container">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white float-end" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card success-card">
                    <div class="card-header bg-success text-white text-center">
                        <h4><i class="bi bi-check-circle"></i> Password Berhasil Diubah!</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> Password Anda telah diperbarui dengan sukses.
                        </div>
                        <p>Anda akan diarahkan ke WhatsApp dalam <span id="countdown">5</span> detik...</p>
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-3">
                            <a href="https://wa.me/62879676" class="btn btn-success">
                                <i class="bi bi-whatsapp"></i> Buka WhatsApp Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Countdown & Redirect Script -->
    <script>
        // Countdown Timer
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "https://wa.me/6282280954525";
            }
        }, 1000);

        // Close Toast after 5 seconds
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) {
                toast.classList.remove('show');
            }
        }, 5000);
    </script>
</body>
</html>
