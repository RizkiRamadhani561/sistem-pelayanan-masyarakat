<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h2 mb-0">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Pengaduan Masyarakat
                </h1>
                <p class="text-muted mb-0">Pantau dan kelola pengaduan dari masyarakat Kembangan Raya</p>
            </div>
            <div class="col-md-6 text-md-end">
                <?php if (session()->has('warga')): ?>
                    <a href="/pengaduan/create" class="btn btn-danger btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Buat Pengaduan Baru
                    </a>
                <?php elseif (!session()->has('user')): ?>
                    <a href="/login" class="btn btn-outline-primary me-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                    <a href="/register" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Statistics Cards (for admin/petugas) -->
    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-warning shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 text-warning mb-2">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4 class="h3 mb-1"><?= count(array_filter($pengaduan, fn($p) => $p['status'] === 'baru')) ?></h4>
                        <p class="text-muted mb-0">Pengaduan Baru</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 text-info mb-2">
                            <i class="bi bi-gear"></i>
                        </div>
                        <h4 class="h3 mb-1"><?= count(array_filter($pengaduan, fn($p) => $p['status'] === 'diproses')) ?></h4>
                        <p class="text-muted mb-0">Sedang Diproses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 text-success mb-2">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h4 class="h3 mb-1"><?= count(array_filter($pengaduan, fn($p) => $p['status'] === 'selesai')) ?></h4>
                        <p class="text-muted mb-0">Sudah Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-primary shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-2">
                            <i class="bi bi-list-ul"></i>
                        </div>
                        <h4 class="h3 mb-1"><?= count($pengaduan) ?></h4>
                        <p class="text-muted mb-0">Total Pengaduan</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter & Search -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pengaduan</label>
                    <input type="text" class="form-control" id="search" placeholder="Cari berdasarkan judul...">
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Filter Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="baru">Baru</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="dateFilter" class="form-label">Filter Tanggal</label>
                    <select class="form-select" id="dateFilter">
                        <option value="">Semua Tanggal</option>
                        <option value="today">Hari Ini</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List -->
    <div class="row g-4" id="pengaduanContainer">
        <?php if (!empty($pengaduan)): ?>
            <?php foreach ($pengaduan as $item): ?>
                <div class="col-lg-6 col-xl-4 fade-in pengaduan-item"
                     data-status="<?= $item['status'] ?>"
                     data-judul="<?= strtolower($item['judul']) ?>"
                     data-created="<?= date('Y-m-d', strtotime($item['created_at'])) ?>">
                    <div class="card h-100 border-0 shadow-sm card-hover">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="status-badge status-<?= $item['status'] ?>">
                                <?php
                                $statusText = [
                                    'baru' => 'Baru',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai'
                                ];
                                echo $statusText[$item['status']] ?? $item['status'];
                                ?>
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                            </small>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <a href="/pengaduan/<?= $item['id_pengaduan'] ?>" class="text-decoration-none text-dark">
                                    <?= substr($item['judul'], 0, 60) ?><?= strlen($item['judul']) > 60 ? '...' : '' ?>
                                </a>
                            </h5>

                            <p class="card-text text-muted mb-3">
                                <?= substr(strip_tags($item['isi_pengaduan']), 0, 100) ?>...
                            </p>

                            <?php if ($item['lokasi']): ?>
                                <div class="mb-3">
                                    <i class="bi bi-geo-alt text-muted me-1"></i>
                                    <small class="text-muted"><?= $item['lokasi'] ?></small>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
                                        <i class="bi bi-person me-1"></i>ID: <?= $item['id_pengaduan'] ?>
                                    <?php endif; ?>
                                </small>

                                <div class="btn-group btn-group-sm">
                                    <a href="/pengaduan/<?= $item['id_pengaduan'] ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
                                        <a href="/pengaduan/<?= $item['id_pengaduan'] ?>/edit" class="btn btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($item['lampiran']): ?>
                            <div class="card-footer bg-light">
                                <i class="bi bi-paperclip text-muted me-1"></i>
                                <small class="text-muted">Memiliki lampiran</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-exclamation-triangle display-1 text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada pengaduan</h4>
                    <p class="text-muted">Pengaduan yang Anda buat akan muncul di sini.</p>
                    <?php if (session()->has('warga')): ?>
                        <a href="/pengaduan/create" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Buat Pengaduan Pertama
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination (if needed) -->
    <div class="d-flex justify-content-center mt-4" id="paginationContainer">
        <!-- Pagination will be added here if implementing server-side pagination -->
    </div>
</div>

<!-- Quick Action Modal (for admin/petugas) -->
<?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
<div class="modal fade" id="quickActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-radius-xl">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-lightning me-2"></i>
                    Update Status Cepat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickActionForm">
                    <input type="hidden" id="quickActionId" name="id">
                    <div class="mb-3">
                        <label for="quickStatus" class="form-label">Status Baru</label>
                        <select class="form-select" id="quickStatus" name="status" required>
                            <option value="baru">Baru</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quickCatatan" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="quickCatatan" name="catatan" rows="3" maxlength="500"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitQuickAction()">
                    <i class="bi bi-check-circle me-2"></i>Update Status
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');

    function filterPengaduan() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;

        const items = document.querySelectorAll('.pengaduan-item');

        items.forEach(item => {
            const judul = item.dataset.judul;
            const status = item.dataset.status;
            const created = item.dataset.created;

            let show = true;

            // Search filter
            if (searchTerm && !judul.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (statusValue && status !== statusValue) {
                show = false;
            }

            // Date filter
            if (dateValue) {
                const today = new Date();
                const itemDate = new Date(created);
                let dateMatch = false;

                switch(dateValue) {
                    case 'today':
                        dateMatch = itemDate.toDateString() === today.toDateString();
                        break;
                    case 'week':
                        const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                        dateMatch = itemDate >= weekAgo;
                        break;
                    case 'month':
                        const monthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                        dateMatch = itemDate >= monthAgo;
                        break;
                }

                if (!dateMatch) {
                    show = false;
                }
            }

            item.style.display = show ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterPengaduan);
    statusFilter.addEventListener('change', filterPengaduan);
    dateFilter.addEventListener('change', filterPengaduan);
});

function resetFilters() {
    document.getElementById('search').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';

    const items = document.querySelectorAll('.pengaduan-item');
    items.forEach(item => item.style.display = 'block');
}

<?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
function openQuickAction(id) {
    document.getElementById('quickActionId').value = id;
    const modal = new bootstrap.Modal(document.getElementById('quickActionModal'));
    modal.show();
}

function submitQuickAction() {
    const form = document.getElementById('quickActionForm');
    const formData = new FormData(form);

    fetch('/pengaduan/update-status', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('quickActionModal')).hide();

            // Show success message
            showToast('Status berhasil diupdate!', 'success');

            // Reload page after delay
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Gagal update status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

function showToast(message, type) {
    const toastContainer = document.querySelector('.toast-container');
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}
<?php endif; ?>
</script>
<?= $this->endSection() ?>
