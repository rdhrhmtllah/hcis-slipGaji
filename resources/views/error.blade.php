<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success - HCIS EVO</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
           --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #1e293b;
            --surface: #ffffff;
            --surface-soft: #f1f5f9;
            --border: #e2e8f0;
            --text: #334155;
            --text-muted: #64748b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-dark: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--surface);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            /* box-shadow: var(--shadow-lg); */
            max-width: 500px;
            width: 100%;
            animation: slideInUp 0.8s ease-out;
            overflow: hidden;
        }

        .success-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 0rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .success-body {
            padding: 2rem 0rem;
            text-align: center;
        }

        .success-icon {
            font-size: 2.5rem;
            color: var(--surface);
            margin-bottom: 0rem;
            animation: bounceIn 1s;
        }

        .countdown {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            margin: 1.5rem 0;
        }

        .btn-whatsapp {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(113, 88, 181, 0.4);
        }

        .btn-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(113, 88, 181, 0.5);
            color: white;
        }

        .spinner-whatsapp {
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto 1.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }
            0% {
                opacity: 0;
                transform: scale3d(.3, .3, .3);
            }
            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                transform: scale3d(.9, .9, .9);
            }
            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                transform: scale3d(.97, .97, .97);
            }
            100% {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }
    </style>
</head>
<body>
    <div class="success-card animate__animated animate__fadeIn shadow-lg">
        <div class="success-header">
            <div class="success-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <h4 class="mb-0">Akses Ditolak!</h4>
        </div>
        <div class="success-body mb-3">
            <p class="lead fs-5 mb-4">  Maaf, kami tidak dapat memproses permintaan Anda.
            @if (isset($message))
                <br><strong>{{ $message }}</strong>
            @else
                <br>Token yang Anda gunakan tidak valid atau sudah kedaluwarsa.
            @endif</p>



            <a href="/newUrl" class="btn btn-whatsapp">
                <i class="bi bi-whatsapp"></i> Buat URL Baru
            </a>
        </div>
    </div>


</body>
</html>
