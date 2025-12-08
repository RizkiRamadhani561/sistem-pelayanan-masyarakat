<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mode === 'create' ? 'Tambah' : 'Edit' ?> Berita - Sistem Pelayanan Masyarakat</title>
    <link href="/assets/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .admin-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin: -50px auto 0;
            max-width: 1000px;
            position: relative;
        }

        .admin-content {
            padding: 3rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e9ecef;
        }

        .form-header h2 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .form-header h2 i {
            color: #667eea;
            font-size: 1.5rem;
        }

        .form-header p {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 0;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
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

        .form-label.required::after {
            content: '*';
            color: #dc3545;
            font-weight: bold;
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

        .character-count {
            font-size: 0.8rem;
            color: #6c757d;
            text-align: right;
            margin-top: 0.25rem;
        }

        .excerpt-preview {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #495057;
            min-height: 60px;
        }

        .image-upload-section {
            position: relative;
        }

        .current-image {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .current-image img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }

        .remove-image-btn {
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

        .remove-image-btn:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .image-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .image-upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .image-upload-area.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .upload-text {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .upload-hint {
            font-size: 0.875rem;
            color: #adb5bd;
        }

        .status-options {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .status-option {
            flex: 1;
        }

        .status-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .status-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .status-card.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .status-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .status-published .status-icon {
            color: #28a745;
        }

        .status-draft .status-icon {
            color: #6c757d;
        }

        .status-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .status-description {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .form-actions {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-submit:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }

        .btn-cancel {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
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
            .admin-header h1 {
                font-size: 2rem;
            }

            .admin-container {
                margin: -30px 1rem 0;
                border-radius: 15px;
            }

            .admin-content {
                padding: 2rem 1.5rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .status-options {
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-actions {
                padding: 1.5rem;
            }

            .btn-submit, .btn-cancel {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Admin Header -->
    <section class="admin-header">
        <div class="container">
            <h1><i class="bi bi-pencil-square me-3"></i><?= $mode === 'create' ? 'Tambah' : 'Edit' ?> Berita</h1>
            <p><?= $mode === 'create' ? 'Buat berita baru untuk sistem pelayanan masyarakat' : 'Perbarui informasi berita yang sudah ada' ?></p>
        </div>
    </section>

    <!-- Admin Container -->
    <div class="container admin-container">

        <!-- Admin Content -->
        <div class="admin-content">

            <!-- Form Header -->
            <div class="form-header">
                <h2>
                    <i class="bi bi-file-earmark-text"></i>
                    Form Berita
                </h2>
                <p>Isi informasi berita dengan lengkap dan akurat</p>
            </div>

            <!-- Alert Messages -->
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form id="berita-form" action="<?= $mode === 'create' ? '/admin/berita/store' : '/admin/berita/' . ($berita['id_berita'] ?? '') . '/update' ?>" method="POST" enctype="multipart/form-data">

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Informasi Dasar
                    </h3>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="judul" class="form-label required">
                                    <i class="bi bi-type"></i>Judul Berita
                                </label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                       value="<?= esc($berita['judul'] ?? old('judul')) ?>" required>
                                <small class="form-text text-muted">Judul harus deskriptif dan menarik perhatian</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="excerpt" class="form-label">
                            <i class="bi bi-card-text"></i>Ringkasan (Excerpt)
                        </label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3"
                                  placeholder="Ringkasan singkat berita (opsional, akan dibuat otomatis jika kosong)"><?= esc($berita['excerpt'] ?? old('excerpt')) ?></textarea>
                        <small class="form-text text-muted">Ringkasan akan ditampilkan di daftar berita. Maksimal 300 karakter.</small>
                        <div class="character-count">
                            <span id="excerpt-count">0</span>/300 karakter
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="isi" class="form-label required">
                            <i class="bi bi-file-text"></i>Isi Berita
                        </label>
                        <textarea class="form-control" id="isi" name="isi" rows="15" required><?= esc($berita['isi'] ?? old('isi')) ?></textarea>
                        <small class="form-text text-muted">Tulis isi berita secara lengkap dan informatif</small>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-camera"></i>
                        Gambar Berita
                    </h3>

                    <?php if (isset($berita['gambar']) && $berita['gambar']): ?>
                        <div class="current-image">
                            <img src="/<?= $berita['gambar'] ?>" alt="Gambar Berita Saat Ini">
                            <button type="button" class="remove-image-btn" onclick="removeCurrentImage()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <p class="text-muted mb-3">Gambar saat ini akan diganti jika Anda upload gambar baru</p>
                    <?php endif; ?>

                    <div class="image-upload-area" id="image-upload-area">
                        <i class="bi bi-cloud-upload upload-icon"></i>
                        <div class="upload-text">Klik untuk memilih gambar atau seret ke sini</div>
                        <div class="upload-hint">Format: JPG, PNG, WebP. Maksimal 2MB. Ukuran optimal: 800x600px</div>
                        <input type="file" id="gambar" name="gambar" accept="image/*" style="display: none;">
                    </div>
                </div>

                <!-- Status & Settings -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="bi bi-gear"></i>
                        Status & Pengaturan
                    </h3>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="bi bi-toggle-on"></i>Status Publikasi
                        </label>
                        <div class="status-options">
                            <div class="status-option">
                                <input type="radio" id="status-draft" name="status" value="draft"
                                       <?= (!isset($berita['status']) || $berita['status'] === 'draft') ? 'checked' : '' ?> style="display: none;">
                                <label for="status-draft" class="status-card status-draft" onclick="selectStatus('draft')">
                                    <i class="bi bi-pencil-square status-icon"></i>
                                    <div class="status-title">Draft</div>
                                    <div class="status-description">Berita disimpan sebagai draf, belum dipublikasikan</div>
                                </label>
                            </div>
                            <div class="status-option">
                                <input type="radio" id="status-published" name="status" value="published"
                                       <?= (isset($berita['status']) && $berita['status'] === 'published') ? 'checked' : '' ?> style="display: none;">
                                <label for="status-published" class="status-card status-published" onclick="selectStatus('published')">
                                    <i class="bi bi-send status-icon"></i>
                                    <div class="status-title">Published</div>
                                    <div class="status-description">Berita akan dipublikasikan dan dapat dilihat publik</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/admin/berita" class="btn-cancel">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn-submit" id="submit-btn">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= $mode === 'create' ? 'Publikasikan Berita' : 'Perbarui Berita' ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loading-overlay">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mt-2">Menyimpan berita...</div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/bootstrap4/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let selectedImage = null;
            let removeCurrentImageFlag = false;

            // Character count for excerpt
            $('#excerpt').on('input', function() {
                const count = $(this).val().length;
                $('#excerpt-count').text(count);

                if (count > 300) {
                    $(this).val($(this).val().substring(0, 300));
                    $('#excerpt-count').text(300);
                }
            });

            // Auto-generate excerpt from content
            $('#isi').on('input', function() {
                if (!$('#excerpt').val()) {
                    const content = $(this).val();
                    const excerpt = content.length > 150 ? content.substring(0, 150) + '...' : content;
                    $('#excerpt').val(excerpt);
                    $('#excerpt').trigger('input');
                }
            });

            // Image upload handling
            $('#image-upload-area').on('click', function() {
                $('#gambar').click();
            });

            $('#gambar').on('change', function() {
                const file = this.files[0];
                if (file) {
                    selectedImage = file;

                    // Validate file
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak valid. Harap pilih file gambar (JPG, PNG, WebP)');
                        return;
                    }

                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB');
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-upload-area').html(`
                            <img src="${e.target.result}" style="max-width: 200px; max-height: 150px; border-radius: 10px; margin-bottom: 1rem;">
                            <div class="upload-text">${file.name}</div>
                            <div class="upload-hint">Klik untuk mengganti gambar</div>
                        `);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Drag and drop
            $('#image-upload-area').on('dragover dragenter', function(e) {
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
                    selectedImage = files[0];
                    $('#gambar').prop('files', files);
                    $('#gambar').trigger('change');
                }
            });

            // Remove current image
            window.removeCurrentImage = function() {
                if (confirm('Apakah Anda yakin ingin menghapus gambar saat ini?')) {
                    $('.current-image').remove();
                    removeCurrentImageFlag = true;

                    // Reset upload area
                    $('#image-upload-area').html(`
                        <i class="bi bi-cloud-upload upload-icon"></i>
                        <div class="upload-text">Klik untuk memilih gambar atau seret ke sini</div>
                        <div class="upload-hint">Format: JPG, PNG, WebP. Maksimal 2MB</div>
                    `);
                }
            };

            // Status selection
            window.selectStatus = function(status) {
                // Update radio buttons
                $('input[name="status"]').prop('checked', false);
                $('#status-' + status).prop('checked', true);

                // Update visual selection
                $('.status-card').removeClass('selected');
                $('.status-' + status).addClass('selected');
            };

            // Initialize status selection
            const currentStatus = $('input[name="status"]:checked').val();
            if (currentStatus) {
                selectStatus(currentStatus);
            }

            // Form validation and submission
            $('#berita-form').on('submit', function(e) {
                const submitBtn = $('#submit-btn');
                const originalText = submitBtn.html();

                // Show loading
                $('#loading-overlay').fadeIn();
                submitBtn.prop('disabled', true).html('<i class="bi bi-spinner bi-spin me-1"></i>Menyimpan...');

                // Validate required fields
                let isValid = true;
                const requiredFields = ['judul', 'isi', 'status'];

                requiredFields.forEach(field => {
                    const element = $('#' + field);
                    if (!element.val() || element.val().trim() === '') {
                        element.addClass('is-invalid');
                        isValid = false;
                    } else {
                        element.removeClass('is-invalid');
                    }
                });

                // Check if image is provided for new berita
                if ('<?= $mode ?>' === 'create' && !selectedImage) {
                    alert('Harap pilih gambar untuk berita');
                    isValid = false;
                }

                if (!isValid) {
                    $('#loading-overlay').fadeOut();
                    submitBtn.prop('disabled', false).html(originalText);
                    e.preventDefault();
                    return false;
                }

                // Add hidden field to remove current image if needed
                if (removeCurrentImageFlag) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_current_image',
                        value: '1'
                    }).appendTo($(this));
                }
            });

            // Remove validation styling on input
            $('.form-control').on('input', function() {
                $(this).removeClass('is-invalid');
            });

            // Auto-save draft (optional feature)
            let autoSaveTimeout;
            $('#judul, #isi, #excerpt').on('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(function() {
                    // Could implement auto-save to localStorage here
                    console.log('Content changed - could auto-save draft');
                }, 2000);
            });
        });
    </script>

</body>
</html>
