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
    <!-- Statistics Cards (admin/petugas) -->
    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-warning shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="display-4 text-warning mb-2"><i class="bi bi-clock"></i></div>
                        <h4 class="h3 mb-1"><?= count(array_filter((array)$pengaduan, fn($p) => ($p['status'] ?? '') === 'baru')) ?></h4>
                        <p class="text-muted mb-0">Pengaduan Baru</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-info shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="display-4 text-info mb-2"><i class="bi bi-gear"></i></div>
                        <h4 class="h3 mb-1"><?= count(array_filter((array)$pengaduan, fn($p) => ($p['status'] ?? '') === 'diproses')) ?></h4>
                        <p class="text-muted mb-0">Sedang Diproses</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-success shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle"></i></div>
                        <h4 class="h3 mb-1"><?= count(array_filter((array)$pengaduan, fn($p) => ($p['status'] ?? '') === 'selesai')) ?></h4>
                        <p class="text-muted mb-0">Sudah Selesai</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-primary shadow-sm stat-card">
                    <div class="card-body text-center">
                        <div class="display-4 text-primary mb-2"><i class="bi bi-list-ul"></i></div>
                        <h4 class="h3 mb-1"><?= count((array)$pengaduan) ?></h4>
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
                    <input type="search" class="form-control" id="search" placeholder="Cari berdasarkan judul..." autocomplete="off" />
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

                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List -->
    <div class="row g-4" id="pengaduanContainer">
        <?php if (!empty($pengaduan)): ?>
            <?php foreach ($pengaduan as $item): 
                $id = esc($item['id_pengaduan']);
                $status = esc($item['status'] ?? '');
                $judul = esc($item['judul']);
                $createdAt = date('Y-m-d', strtotime($item['created_at'] ?? 'now'));
                $snippet = esc(strlen(strip_tags($item['isi_pengaduan'])) > 100 ? substr(strip_tags($item['isi_pengaduan']), 0, 100) . '...' : strip_tags($item['isi_pengaduan']));
            ?>
                <div class="col-lg-6 col-xl-4 fade-in pengaduan-item"
                     data-status="<?= $status ?>"
                     data-judul="<?= strtolower($judul) ?>"
                     data-created="<?= $createdAt ?>">
                    <div class="card h-100 border-0 shadow-sm card-hover">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <span class="status-badge status-<?= $status ?>">
                                <?= $status === 'baru' ? 'Baru' : ($status === 'diproses' ? 'Diproses' : ($status === 'selesai' ? 'Selesai' : esc($status))) ?>
                            </span>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                            </small>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-3">
                                <a href="/pengaduan/<?= $id ?>" class="text-decoration-none text-dark">
                                    <?= (strlen($judul) > 60) ? substr($judul, 0, 60) . '...' : $judul ?>
                                </a>
                            </h5>

                            <p class="card-text text-muted mb-3"><?= $snippet ?></p>

                            <?php if (!empty($item['lokasi'])): ?>
                                <div class="mb-3">
                                    <i class="bi bi-geo-alt text-muted me-1"></i>
                                    <small class="text-muted"><?= esc($item['lokasi']) ?></small>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
                                        <i class="bi bi-person me-1"></i>ID: <?= $id ?>
                                    <?php endif; ?>
                                </small>

                                <div class="btn-group btn-group-sm" role="group" aria-label="actions">
                                    <a href="/pengaduan/<?= $id ?>" class="btn btn-outline-primary" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
                                        <button type="button" class="btn btn-outline-warning quick-action-btn" data-id="<?= $id ?>" title="Update Cepat">
                                            <i class="bi bi-lightning"></i>
                                        </button>

                                        <a href="/pengaduan/<?= $id ?>/edit" class="btn btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($item['lampiran'])): ?>
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

    <!-- Pagination container (server-side pagination recommended) -->
    <div class="d-flex justify-content-center mt-4" id="paginationContainer"></div>
</div>

<!-- Quick Action Modal (admin/petugas) -->
<?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
<div class="modal fade" id="quickActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-radius-xl">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-lightning me-2"></i>Update Status Cepat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <form id="quickActionForm">
                    <?= csrf_field() ?>
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
                <button type="button" class="btn btn-primary" id="quickSubmitBtn">
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
(() => {
    // helpers
    const $ = (s, root = document) => root.querySelector(s);
    const $$ = (s, root = document) => Array.from(root.querySelectorAll(s));
    const debounce = (fn, wait = 300) => {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    };

    // elements
    const searchInput = $('#search');
    const statusFilter = $('#statusFilter');
    const dateFilter = $('#dateFilter');
    const resetBtn = $('#resetBtn');
    const container = $('#pengaduanContainer');

    // ensure existence
    if (!container) return;

    // filter logic
    const filterPengaduan = () => {
        const searchTerm = (searchInput?.value || '').toLowerCase().trim();
        const statusValue = statusFilter?.value || '';
        const dateValue = dateFilter?.value || '';

        const items = $$('.pengaduan-item', container);
        const today = new Date();

        items.forEach(item => {
            const judul = item.dataset.judul || '';
            const status = item.dataset.status || '';
            const created = item.dataset.created || '';
            const createdDate = created ? new Date(created) : null;

            let show = true;

            // search
            if (searchTerm && !judul.includes(searchTerm)) show = false;

            // status
            if (statusValue && status !== statusValue) show = false;

            // date
            if (dateValue && createdDate) {
                let dateMatch = false;
                if (dateValue === 'today') {
                    dateMatch = createdDate.toDateString() === today.toDateString();
                } else if (dateValue === 'week') {
                    const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                    dateMatch = createdDate >= weekAgo;
                } else if (dateValue === 'month') {
                    const monthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                    dateMatch = createdDate >= monthAgo;
                }
                if (!dateMatch) show = false;
            }

            item.style.display = show ? 'block' : 'none';
        });
    };

    // attach events with debounce
    if (searchInput) searchInput.addEventListener('input', debounce(filterPengaduan, 250));
    if (statusFilter) statusFilter.addEventListener('change', filterPengaduan);
    if (dateFilter) dateFilter.addEventListener('change', filterPengaduan);
    if (resetBtn) resetBtn.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (statusFilter) statusFilter.value = '';
        if (dateFilter) dateFilter.value = '';
        filterPengaduan();
    });

    // Quick Action (event delegation)
    <?php if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])): ?>
    const quickModalEl = document.getElementById('quickActionModal');
    const quickModal = quickModalEl ? new bootstrap.Modal(quickModalEl) : null;
    const quickForm = document.getElementById('quickActionForm');
    const quickId = document.getElementById('quickActionId');
    const quickStatus = document.getElementById('quickStatus');
    const quickCatatan = document.getElementById('quickCatatan');
    const quickSubmitBtn = document.getElementById('quickSubmitBtn');

    // open modal when clicking quick-action-btn
    container.addEventListener('click', function(e) {
        const btn = e.target.closest('.quick-action-btn');
        if (!btn) return;
        const id = btn.dataset.id;
        if (!id) return;

        quickId.value = id;
        quickStatus.value = 'diproses';
        quickCatatan.value = '';
        if (quickModal) quickModal.show();
    });

    // ensure toast container
    const ensureToastContainer = () => {
        let out = document.querySelector('.toast-container');
        if (!out) {
            out = document.createElement('div');
            out.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(out);
        }
        return out;
    };

    // show toast helper
    const showToast = (message, type = 'success') => {
        const container = ensureToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        container.appendChild(toast);
        const bs = new bootstrap.Toast(toast, { delay: 3000 });
        bs.show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    };

    // submit quick action (AJAX)
    if (quickSubmitBtn) {
        quickSubmitBtn.addEventListener('click', () => {
            if (!quickForm) return;
            const formData = new FormData(quickForm);

            fetch('/pengaduan/update-status', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (quickModal) quickModal.hide();
                    showToast('Status berhasil diupdate!', 'success');
                    // update single card status in DOM if sent back
                    if (data.updated && data.id) {
                        const card = container.querySelector(`.pengaduan-item [data-id="${data.id}"]`);
                        // simple page reload if API didn't return updated HTML
                        setTimeout(() => location.reload(), 800);
                    } else {
                        setTimeout(() => location.reload(), 800);
                    }
                } else {
                    showToast(data.message || 'Gagal update status', 'danger');
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan jaringan', 'danger');
            });
        });
    }
    <?php endif; ?>

    // initial filter run (in case server-side provided query)
    filterPengaduan();
})();
</script>
<?= $this->endSection() ?>
.status-badge {
            font-size: 0.8em;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>