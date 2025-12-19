<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .profile-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .profile-hero h1 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .profile-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .profile-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -50px auto 0;
            max-width: 1000px;
            position: relative;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            color: white;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        }

        .avatar-upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 1.5rem;
        }

        .profile-avatar:hover .avatar-upload-overlay {
            opacity: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .profile-role {
            font-size: 1rem;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 1rem;
            border-radius: 20px;
            display: inline-block;
            font-weight: 500;
        }

        .profile-nav {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .profile-nav .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .profile-nav .nav-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .profile-nav .nav-link.active {
            color: #667eea;
            background: white;
            font-weight: 600;
            box-shadow: 0 -3px 0 #667eea;
        }

        .profile-content {
            padding: 2rem;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .form-section h4 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section h4 i {
            color: #667eea;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #667eea;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }

        .btn-update {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-update:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }

        .photo-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .photo-upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .photo-upload-area.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .photo-upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .photo-upload-text {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .photo-upload-hint {
            font-size: 0.875rem;
            color: #adb5bd;
        }

        .current-photo {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .delete-photo-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .delete-photo-btn:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        @media (max-width: 768px) {
            .profile-hero h1 {
                font-size: 2rem;
            }

            .profile-container {
                margin: -30px 1rem 0;
                border-radius: 15px;
            }

            .profile-header {
                padding: 1.5rem;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-content {
                padding: 1.5rem;
            }

            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Profil -->
    <section class="profile-hero">
        <div class="container">
            <h1><i class="bi bi-person-circle me-3"></i>Pengaturan Profil</h1>
            <p>Kelola informasi pribadi dan pengaturan akun Anda</p>
        </div>
    </section>

    <!-- Profile Container -->
    <div class="container profile-container">

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="current-photo">
                <img src="<?= $warga['foto_profil'] ? base_url('uploads/profiles/' . $warga['foto_profil']) : 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNjAiIHI9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNDUiIHI9IjIwIiBmaWxsPSIjQ0RDQ0RBIi8+CjxwYXRoIGQ9Ik0yMCA5NWgxMDB2MjBIMjB2LTIweiIgZmlsbD0iIzlCOUI5NCIvPgo8L3N2Zz4K' ?>"
                     alt="Foto Profil" class="profile-avatar" id="profile-avatar">
                <div class="avatar-upload-overlay">
                    <i class="bi bi-camera"></i>
                </div>
            </div>
            <h2 class="profile-name"><?= esc($warga['nama_lengkap']) ?></h2>
            <div class="profile-role">
                <i class="bi bi-person-badge me-1"></i>Warga
            </div>
        </div>

        <!-- Profile Navigation -->
        <nav class="profile-nav">
            <div class="container-fluid">
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $activeTab === 'profile' ? 'active' : '' ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                            <i class="bi bi-person me-1"></i>Informasi Profil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $activeTab === 'photo' ? 'active' : '' ?>" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo" type="button" role="tab">
                            <i class="bi bi-camera me-1"></i>Foto Profil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $activeTab === 'password' ? 'active' : '' ?>" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                            <i class="bi bi-shield-lock me-1"></i>Ubah Kata Sandi
                        </button>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Profile Content -->
        <div class="profile-content">
            <div class="tab-content" id="profileTabContent">

                <!-- Profile Information Tab -->
                <div class="tab-pane fade <?= $activeTab === 'profile' ? 'show active' : '' ?>" id="profile" role="tabpanel">
                    <div class="form-section">
                        <h4><i class="bi bi-person-lines-fill"></i>Informasi Personal</h4>

                        <!-- Alert Messages -->
                        <div id="profile-alert" class="alert" style="display: none;" role="alert"></div>

                        <form id="profile-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_lengkap" class="form-label">
                                            <i class="bi bi-person"></i>Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                               value="<?= esc($warga['nama_lengkap']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope"></i>Email
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= esc($warga['email']) ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_telepon" class="form-label">
                                            <i class="bi bi-telephone"></i>Nomor Telepon
                                        </label>
                                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                                               value="<?= esc($warga['no_telepon']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-label">
                                            <i class="bi bi-calendar"></i>Tanggal Lahir
                                        </label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                               value="<?= esc($warga['tanggal_lahir']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alamat" class="form-label">
                                    <i class="bi bi-geo-alt"></i>Alamat Lengkap
                                </label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= esc($warga['alamat']) ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-label">
                                            <i class="bi bi-gender-ambiguous"></i>Jenis Kelamin
                                        </label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" <?= $warga['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= $warga['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pekerjaan" class="form-label">
                                            <i class="bi bi-briefcase"></i>Pekerjaan
                                        </label>
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                               value="<?= esc($warga['pekerjaan']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kewarganegaraan" class="form-label">
                                            <i class="bi bi-flag"></i>Kewarganegaraan
                                        </label>
                                        <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan"
                                               value="<?= esc($warga['kewarganegaraan']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-update" id="update-profile-btn">
                                    <i class="bi bi-check-circle me-1"></i>Perbarui Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Photo Upload Tab -->
                <div class="tab-pane fade <?= $activeTab === 'photo' ? 'show active' : '' ?>" id="photo" role="tabpanel">
                    <div class="form-section">
                        <h4><i class="bi bi-camera-fill"></i>Foto Profil</h4>

                        <!-- Alert Messages -->
                        <div id="photo-alert" class="alert" style="display: none;" role="alert"></div>

                        <?php if ($warga['foto_profil']): ?>
                            <div class="text-center mb-4">
                                <h6>Foto Profil Saat Ini</h6>
                                <div class="current-photo">
                                    <img src="<?= base_url('uploads/profiles/' . $warga['foto_profil']) ?>"
                                         alt="Foto Profil Saat Ini" class="profile-avatar">
                                    <button type="button" class="delete-photo-btn" id="delete-photo-btn"
                                            title="Hapus Foto Profil">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="photo-upload-area" id="photo-upload-area">
                            <i class="bi bi-cloud-upload photo-upload-icon"></i>
                            <div class="photo-upload-text">Klik untuk memilih foto atau seret ke sini</div>
                            <div class="photo-upload-hint">Format: JPG, PNG, WebP. Maksimal 2MB</div>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;">
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-update" id="upload-photo-btn" style="display: none;">
                                <i class="bi bi-upload me-1"></i>Upload Foto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Change Tab -->
                <div class="tab-pane fade <?= $activeTab === 'password' ? 'show active' : '' ?>" id="password" role="tabpanel">
                    <div class="form-section">
                        <h4><i class="bi bi-shield-lock-fill"></i>Ubah Kata Sandi</h4>

                        <!-- Alert Messages -->
                        <div id="password-alert" class="alert" style="display: none;" role="alert"></div>

                        <form id="password-form">
                            <div class="form-group">
                                <label for="current_password" class="form-label">
                                    <i class="bi bi-key"></i>Kata Sandi Lama
                                </label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="bi bi-lock"></i>Kata Sandi Baru
                                </label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <div class="password-strength" id="password-strength"></div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label">
                                    <i class="bi bi-lock-fill"></i>Konfirmasi Kata Sandi Baru
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-update" id="change-password-btn">
                                    <i class="bi bi-check-circle me-1"></i>Ubah Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loading-overlay">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mt-2">Memproses...</div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show loading overlay
            function showLoading() {
                $('#loading-overlay').fadeIn();
            }

            // Hide loading overlay
            function hideLoading() {
                $('#loading-overlay').fadeOut();
            }

            // Show alert message
            function showAlert(elementId, type, message) {
                const alert = $('#' + elementId);
                alert.removeClass('alert-success alert-danger').addClass('alert-' + type).html(message).fadeIn();

                // Auto hide after 5 seconds
                setTimeout(() => {
                    alert.fadeOut();
                }, 5000);
            }

            // Profile Update
            $('#profile-form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $('#update-profile-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="bi bi-spinner bi-spin me-1"></i>Memperbarui...');
                showLoading();

                $.ajax({
                    url: '/profile/update',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            showAlert('profile-alert', 'success', '<i class="bi bi-check-circle me-1"></i>' + response.message);
                            // Update displayed name if changed
                            if (response.data && response.data.nama_lengkap) {
                                $('.profile-name').text(response.data.nama_lengkap);
                            }
                        } else {
                            showAlert('profile-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>' + response.message);

                            // Show validation errors
                            if (response.errors) {
                                Object.keys(response.errors).forEach(field => {
                                    const input = $('#' + field);
                                    input.addClass('is-invalid');
                                    if (!input.next('.invalid-feedback').length) {
                                        input.after('<div class="invalid-feedback">' + response.errors[field] + '</div>');
                                    }
                                });
                            }
                        }
                    },
                    error: function() {
                        showAlert('profile-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>Terjadi kesalahan sistem. Silakan coba lagi.');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                        hideLoading();
                    }
                });
            });

            // Remove validation errors on input
            $('.form-control').on('input', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            // Photo Upload
            let selectedFile = null;

            $('#profile-avatar, #photo-upload-area').on('click', function() {
                $('#profile_photo').click();
            });

            $('#profile_photo').on('change', function() {
                const file = this.files[0];
                if (file) {
                    selectedFile = file;
                    $('#upload-photo-btn').fadeIn();

                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile-avatar').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop
            $('#photo-upload-area').on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            }).on('dragleave dragend drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            }).on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    selectedFile = files[0];
                    $('#profile_photo').prop('files', files);
                    $('#upload-photo-btn').fadeIn();

                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile-avatar').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(selectedFile);
                }
            });

            $('#upload-photo-btn').on('click', function() {
                if (!selectedFile) return;

                const formData = new FormData();
                formData.append('profile_photo', selectedFile);

                const btn = $(this);
                const originalText = btn.html();

                btn.prop('disabled', true).html('<i class="bi bi-spinner bi-spin me-1"></i>Mengupload...');
                showLoading();

                $.ajax({
                    url: '/profile/upload-photo',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            showAlert('photo-alert', 'success', '<i class="bi bi-check-circle me-1"></i>' + response.message);
                            $('#upload-photo-btn').fadeOut();
                            selectedFile = null;

                            // Add delete button if not exists
                            if (!$('.delete-photo-btn').length) {
                                $('.current-photo').append('<button type="button" class="delete-photo-btn" id="delete-photo-btn" title="Hapus Foto Profil"><i class="bi bi-x"></i></button>');
                            }
                        } else {
                            showAlert('photo-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>' + response.message);
                        }
                    },
                    error: function() {
                        showAlert('photo-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>Terjadi kesalahan sistem. Silakan coba lagi.');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalText);
                        hideLoading();
                    }
                });
            });

            // Delete Photo
            $(document).on('click', '#delete-photo-btn', function() {
                if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;

                const btn = $(this);
                btn.prop('disabled', true).html('<i class="bi bi-spinner bi-spin"></i>');
                showLoading();

                $.ajax({
                    url: '/profile/delete-photo',
                    method: 'POST',
                    success: function(response) {
                        if (response.success) {
                            showAlert('photo-alert', 'success', '<i class="bi bi-check-circle me-1"></i>' + response.message);
                            $('#profile-avatar').attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNjAiIHI9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNDUiIHI9IjIwIiBmaWxsPSIjQ0RDQ0RBIi8+CjxwYXRoIGQ9Ik0yMCA5NWgxMDB2MjBIMjB2LTIweiIgZmlsbD0iIzlCOUI5NCIvPgo8L3N2Zz4K');
                            btn.remove();
                        } else {
                            showAlert('photo-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>' + response.message);
                        }
                    },
                    error: function() {
                        showAlert('photo-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>Terjadi kesalahan sistem. Silakan coba lagi.');
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            });

            // Password Strength Indicator
            $('#new_password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                const strengthEl = $('#password-strength');

                if (password.length === 0) {
                    strengthEl.html('');
                    return;
                }

                let strengthText = '';
                let strengthClass = '';

                switch (strength) {
                    case 'weak':
                        strengthText = 'Lemah - Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus';
                        strengthClass = 'strength-weak';
                        break;
                    case 'medium':
                        strengthText = 'Sedang - Tambahkan karakter khusus untuk kekuatan lebih baik';
                        strengthClass = 'strength-medium';
                        break;
                    case 'strong':
                        strengthText = 'Kuat - Kata sandi sangat aman!';
                        strengthClass = 'strength-strong';
                        break;
                }

                strengthEl.html('<i class="bi bi-shield-' + (strength === 'strong' ? 'check' : 'exclamation') + ' me-1"></i>' + strengthText)
                         .removeClass('strength-weak strength-medium strength-strong')
                         .addClass(strengthClass);
            });

            function checkPasswordStrength(password) {
                let score = 0;

                // Length check
                if (password.length >= 8) score++;

                // Character variety checks
                if (/[a-z]/.test(password)) score++; // lowercase
                if (/[A-Z]/.test(password)) score++; // uppercase
                if (/[0-9]/.test(password)) score++; // numbers
                if (/[^A-Za-z0-9]/.test(password)) score++; // special characters

                if (score < 3) return 'weak';
                if (score < 5) return 'medium';
                return 'strong';
            }

            // Password Change
            $('#password-form').on('submit', function(e) {
                e.preventDefault();

                const submitBtn = $('#change-password-btn');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html('<i class="bi bi-spinner bi-spin me-1"></i>Mengubah...');
                showLoading();

                $.ajax({
                    url: '/profile/change-password',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            showAlert('password-alert', 'success', '<i class="bi bi-check-circle me-1"></i>' + response.message);
                            $('#password-form')[0].reset();
                            $('#password-strength').html('');
                        } else {
                            showAlert('password-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>' + response.message);
                        }
                    },
                    error: function() {
                        showAlert('password-alert', 'danger', '<i class="bi bi-exclamation-triangle me-1"></i>Terjadi kesalahan sistem. Silakan coba lagi.');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                        hideLoading();
                    }
                });
            });

            // Tab persistence
            $('.nav-link').on('click', function() {
                const tabId = $(this).attr('data-bs-target').substring(1);
                const url = new URL(window.location);
                url.searchParams.set('tab', tabId);
                window.history.pushState({}, '', url);
            });
        });
    </script>

</body>
</html>
