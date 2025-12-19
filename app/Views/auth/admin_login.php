<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-5">
            <div class="card shadow-lg border-0 fade-in">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Login Admin/Petugas
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">Akses panel administrasi sistem</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <!-- Success/Error Messages -->
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/login" method="post" id="adminLoginForm">
                        <?= csrf_field() ?>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope me-1"></i>Email
                            </label>
                            <input type="email" class="form-control form-control-lg <?= (isset($errors['email'])) ? 'is-invalid' : '' ?>"
                                   id="email" name="email" placeholder="admin@sistem.com"
                                   value="<?= old('email') ?>" required autofocus>
                            <div class="form-text">Masukkan email admin atau petugas</div>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">
                                <i class="bi bi-lock me-1"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg <?= (isset($errors['password'])) ? 'is-invalid' : '' ?>"
                                       id="password" name="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Password untuk akses admin/petugas</div>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <?= $errors['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Akun Demo:</strong><br>
                            <strong>Admin:</strong> admin@sistem.com / admin123<br>
                            <strong>Petugas:</strong> petugas@sistem.com / petugas123
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-dark btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Login Admin/Petugas
                            </button>
                        </div>

                        <!-- Back to Public Login -->
                        <div class="text-center">
                            <p class="mb-0">Ingin login sebagai warga?
                                <a href="/login" class="text-decoration-none fw-bold text-primary">Login Warga</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Info -->
            <div class="row mt-4 g-3">
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-dark mb-1">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Admin</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body py-3">
                            <div class="text-info mb-1">
                                <i class="bi bi-person-workspace fs-4"></i>
                            </div>
                            <small class="text-muted d-block">Petugas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const icon = this.querySelector('i');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Form validation
document.getElementById('adminLoginForm').addEventListener('submit', function(e) 
{
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    let isValid = true;

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        email.classList.add('is-invalid');
        if (!email.nextElementSibling || !email.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Format email tidak valid';
            email.parentNode.insertBefore(feedback, email.nextSibling);
        }
        isValid = false;
    }

    // Password validation
    if (password.value.length < 6) {
        password.classList.add('is-invalid');
        if (!password.parentNode.nextElementSibling || !password.parentNode.nextElementSibling.classList.contains('invalid-feedback')) {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Password minimal 6 karakter';
            password.parentNode.parentNode.insertBefore(feedback, password.parentNode.nextSibling);
        }
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});

// Auto-focus on email field
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('email').focus();
});
</script>
<?= $this->endSection() ?>
