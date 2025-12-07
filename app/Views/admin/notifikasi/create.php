<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Notifikasi Baru - Sistem Pelayanan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .form-card {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            color: white;
        }
        .form-card .card-header {
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-notif {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-notif:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.4);
        }
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }
        .recipient-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .recipient-card.selected {
            border-color: #6f42c1;
            background-color: rgba(111, 66, 193, 0.05);
        }
        .recipient-card:hover {
            border-color: #6f42c1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.15);
        }
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .priority-rendah {
            background-color: #28a745;
            color: white;
        }
        .priority-sedang {
            background-color: #ffc107;
            color: #212529;
        }
        .priority-tinggi {
            background-color: #fd7e14;
            color: white;
        }
        .priority-darurat {
            background-color: #dc3545;
            color: white;
        }
        .preview-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(111, 66, 193, 0.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/notifikasi" class="text-decoration-none"><i class="fas fa-bell me-1"></i>Notifikasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Baru</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-1">
                            <i class="fas fa-plus-circle text-primary me-2"></i>Buat Notifikasi Baru
                        </h1>
                        <p class="text-muted mb-0">Kirim pesan notifikasi ke pengguna sistem</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/admin/notifikasi" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Form -->
            <div class="col-lg-8">
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Form Notifikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="notificationForm" action="/admin/notifikasi/store" method="POST">
                            <?= csrf_field() ?>

                            <!-- Pesan Notifikasi -->
                            <div class="mb-4">
                                <label for="pesan" class="form-label">
                                    <i class="fas fa-comment me-1"></i>Pesan Notifikasi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="4"
                                          placeholder="Ketik pesan notifikasi yang akan dikirim..." required></textarea>
                                <div class="form-text text-white-50">
                                    Tulis pesan yang jelas dan informatif untuk pengguna
                                </div>
                            </div>

                            <!-- Link (Opsional) -->
                            <div class="mb-4">
                                <label for="link" class="form-label">
                                    <i class="fas fa-link me-1"></i>Link Tautan (Opsional)
                                </label>
                                <input type="url" class="form-control" id="link" name="link"
                                       placeholder="https://example.com">
                                <div class="form-text text-white-50">
                                    Tambahkan link jika notifikasi memerlukan aksi lebih lanjut
                                </div>
                            </div>

                            <!-- Tipe Penerima -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-users me-1"></i>Tipe Penerima <span class="text-danger">*</span>
                                </label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="recipient-card p-3 text-center selected" data-type="semua">
                                            <i class="fas fa-users fa-2x mb-2 text-primary"></i>
                                            <h6 class="mb-1">Semua Pengguna</h6>
                                            <small class="text-muted">Kirim ke semua warga dan petugas</small>
                                            <input type="radio" name="tipe_penerima" value="semua" checked hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="recipient-card p-3 text-center" data-type="warga">
                                            <i class="fas fa-user fa-2x mb-2 text-success"></i>
                                            <h6 class="mb-1">Warga</h6>
                                            <small class="text-muted">Kirim ke semua warga terdaftar</small>
                                            <input type="radio" name="tipe_penerima" value="warga" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="recipient-card p-3 text-center" data-type="petugas">
                                            <i class="fas fa-user-tie fa-2x mb-2 text-info"></i>
                                            <h6 class="mb-1">Petugas</h6>
                                            <small class="text-muted">Kirim ke semua petugas/admin</small>
                                            <input type="radio" name="tipe_penerima" value="petugas" hidden>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="recipient-card p-3 text-center" data-type="personal">
                                            <i class="fas fa-user-tag fa-2x mb-2 text-warning"></i>
                                            <h6 class="mb-1">Personal</h6>
                                            <small class="text-muted">Kirim ke pengguna tertentu</small>
                                            <input type="radio" name="tipe_penerima" value="personal" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Penerima Personal (Hidden by default) -->
                            <div class="mb-4" id="personalRecipient" style="display: none;">
                                <label for="penerima_id" class="form-label">
                                    <i class="fas fa-user-tag me-1"></i>Pilih Penerima
                                </label>
                                <select class="form-select" id="penerima_id" name="penerima_id">
                                    <option value="">Pilih penerima...</option>
                                    <optgroup label="Warga">
                                        <?php if (!empty($warga)): ?>
                                            <?php foreach ($warga as $w): ?>
                                                <option value="<?= $w['id_warga'] ?>">
                                                    Warga - <?= htmlspecialchars($w['nama_lengkap']) ?> (NIK: <?= substr($w['nik'], 0, 8) ?>...)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                    <optgroup label="Petugas">
                                        <?php if (!empty($petugas)): ?>
                                            <?php foreach ($petugas as $p): ?>
                                                <option value="<?= $p['id_user'] ?>">
                                                    Petugas - <?= htmlspecialchars($p['nama']) ?> (<?= ucfirst($p['role']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                </select>
                            </div>

                            <!-- Prioritas -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Prioritas <span class="text-danger">*</span>
                                </label>
                                <div class="row g-2">
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="prioritas" id="rendah" value="rendah" checked>
                                        <label class="btn btn-outline-success w-100" for="rendah">
                                            <i class="fas fa-info-circle me-1"></i>Rendah
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="prioritas" id="sedang" value="sedang">
                                        <label class="btn btn-outline-warning w-100" for="sedang">
                                            <i class="fas fa-exclamation-circle me-1"></i>Sedang
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="prioritas" id="tinggi" value="tinggi">
                                        <label class="btn btn-outline-danger w-100" for="tinggi">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Tinggi
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <input type="radio" class="btn-check" name="prioritas" id="darurat" value="darurat">
                                        <label class="btn btn-outline-dark w-100" for="darurat">
                                            <i class="fas fa-siren-on me-1"></i>Darurat
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex gap-2 pt-3">
                                <button type="submit" class="btn btn-notif flex-fill">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Notifikasi
                                </button>
                                <button type="button" class="btn btn-outline-light" onclick="previewNotification()">
                                    <i class="fas fa-eye me-1"></i>Preview
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview & Info -->
            <div class="col-lg-4">
                <!-- Preview -->
                <div class="card preview-card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-eye me-1 text-primary"></i>Preview Notifikasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="previewContent">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-bell fa-2x mb-2"></i>
                                <p>Preview akan muncul saat Anda mengisi form</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Panel -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-1"></i>Informasi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6><i class="fas fa-users text-primary me-1"></i>Tipe Penerima</h6>
                            <ul class="list-unstyled small">
                                <li><strong>Semua:</strong> Kirim ke seluruh pengguna sistem</li>
                                <li><strong>Warga:</strong> Hanya pengguna dengan role warga</li>
                                <li><strong>Petugas:</strong> Admin dan petugas sistem</li>
                                <li><strong>Personal:</strong> Pengguna tertentu saja</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <h6><i class="fas fa-exclamation-triangle text-warning me-1"></i>Prioritas</h6>
                            <ul class="list-unstyled small">
                                <li><span class="priority-badge priority-rendah">Rendah</span> - Informasi umum</li>
                                <li><span class="priority-badge priority-sedang">Sedang</span> - Pembaruan penting</li>
                                <li><span class="priority-badge priority-tinggi">Tinggi</span> - Perlu perhatian segera</li>
                                <li><span class="priority-badge priority-darurat">Darurat</span> - Tindakan segera</li>
                            </ul>
                        </div>

                        <div class="alert alert-info small">
                            <i class="fas fa-lightbulb me-1"></i>
                            <strong>Tip:</strong> Gunakan prioritas yang sesuai untuk memastikan notifikasi sampai ke penerima dengan benar.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Recipient selection
        document.querySelectorAll('.recipient-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.recipient-card').forEach(c => c.classList.remove('selected'));

                // Add selected class to clicked card
                this.classList.add('selected');

                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;

                // Show/hide personal recipient field
                const personalField = document.getElementById('personalRecipient');
                if (radio.value === 'personal') {
                    personalField.style.display = 'block';
                    document.getElementById('penerima_id').required = true;
                } else {
                    personalField.style.display = 'none';
                    document.getElementById('penerima_id').required = false;
                }

                updatePreview();
            });
        });

        // Form input listeners for preview
        document.getElementById('pesan').addEventListener('input', updatePreview);
        document.getElementById('link').addEventListener('input', updatePreview);
        document.querySelectorAll('input[name="prioritas"]').forEach(radio => {
            radio.addEventListener('change', updatePreview);
        });

        // Update preview
        function updatePreview() {
            const pesan = document.getElementById('pesan').value;
            const link = document.getElementById('link').value;
            const prioritas = document.querySelector('input[name="prioritas"]:checked').value;
            const tipePenerima = document.querySelector('input[name="tipe_penerima"]:checked').value;

            let previewHtml = '';

            if (pesan.trim()) {
                const priorityClass = {
                    'rendah': 'priority-rendah',
                    'sedang': 'priority-sedang',
                    'tinggi': 'priority-tinggi',
                    'darurat': 'priority-darurat'
                };

                const priorityText = {
                    'rendah': 'Rendah',
                    'sedang': 'Sedang',
                    'tinggi': 'Tinggi',
                    'darurat': 'Darurat'
                };

                previewHtml = `
                    <div class="notification-item unread mb-3" style="border-left: 4px solid #6f42c1;">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1 ms-3">
                                <strong class="text-dark">${pesan}</strong>
                                ${link ? `<br><small class="text-primary"><i class="fas fa-link me-1"></i><a href="${link}" target="_blank">${link}</a></small>` : ''}
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Dikirim sekarang
                                    <span class="badge ${priorityClass[prioritas]} ms-2">${priorityText[prioritas]}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-users me-1"></i>Dikirim ke: ${tipePenerima === 'semua' ? 'Semua Pengguna' : tipePenerima === 'warga' ? 'Warga' : tipePenerima === 'petugas' ? 'Petugas' : 'Personal'}
                    </small>
                `;
            } else {
                previewHtml = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-bell fa-2x mb-2"></i>
                        <p>Preview akan muncul saat Anda mengisi form</p>
                    </div>
                `;
            }

            document.getElementById('previewContent').innerHTML = previewHtml;
        }

        // Preview notification
        function previewNotification() {
            updatePreview();
            // Scroll to preview
            document.getElementById('previewContent').scrollIntoView({ behavior: 'smooth' });
        }

        // Form validation
        document.getElementById('notificationForm').addEventListener('submit', function(e) {
            const pesan = document.getElementById('pesan').value.trim();
            const tipePenerima = document.querySelector('input[name="tipe_penerima"]:checked');

            if (!pesan) {
                e.preventDefault();
                alert('Pesan notifikasi tidak boleh kosong!');
                return;
            }

            if (!tipePenerima) {
                e.preventDefault();
                alert('Pilih tipe penerima!');
                return;
            }

            if (tipePenerima.value === 'personal' && !document.getElementById('penerima_id').value) {
                e.preventDefault();
                alert('Pilih penerima untuk notifikasi personal!');
                return;
            }

            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            submitBtn.disabled = true;

            // Re-enable after 10 seconds (fallback)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });

        // Initialize preview
        updatePreview();
    </script>
</body>
</html>
