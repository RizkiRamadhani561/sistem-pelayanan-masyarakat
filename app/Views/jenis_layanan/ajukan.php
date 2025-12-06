<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="h3 mb-0">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        Ajukan Permohonan Layanan
                    </h2>
                    <p class="mb-0 mt-2 opacity-75">
                        <?= $layanan['nama_pelayanan'] ?> - <?= $layanan['kode'] ?>
                    </p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <!-- Progress Steps -->
                    <div class="progress-steps mb-5">
                        <div class="step active">
                            <div class="step-number bg-primary text-white">1</div>
                            <div class="step-label">Pilih Layanan</div>
                        </div>
                        <div class="step-connector active"></div>
                        <div class="step active">
                            <div class="step-number bg-primary text-white">2</div>
                            <div class="step-label">Lengkapi Data</div>
                        </div>
                        <div class="step-connector"></div>
                        <div class="step">
                            <div class="step-number bg-light text-muted">3</div>
                            <div class="step-label">Kirim Permohonan</div>
                        </div>
                    </div>

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

                    <!-- Service Summary -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Ringkasan Layanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Nama Layanan:</strong><br>
                                    <span class="text-primary fw-bold fs-5"><?= $layanan['nama_pelayanan'] ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Estimasi Proses:</strong><br>
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-1">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= $layanan['estimasi_hari'] ?> hari kerja
                                    </span>
                                </div>
                                <div class="col-12">
                                    <strong>Deskripsi:</strong><br>
                                    <span class="text-muted"><?= $layanan['deskripsi'] ?? 'Layanan administrasi kependudukan untuk keperluan resmi.' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="/layanan/<?= $layanan['id_jenis'] ?>/ajukan" method="post" enctype="multipart/form-data" id="permohonanForm">
                        <?= csrf_field() ?>

                        <!-- Personal Information -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="bi bi-person-fill text-primary me-2"></i>
                                    Informasi Pemohon
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" class="form-control" value="<?= session('warga')['nama_lengkap'] ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">NIK</label>
                                        <input type="text" class="form-control" value="<?= session('warga')['nik'] ?>" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Alamat Lengkap</label>
                                        <textarea class="form-control" rows="3" readonly><?= session('warga')['alamat'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">No. HP</label>
                                        <input type="text" class="form-control" value="<?= session('warga')['no_hp'] ?? 'Tidak tersedia' ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" class="form-control" value="<?= session('warga')['email'] ?? 'Tidak tersedia' ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Requirements Checklist -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="bi bi-list-check text-primary me-2"></i>
                                    Persyaratan Dokumen
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Pastikan Anda memiliki semua dokumen berikut:</strong>
                                </div>

                                <div class="row g-3">
                                    <?php
                                    $syarat = explode(',', $layanan['syarat']);
                                    foreach ($syarat as $index => $item):
                                        $item = trim($item);
                                    ?>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input requirement-check" type="checkbox"
                                                       id="req_<?= $index ?>" data-requirement="<?= $item ?>">
                                                <label class="form-check-label fw-semibold" for="req_<?= $index ?>">
                                                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                                                    <?= $item ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="mt-3">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="requirementsProgress"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        <span id="checkedCount">0</span> dari <?= count($syarat) ?> persyaratan siap
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Documents -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="bi bi-upload text-primary me-2"></i>
                                    Upload Dokumen Persyaratan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Format yang didukung:</strong> JPG, PNG, PDF (Maksimal 2MB per file)
                                </div>

                                <div id="documentUploads">
                                    <!-- Dynamic upload fields will be added here -->
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm" id="addDocumentBtn">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Dokumen
                                </button>

                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Upload minimal 1 dokumen. Anda dapat menambah lebih banyak dokumen jika diperlukan.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="bi bi-chat-dots text-primary me-2"></i>
                                    Keterangan Tambahan (Opsional)
                                </h6>
                            </div>
                            <div class="card-body">
                                <label for="keterangan" class="form-label">Informasi Tambahan</label>
                                <textarea class="form-control <?= (isset($errors['keterangan'])) ? 'is-invalid' : '' ?>"
                                          id="keterangan" name="keterangan" rows="4"
                                          placeholder="Jelaskan keperluan khusus, informasi tambahan, atau catatan penting lainnya..."><?= old('keterangan') ?></textarea>
                                <div class="form-text">
                                    Berikan informasi tambahan yang mungkin diperlukan untuk proses permohonan Anda.
                                </div>
                                <?php if (isset($errors['keterangan'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        <?= $errors['keterangan'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label fw-semibold" for="agreeTerms">
                                        <i class="bi bi-check-circle me-2 text-success"></i>
                                        Saya menyatakan bahwa semua informasi dan dokumen yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                                        Saya memahami bahwa permohonan yang tidak lengkap atau tidak sesuai persyaratan akan ditolak.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Actions -->
                        <div class="d-flex gap-3 justify-content-between">
                            <a href="/layanan/<?= $layanan['id_jenis'] ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali ke Detail Layanan
                            </a>

                            <div class="d-flex gap-2">
                                <a href="/layanan" class="btn btn-outline-primary">
                                    <i class="bi bi-list me-1"></i>
                                    Lihat Semua Layanan
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                                    <i class="bi bi-send-fill me-2"></i>
                                    Kirim Permohonan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.progress-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 0.5rem;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.step.active .step-number {
    border-color: #007bff;
}

.step-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    text-align: center;
    max-width: 80px;
}

.step.active .step-label {
    color: #007bff;
}

.step-connector {
    width: 80px;
    height: 2px;
    background: #e9ecef;
    margin: 0 1rem;
    position: relative;
    top: -25px;
}

.step-connector.active {
    background: #007bff;
}

.document-upload-item {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.document-upload-item:hover {
    border-color: #007bff;
    background: rgba(0,123,255,0.05);
}

.remove-document {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #dc3545;
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-document:hover {
    background: #c82333;
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .progress-steps {
        flex-direction: column;
        gap: 1rem;
    }

    .step-connector {
        width: 2px;
        height: 40px;
        margin: 0;
        top: 0;
    }

    .d-flex.gap-3.justify-content-between {
        flex-direction: column;
    }

    .d-flex.gap-2 {
        margin-top: 1rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Requirements checklist
document.querySelectorAll('.requirement-check').forEach(checkbox => {
    checkbox.addEventListener('change', updateProgress);
});

function updateProgress() {
    const checkboxes = document.querySelectorAll('.requirement-check');
    const checkedCount = document.querySelectorAll('.requirement-check:checked').length;
    const totalCount = checkboxes.length;
    const percentage = (checkedCount / totalCount) * 100;

    document.getElementById('checkedCount').textContent = checkedCount;
    document.getElementById('requirementsProgress').style.width = percentage + '%';

    // Enable/disable submit button based on requirements
    const agreeTerms = document.getElementById('agreeTerms');
    const submitBtn = document.getElementById('submitBtn');

    submitBtn.disabled = !(checkedCount > 0 && agreeTerms.checked);
}

// Terms agreement
document.getElementById('agreeTerms').addEventListener('change', function() {
    updateProgress();
});

// Document upload management
let documentCount = 0;
const maxDocuments = 5;

document.getElementById('addDocumentBtn').addEventListener('click', function() {
    if (documentCount >= maxDocuments) {
        alert('Maksimal ' + maxDocuments + ' dokumen yang dapat diupload.');
        return;
    }

    addDocumentUpload();
});

function addDocumentUpload() {
    documentCount++;
    const uploadContainer = document.getElementById('documentUploads');

    const uploadItem = document.createElement('div');
    uploadItem.className = 'document-upload-item position-relative';
    uploadItem.innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Dokumen</label>
                <input type="text" class="form-control" name="document_names[]" placeholder="Contoh: KTP, KK, Surat Pengantar" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">File Dokumen</label>
                <input type="file" class="form-control" name="lampiran[]" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
        </div>
        <button type="button" class="remove-document" onclick="removeDocument(this)">
            <i class="bi bi-x"></i>
        </button>
    `;

    uploadContainer.appendChild(uploadItem);

    // Add file validation
    const fileInput = uploadItem.querySelector('input[type="file"]');
    fileInput.addEventListener('change', function() {
        validateFile(this);
    });
}

function removeDocument(button) {
    button.closest('.document-upload-item').remove();
    documentCount--;
}

// File validation
function validateFile(input) {
    const file = input.files[0];
    if (file) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        if (file.size > maxSize) {
            alert('File ' + file.name + ' terlalu besar! Maksimal 2MB.');
            input.value = '';
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert('Format file ' + file.name + ' tidak didukung! Gunakan JPG, PNG, atau PDF.');
            input.value = '';
            return;
        }
    }
}

// Initialize with one document upload
document.addEventListener('DOMContentLoaded', function() {
    addDocumentUpload();
});

// Form validation
document.getElementById('permohonanForm').addEventListener('submit', function(e) {
    const fileInputs = document.querySelectorAll('input[name="lampiran[]"]');
    let hasValidFile = false;

    fileInputs.forEach(input => {
        if (input.files.length > 0) {
            hasValidFile = true;
        }
    });

    if (!hasValidFile) {
        e.preventDefault();
        alert('Minimal upload 1 dokumen persyaratan.');
        return;
    }

    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
    submitBtn.disabled = true;
});
</script>
<?= $this->endSection() ?>
