<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - HCIS EVO</title>
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
            position: relative;
            overflow-x: hidden;
        }

        /* Main Container */
        .login-wrapper {
            min-height: 100vh;
            backdrop-filter: blur(5px);
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideInUp 0.8s ease-out;
        }

        .login-header {
            background: var(--primary-gradient);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            padding: 1rem;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .login-title {
            color: #2d3748;
            font-weight: 700;
        }

        .login-subtitle {
            color: #718096;
            font-size: 0.95rem;
        }

        /* Form Styling */
        .form-label {
            color: #4a5568;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-group .form-control:focus {
            z-index: 2;
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: 0 12px 12px 0;
            border-left: none;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Password Strength */
        .password-strength {
            height: 5px;
            margin-top: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        /* Links */
        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(10px);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            color: #0f5132;
            border: 1px solid rgba(25, 135, 84, 0.2);
        }

        .text-danger {
            color: #dc3545 !important;
            font-size: 0.85rem;
        }

        /* Modern Buttons */
        .btn-modern {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(20px);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: var(--text);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
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

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                margin: 1rem;
                border-radius: 20px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>
<body>

    <!-- Alert untuk error/success -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
        @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__slideInRight" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__slideInRight" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>

    <!-- Main Container -->
    <div class="login-wrapper d-flex align-items-center justify-content-center p-3">
        <div class="login-card shadow-lg">
            <!-- Header Section -->
            <div class="login-header text-center">
                <img src="{{ asset('images/logo-lg.png') }}" alt="Logo" width="20%" style="height: fit-content">
            </div>

            <!-- Form Section -->
            <div class="p-4">
                <form method="POST" action="{{ route('password.update') }}" id="passwordResetForm">
                    @csrf

                    <!-- Hidden token field -->

                    <!-- Email Address -->
                    {{-- <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i>Email Address
                        </label>
                        <input id="email"
                               type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ $email ?? old('email') }}"
                               required
                               autocomplete="email"
                               autofocus>
                        @error('email')
                            <div class="text-danger mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i>New Password
                        </label>
                        <div class="input-group">
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required
                                   autocomplete="new-password">
                            <button class="btn btn-outline-primary"
                                    type="button"
                                    id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="strength-meter" id="strengthMeter"></div>
                        </div>
                        <div class="form-text text-muted">Use 8 or more characters with a mix of letters, numbers & symbols</div>
                        @error('password')
                            <div class="text-danger mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">
                            <i class="bi bi-lock me-1"></i>Confirm Password
                        </label>
                        <div class="input-group">
                            <input id="password-confirm"
                                   type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password">
                            <button class="btn btn-outline-primary"
                                    type="button"
                                    id="toggleConfirmPassword">
                                <i class="bi bi-eye" id="confirmEyeIcon"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="form-text text-muted"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn-modern btn-primary btn-lg justify-content-center">
                            <i class="bi bi-key me-2"></i>Reset Password
                        </button>
                    </div>

                    {{-- <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="forgot-link">
                            <i class="bi bi-arrow-left me-1"></i>Back to Login
                        </a>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.className = 'bi bi-eye-slash';
            } else {
                passwordField.type = 'password';
                eyeIcon.className = 'bi bi-eye';
            }
        });

        // Confirm Password toggle functionality
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordField = document.getElementById('password-confirm');
            const confirmEyeIcon = document.getElementById('confirmEyeIcon');

            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                confirmEyeIcon.className = 'bi bi-eye-slash';
            } else {
                confirmPasswordField.type = 'password';
                confirmEyeIcon.className = 'bi bi-eye';
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Form submission loading state
        const form = document.getElementById('passwordResetForm');
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...';
            button.disabled = true;
        });

        // Password strength meter
        document.getElementById('password').addEventListener('input', function() {
            const strengthMeter = document.getElementById('strengthMeter');
            const strength = calculatePasswordStrength(this.value);

            strengthMeter.style.width = strength.percentage + '%';
            strengthMeter.style.backgroundColor = strength.color;

            // Check password match
            if(document.getElementById('password-confirm').value.length > 0) {
                checkPasswordMatch();
            }
        });

        // Password match checker
        document.getElementById('password-confirm').addEventListener('input', checkPasswordMatch);

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            const matchText = document.getElementById('passwordMatch');

            if(password !== confirmPassword) {
                matchText.innerHTML = '<i class="bi bi-x-circle text-danger me-1"></i>Passwords do not match';
                matchText.classList.remove('text-success');
                matchText.classList.add('text-danger');
            } else if(password.length > 0) {
                matchText.innerHTML = '<i class="bi bi-check-circle text-success me-1"></i>Passwords match';
                matchText.classList.remove('text-danger');
                matchText.classList.add('text-success');
            } else {
                matchText.innerHTML = '';
            }
        }

        function calculatePasswordStrength(password) {
            let strength = 0;
            let color = '#e74a3b'; // Red

            // Check length
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 15;

            // Check for mixed case
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 15;

            // Check for numbers
            if (password.match(/[0-9]/)) strength += 15;

            // Check for special chars
            if (password.match(/[^a-zA-Z0-9]/)) strength += 15;

            // Check for common patterns (deduct points)
            if (password.match(/password|1234|qwerty/i)) strength = Math.max(0, strength - 30);

            // Cap at 100
            strength = Math.min(100, strength);

            // Determine color
            if (strength > 75) {
                color = '#1cc88a'; // Green
            } else if (strength > 50) {
                color = '#f6c23e'; // Yellow
            } else if (strength > 25) {
                color = '#fd7e14'; // Orange
            }

            return { percentage: strength, color: color };
        }
    </script>
</body>
</html>
