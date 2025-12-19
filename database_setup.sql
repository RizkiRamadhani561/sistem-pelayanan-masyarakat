-- PostgreSQL Database Setup for Sistem Pelayanan Masyarakat
-- Compatible with Neon PostgreSQL
-- Run this script in Neon SQL Editor or psql

-- Create ENUM types for PostgreSQL
CREATE TYPE user_role AS ENUM ('admin', 'petugas');
CREATE TYPE user_status AS ENUM ('active', 'inactive');
CREATE TYPE gender_type AS ENUM ('L', 'P');
CREATE TYPE request_status AS ENUM ('pending', 'diproses', 'selesai', 'ditolak');
CREATE TYPE news_status AS ENUM ('draft', 'published');
CREATE TYPE service_status AS ENUM ('active', 'inactive');

-- Create users table
CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role user_role DEFAULT 'petugas',
    status user_status DEFAULT 'active',
    phone VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create warga table
CREATE TABLE warga (
    id_warga SERIAL PRIMARY KEY,
    nik CHAR(16) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(150) NOT NULL,
    jenis_kelamin gender_type NOT NULL,
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    alamat TEXT,
    rt_rw VARCHAR(50),
    kecamatan VARCHAR(100),
    kab_kota VARCHAR(100),
    provinsi VARCHAR(100),
    no_hp VARCHAR(30),
    email VARCHAR(150),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create jenis_layanan table
CREATE TABLE jenis_layanan (
    id_layanan SERIAL PRIMARY KEY,
    nama_layanan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    persyaratan TEXT,
    estimasi_waktu VARCHAR(100),
    biaya DECIMAL(10,2) DEFAULT 0,
    status service_status DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create permohonan table
CREATE TABLE permohonan (
    id_permohonan SERIAL PRIMARY KEY,
    nomor_permohonan VARCHAR(50) UNIQUE NOT NULL,
    warga_id INTEGER NOT NULL REFERENCES warga(id_warga) ON DELETE CASCADE,
    layanan_id INTEGER NOT NULL REFERENCES jenis_layanan(id_layanan) ON DELETE CASCADE,
    status request_status DEFAULT 'pending',
    catatan TEXT,
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_selesai TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create persyaratan table
CREATE TABLE persyaratan (
    id_persyaratan SERIAL PRIMARY KEY,
    layanan_id INTEGER NOT NULL REFERENCES jenis_layanan(id_layanan) ON DELETE CASCADE,
    nama_persyaratan VARCHAR(255) NOT NULL,
    tipe_file VARCHAR(100),
    wajib BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create log_status table
CREATE TABLE log_status (
    id_log SERIAL PRIMARY KEY,
    permohonan_id INTEGER REFERENCES permohonan(id_permohonan) ON DELETE CASCADE,
    status_lama request_status,
    status_baru request_status NOT NULL,
    catatan TEXT,
    user_id INTEGER REFERENCES users(id_user) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create pengaduan table
CREATE TABLE pengaduan (
    id_pengaduan SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    kategori VARCHAR(100),
    status request_status DEFAULT 'pending',
    warga_id INTEGER NOT NULL REFERENCES warga(id_warga) ON DELETE CASCADE,
    petugas_id INTEGER REFERENCES users(id_user) ON DELETE SET NULL,
    lampiran VARCHAR(255),
    catatan TEXT,
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_selesai TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create notifikasi table
CREATE TABLE notifikasi (
    id_notif SERIAL PRIMARY KEY,
    warga_id INTEGER REFERENCES warga(id_warga) ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(id_user) ON DELETE CASCADE,
    pesan VARCHAR(500) NOT NULL,
    link VARCHAR(500),
    is_read BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create berita table
CREATE TABLE berita (
    id_berita SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    isi TEXT NOT NULL,
    excerpt VARCHAR(300),
    gambar VARCHAR(500),
    status news_status DEFAULT 'draft',
    penulis_id INTEGER NOT NULL REFERENCES users(id_user) ON DELETE CASCADE,
    views INTEGER DEFAULT 0,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create config_app table
CREATE TABLE config_app (
    id_config SERIAL PRIMARY KEY,
    config_key VARCHAR(100) UNIQUE NOT NULL,
    config_value TEXT,
    config_group VARCHAR(50) DEFAULT 'general',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_warga_nik ON warga(nik);
CREATE INDEX idx_warga_email ON warga(email);
CREATE INDEX idx_permohonan_warga ON permohonan(warga_id);
CREATE INDEX idx_permohonan_status ON permohonan(status);
CREATE INDEX idx_pengaduan_warga ON pengaduan(warga_id);
CREATE INDEX idx_pengaduan_status ON pengaduan(status);
CREATE INDEX idx_berita_slug ON berita(slug);
CREATE INDEX idx_berita_status ON berita(status);
CREATE INDEX idx_berita_penulis ON berita(penulis_id);
CREATE INDEX idx_notifikasi_warga ON notifikasi(warga_id);
CREATE INDEX idx_notifikasi_user ON notifikasi(user_id);

-- Insert default config values
INSERT INTO config_app (config_key, config_value, config_group) VALUES
('app_name', 'Sistem Pelayanan Masyarakat Kembangan Raya', 'general'),
('app_version', '1.0.0', 'general'),
('admin_email', 'admin@kembanganraya.go.id', 'contact'),
('support_email', 'support@kembanganraya.go.id', 'contact'),
('max_file_size', '5242880', 'upload'), -- 5MB
('allowed_file_types', 'jpg,jpeg,png,pdf,doc,docx', 'upload');

-- Insert sample admin user (password: admin123)
INSERT INTO users (nama, email, password, role, status) VALUES
('Administrator', 'admin@kembanganraya.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active');

-- Insert sample jenis layanan
INSERT INTO jenis_layanan (nama_layanan, deskripsi, persyaratan, estimasi_waktu, biaya) VALUES
('Surat Keterangan Domisili', 'Surat keterangan domisili untuk keperluan administrasi', 'KTP, KK, Surat pengantar RT/RW', '3 hari kerja', 5000.00),
('Surat Keterangan Usaha', 'Surat keterangan usaha untuk warga yang memiliki usaha', 'KTP, NPWP, Surat pengantar RT/RW', '5 hari kerja', 10000.00),
('Surat Keterangan Tidak Mampu', 'Surat keterangan tidak mampu untuk keperluan sosial', 'KTP, KK, Surat pengantar RT/RW', '2 hari kerja', 0.00);
