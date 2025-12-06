<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Header -->
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-3">
                    <div>
                        <h4 class="mb-1">
                            <i class="bi bi-eye text-primary me-2"></i>
                            Detail Pengaduan
                        </h4>
                        <small class="text-muted">ID: #<?= str_pad($pengaduan['id_pengaduan'], 5, '0', STR_PAD_LEFT) ?></small>
                    </div>
                    <a href="/pengaduan" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        <span class="badge fs-6 px-3 py-2 status-badge status-<?= $pengaduan['status'] ?> shadow-sm">
                            <i class="bi bi-circle-fill me-1"></i>
                            <?= ucfirst($pengaduan['status']) ?>
                        </span>
                    </div>

                    <!-- Pengaduan Details -->
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="border rounded-3 p-3 shadow-sm">
                                <h5 class="text-primary mb-2">
                                    <i class="bi bi-tag-fill me-2"></i><?= $pengaduan['judul'] ?>
                                </h5>
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar me-1"></i>
                                    Dibuat: <?= date('d F Y H:i', strtotime($pengaduan['created_at'])) ?>
                                    <?php if ($pengaduan['updated_at'] != $pengaduan['created_at']): ?>
                                        | Diupdate: <?= date('d F Y H:i', strtotime($pengaduan['updated_at'])) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="content-text">
                                    <?= nl2br($pengaduan['isi_pengaduan']) ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($pengaduan['lokasi'])): ?>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 shadow-sm h-100">
                                <h6 class="text-info mb-2"><i class="bi bi-geo-alt-fill me-1"></i>Lokasi Kejadian</h6>
                                <p class="mb-0 text-muted"><?= $pengaduan['lokasi'] ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($pengaduan['lampiran'])): ?>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 shadow-sm h-100">
                                <h6 class="text-success mb-2"><i class="bi bi-paperclip me-1"></i>Lampiran</h6>
                                <a href="/<?= $pengaduan['lampiran'] ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-eye me-1"></i>Lihat Lampiran
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Warga -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 shadow-sm h-100">
                                <h6 class="text-primary mb-2"><i class="bi bi-person-fill me-1"></i>Pelapor</h6>
                                <div class="text-muted small">
                                    <strong class="text-dark"><?= $warga['nama_lengkap'] ?></strong><br>
                                    NIK: <?= $warga['nik'] ?><br>
                                    Alamat: <?= $warga['alamat'] ?><br>
                                    Kontak: <?= $warga['no_hp'] ?? 'Tidak tersedia' ?>
                                </div>
                            </div>
                        </div>

                        <!-- Petugas -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 shadow-sm h-100">
                                <h6 class="text-warning mb-2"><i class="bi bi-person-badge-fill me-1"></i>Penanggung Jawab</h6>
                                <?php if ($petugas): ?>
                                <div class="text-muted small">
                                    <strong class="text-dark"><?= $petugas['nama'] ?></strong><br>
                                    Role: <?= ucfirst($petugas['role']) ?><br>
                                    Kontak: <?= $petugas['phone'] ?? 'Tidak tersedia' ?>
                                </div>
                                <?php else: ?>
                                <div class="text-muted"><em>Belum ditugaskan</em></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($pengaduan['catatan'])): ?>
                        <div class="col-12">
                            <div class="border rounded-3 p-3 shadow-sm bg-light">
                                <h6 class="text-secondary mb-2"><i class="bi bi-chat-quote-fill me-1"></i>Catatan Petugas</h6>
                                <div class="text-muted"><?= nl2br($pengaduan['catatan']) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-center gap-2 flex-wrap">
                            <a href="/pengaduan" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-list me-1"></i>Daftar Pengaduan
                            </a>
                            <?php if (session()->has('user') && in_array(session('user')['role'], ['admin','petugas'])): ?>
                            <a href="/pengaduan/<?= $pengaduan['id_pengaduan'] ?>/edit" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil me-1"></i>Update Status
                            </a>
                            <?php endif; ?>
                            <?php if (session()->has('warga') && session('warga')['id_warga']==$pengaduan['warga_id']): ?>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="printPengaduan()">
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-light rounded-top-3">
                    <h6 class="mb-0"><i class="bi bi-timeline me-2"></i>Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Dibuat</h6>
                                <p class="timeline-text mb-0">Pengaduan diajukan pada <?= date('d F Y H:i', strtotime($pengaduan['created_at'])) ?></p>
                                <small class="text-muted">Status: Baru</small>
                            </div>
                        </div>

                        <?php if($pengaduan['status'] != 'baru'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Status Diubah</h6>
                                <p class="timeline-text mb-0">Status diubah menjadi "<?= ucfirst($pengaduan['status']) ?>" pada <?= date('d F Y H:i', strtotime($pengaduan['updated_at'])) ?></p>
                                <small class="text-muted">Oleh: <?= $petugas ? $petugas['nama'] : 'Sistem' ?></small>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($pengaduan['status'] == 'selesai'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Selesai</h6>
                                <p class="timeline-text mb-0">Pengaduan telah diselesaikan dan ditutup</p>
                                <small class="text-muted">Terima kasih atas partisipasi Anda</small>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-text { line-height:1.6; white-space: pre-wrap; }
.timeline { position: relative; padding-left: 35px; }
.timeline::before { content:''; position:absolute; left:15px; top:0; bottom:0; width:3px; background:#e9ecef; border-radius:2px; }
.timeline-item { position: relative; margin-bottom:30px; }
.timeline-marker { position:absolute; left:-22px; top:5px; width:14px; height:14px; border-radius:50%; border:2px solid #fff; box-shadow:0 0 0 2px #e9ecef; }
.timeline-content { background:#f8f9fa; padding:15px; border-radius:10px; border:1px solid #e9ecef; transition: transform .2s; }
.timeline-content:hover { transform: translateY(-3px); }
.timeline-title { font-weight:600; color:#495057; margin-bottom:5px; }
.timeline-text { color:#6c757d; font-size:.875rem; }
.status-baru { background:#ffc107; color:#212529; }
.status-diproses { background:#0dcaf0; color:#212529; }
.status-selesai { background:#198754; color:#fff; }

@media print {
    .btn,.card-header,.timeline::before { display:none !important; }
    .card { border:1px solid #000 !important; box-shadow:none !important; }
    .timeline-item { break-inside: avoid; }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function printPengaduan(){ window.print(); }
</script>
<?= $this->endSection() ?>
