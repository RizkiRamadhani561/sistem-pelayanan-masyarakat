<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Kelola Data Warga
                    </h1>
                    <p class="text-muted mb-0">Pengelolaan data masyarakat Kembangan Raya</p>
                </div>
                <div>
                    <a href="/dashboard/warga/create" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Tambah Warga
                    </a>
                </div>
            </div>
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

    <!-- Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= count($wargas) ?></h3>
                    <p class="text-muted mb-0">Total Warga</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="bi bi-gender-male"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= count(array_filter($wargas, fn($w) => $w['jenis_kelamin'] == 'L')) ?></h3>
                    <p class="text-muted mb-0">Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="bi bi-gender-female"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= count(array_filter($wargas, fn($w) => $w['jenis_kelamin'] == 'P')) ?></h3>
                    <p class="text-muted mb-0">Perempuan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-2">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h3 class="h2 mb-1"><?= count(array_filter($wargas, fn($w) => !empty($w['email']))) ?></h3>
                    <p class="text-muted mb-0">Dengan Email</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Warga</label>
                    <input type="text" class="form-control" id="search" placeholder="Cari berdasarkan nama atau NIK...">
                </div>
                <div class="col-md-3">
                    <label for="genderFilter" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="genderFilter">
                        <option value="">Semua</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kecamatanFilter" class="form-label">Kecamatan</label>
                    <select class="form-select" id="kecamatanFilter">
                        <option value="">Semua Kecamatan</option>
                        <?php
                        $kecamatans = array_unique(array_column($wargas, 'kecamatan'));
                        foreach ($kecamatans as $kecamatan):
                            if (!empty($kecamatan)):
                        ?>
                            <option value="<?= $kecamatan ?>"><?= $kecamatan ?></option>
                        <?php endif; endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Warga Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Data Warga (<?= count($wargas) ?> orang)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="wargaTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">#</th>
                            <th class="border-0">NIK</th>
                            <th class="border-0">Nama Lengkap</th>
                            <th class="border-0">Jenis Kelamin</th>
                            <th class="border-0">Alamat</th>
                            <th class="border-0">Kontak</th>
                            <th class="border-0">Dibuat</th>
                            <th class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($wargas)): ?>
                            <?php $no = 1; foreach ($wargas as $warga): ?>
                                <tr class="warga-row"
                                    data-nik="<?= $warga['nik'] ?>"
                                    data-nama="<?= strtolower($warga['nama_lengkap']) ?>"
                                    data-jenis-kelamin="<?= $warga['jenis_kelamin'] ?>"
                                    data-kecamatan="<?= $warga['kecamatan'] ?>">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <code class="text-primary"><?= $warga['nik'] ?></code>
                                    </td>
                                    <td>
                                        <strong><?= $warga['nama_lengkap'] ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <?= $warga['rt_rw'] ?>, <?= $warga['kecamatan'] ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $warga['jenis_kelamin'] == 'L' ? 'primary' : 'info' ?>">
                                            <i class="bi bi-<?= $warga['jenis_kelamin'] == 'L' ? 'gender-male' : 'gender-female' ?> me-1"></i>
                                            <?= $warga['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            <?= substr($warga['alamat'], 0, 50) ?><?= strlen($warga['alamat']) > 50 ? '...' : '' ?>
                                            <br>
                                            <span class="text-muted">
                                                <?= $warga['kab_kota'] ?>, <?= $warga['provinsi'] ?>
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if (!empty($warga['no_hp'])): ?>
                                            <i class="bi bi-telephone text-success me-1"></i>
                                            <small><?= $warga['no_hp'] ?></small>
                                            <br>
                                        <?php endif; ?>
                                        <?php if (!empty($warga['email'])): ?>
                                            <i class="bi bi-envelope text-info me-1"></i>
                                            <small><?= $warga['email'] ?></small>
                                        <?php endif; ?>
                                        <?php if (empty($warga['no_hp']) && empty($warga['email'])): ?>
                                            <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            <?= date('d/m/Y', strtotime($warga['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="/dashboard/warga/<?= $warga['id_warga'] ?>" class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/dashboard/warga/<?= $warga['id_warga'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus"
                                                    onclick="confirmDelete(<?= $warga['id_warga'] ?>, '<?= $warga['nama_lengkap'] ?>')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-people display-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data warga</h5>
                                    <p class="text-muted mb-3">Data warga akan muncul di sini setelah ditambahkan</p>
                                    <a href="/dashboard/warga/create" class="btn btn-primary">
                                        <i class="bi bi-person-plus me-2"></i>Tambah Warga Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data warga:</p>
                <p class="fw-bold text-primary" id="deleteWargaName"></p>
                <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Search and Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const genderFilter = document.getElementById('genderFilter');
    const kecamatanFilter = document.getElementById('kecamatanFilter');

    function filterWarga() {
        const searchTerm = searchInput.value.toLowerCase();
        const genderValue = genderFilter.value;
        const kecamatanValue = kecamatanFilter.value;

        const rows = document.querySelectorAll('.warga-row');

        rows.forEach(row => {
            const nik = row.dataset.nik.toLowerCase();
            const nama = row.dataset.nama;
            const jenisKelamin = row.dataset.jenisKelamin;
            const kecamatan = row.dataset.kecamatan;

            let show = true;

            // Search filter (NIK or nama)
            if (searchTerm && !nik.includes(searchTerm) && !nama.includes(searchTerm)) {
                show = false;
            }

            // Gender filter
            if (genderValue && jenisKelamin !== genderValue) {
                show = false;
            }

            // Kecamatan filter
            if (kecamatanValue && kecamatan !== kecamatanValue) {
                show = false;
            }

            row.style.display = show ? 'table-row' : 'none';
        });
    }

    searchInput.addEventListener('input', filterWarga);
    genderFilter.addEventListener('change', filterWarga);
    kecamatanFilter.addEventListener('change', filterWarga);
});

function resetFilters() {
    document.getElementById('search').value = '';
    document.getElementById('genderFilter').value = '';
    document.getElementById('kecamatanFilter').value = '';

    const rows = document.querySelectorAll('.warga-row');
    rows.forEach(row => row.style.display = 'table-row');
}

function confirmDelete(id, name) {
    document.getElementById('deleteWargaName').textContent = name;
    document.getElementById('deleteConfirmBtn').href = `/dashboard/warga/${id}/delete`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Toast notifications
<?php if (session()->has('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.querySelector('.alert-success'));
        setTimeout(() => toast.show(), 500);
    });
<?php endif; ?>

<?php if (session()->has('error')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = new bootstrap.Toast(document.querySelector('.alert-danger'));
        setTimeout(() => toast.show(), 500);
    });
<?php endif; ?>
</script>
<?= $this->endSection() ?>
