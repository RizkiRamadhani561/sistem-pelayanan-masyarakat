# 🏛️ Sistem Pelayanan Masyarakat Kembangan Raya

[![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.6.3-red.svg)](https://codeigniter.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3+-purple.svg)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 **Deskripsi Sistem**

Sistem web modern berbasis **CodeIgniter 4** untuk pengelolaan pelayanan masyarakat Kembangan Raya. Platform digital terintegrasi yang memfasilitasi komunikasi antara masyarakat, pemerintah, dan petugas layanan dengan fitur-fitur lengkap untuk mendukung pelayanan publik yang efektif dan efisien.

### 🎯 **Tujuan Sistem**
- ✅ **Digitalisasi Layanan Publik**: Transformasi layanan manual ke digital
- ✅ **Transparansi Pelayanan**: Tracking real-time status pengaduan dan permohonan
- ✅ **Efisiensi Operasional**: Otomasi proses administrasi
- ✅ **Aksesibilitas**: Layanan 24/7 dari mana saja
- ✅ **Akuntabilitas**: Audit trail lengkap untuk semua aktivitas

### 🏗️ **Arsitektur Sistem**
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5.3
- **Backend**: CodeIgniter 4.6.3 Framework (MVC Architecture)
- **Database**: MySQL 8.0+ dengan InnoDB Engine
- **Authentication**: Session-based dengan Multi-Level Access Control
- **File Storage**: Local file system dengan validasi keamanan
- **API**: RESTful endpoints untuk AJAX operations
- **Security**: CSRF Protection, XSS Prevention, Input Validation

---

## 📋 Daftar Isi

- [🎯 Fitur Utama](#-fitur-utama)
- [🏗️ Arsitektur Sistem](#️-arsitektur-sistem)
- [🚀 Instalasi & Setup](#-instalasi--setup)
- [🔐 Login Credentials](#-login-credentials)
- [📊 Dashboard & Management](#-dashboard--management)
- [🔧 API Endpoints](#-api-endpoints)
- [📁 Struktur Database](#-struktur-database)
- [🎨 UI/UX Features](#-uiux-features)
- [🛡️ Keamanan](#️-keamanan)
- [📈 Monitoring & Logging](#-monitoring--logging)
- [🧪 Testing](#-testing)
- [🚀 Deployment](#-deployment)
- [📞 Support](#-support)
- [📝 Changelog](#-changelog)
- [🤝 Contributing](#-contributing)
- [📜 License](#-license)

---

## 🎯 Fitur Utama

### 🏠 **Portal Berita & Informasi**
- ✅ Berita terbaru dengan lazy loading
- ✅ Portal informasi publik
- ✅ SEO-friendly dengan meta tags
- ✅ Responsive design untuk semua device

### 📢 **Sistem Pengaduan Masyarakat**
- ✅ Form pengaduan online 24/7
- ✅ Upload lampiran file (JPG, PNG, PDF)
- ✅ Tracking status pengaduan real-time
- ✅ Notifikasi otomatis via email
- ✅ Status: Baru → Diproses → Selesai

### 📄 **Sistem Permohonan Layanan**
- ✅ Permohonan layanan administrasi online
- ✅ Nomor permohonan otomatis generate
- ✅ Log status perubahan otomatis
- ✅ File persyaratan digital
- ✅ Status tracking lengkap

### 👥 **Manajemen Warga**
- ✅ Registrasi warga dengan validasi KTP
- ✅ Database warga terpusat
- ✅ Update data profil
- ✅ Riwayat interaksi lengkap

### 🔐 **Autentikasi Multi-Level**
- ✅ **Warga**: Login dengan NIK
- ✅ **Petugas**: Login email/password
- ✅ **Admin**: Login email/password dengan akses penuh
- ✅ Session management aman

### 📊 **Dashboard Admin Lengkap**
- ✅ Statistik real-time sistem
- ✅ Management data warga (CRUD)
- ✅ Monitoring pengaduan & permohonan
- ✅ User management
- ✅ Laporan & analytics

---

## 🏗️ Arsitektur Sistem

### **Tech Stack:**
- **Backend**: CodeIgniter 4.6.3 (PHP Framework)
- **Frontend**: Bootstrap 5.3 + Custom CSS
- **Database**: MySQL 8.0+ dengan InnoDB
- **Authentication**: Session-based dengan role management
- **File Storage**: Local file system dengan validasi
- **API**: RESTful endpoints untuk AJAX operations

### **Design Patterns:**
- **MVC Architecture**: Model-View-Controller separation
- **Dependency Injection**: Service container pattern
- **Repository Pattern**: Data access abstraction
- **Observer Pattern**: Event-driven notifications
- **Factory Pattern**: Object creation abstraction

---

## 🚀 Instalasi & Setup

### **Persyaratan Sistem:**
- ✅ PHP 8.2 atau lebih tinggi
- ✅ MySQL 8.0 atau lebih tinggi
- ✅ Composer untuk dependency management
- ✅ Node.js (opsional, untuk development)
- ✅ Git untuk version control

### **Langkah Instalasi:**

#### **1. Clone Repository**
```bash
git clone https://github.com/your-repo/sistem-pelayanan-masyarakat.git
cd sistem-pelayanan-masyarakat
```

#### **2. Install Dependencies**
```bash
composer install
```

#### **3. Environment Configuration**
```bash
cp env .env
```

Edit file `.env`:
```env
# Environment
CI_ENVIRONMENT = development

# Database Configuration
database.default.hostname = localhost
database.default.database = sistem_pelayanan_masyarakat
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

# App Configuration
app.baseURL = 'http://localhost:8081/'
```

#### **4. Database Setup**
```bash
# Create database
mysql -u root -p
CREATE DATABASE sistem_pelayanan_masyarakat;
exit;

# Run migrations
php spark migrate

# Run seeders
php spark db:seed UserSeeder
php spark db:seed JenisLayananSeeder
php spark db:seed WargaSeeder
php spark db:seed PermohonanSeeder
php spark db:seed BeritaSeeder
```

#### **5. Start Development Server**
```bash
php spark serve --host 0.0.0.0 --port 8081
```

#### **6. Akses Aplikasi**
- **Frontend**: http://localhost:8081
- **Admin Panel**: http://localhost:8081/admin/login

---

## 🔐 Login Credentials

### **👑 Admin Account**
- **Email**: `admin@sistem.com`
- **Password**: `admin123`
- **Role**: Administrator (Full Access)

### **👨‍💼 Petugas Account**
- **Email**: `petugas@sistem.com`
- **Password**: `petugas123`
- **Role**: Petugas Layanan

### **👥 Demo Warga Account**
- **NIK**: Gunakan NIK dari data seeder
- **Password**: NIK digunakan sebagai autentikasi

---

## 📊 Dashboard & Management

### **Admin Dashboard Features:**
- ✅ **Real-time Statistics**: Warga, pengaduan, permohonan, berita
- ✅ **Quick Actions**: Navigasi cepat ke semua modul
- ✅ **Recent Activity**: Monitoring aktivitas terbaru
- ✅ **System Health**: Status sistem & database

### **Management Modules:**

#### **👥 Warga Management**
- ✅ View all residents in data table
- ✅ Search & filter by name, NIK, gender, kecamatan
- ✅ Add new warga with complete validation
- ✅ Edit existing warga information
- ✅ Delete warga with confirmation
- ✅ View detailed warga profile

#### **📢 Berita Management** *(Framework Ready)*
- 🔄 CRUD operations untuk berita
- 🔄 Rich text editor untuk konten
- 🔄 Image upload & management
- 🔄 Publish/unpublish controls
- 🔄 Category management

#### **🏘️ Wilayah Management** *(Framework Ready)*
- 🔄 RT/RW management
- 🔄 Kecamatan administration
- 🔄 Regional statistics
- 🔄 Boundary management

---

## 🔧 API Endpoints

### **Authentication APIs:**
```http
POST /login              # Warga login dengan NIK
POST /admin/login        # Admin/petugas login
POST /register           # Registrasi warga baru
GET  /logout             # Logout dari sistem
```

### **Complaint APIs:**
```http
GET  /pengaduan          # List semua pengaduan
POST /pengaduan/store    # Buat pengaduan baru
GET  /pengaduan/{id}     # Detail pengaduan
POST /pengaduan/update-status # Update status pengaduan
```

### **Admin APIs:**
```http
GET  /dashboard                  # Dashboard overview
GET  /dashboard/warga            # List warga untuk management
POST /dashboard/warga/store      # Tambah warga baru
PUT  /dashboard/warga/{id}       # Update warga
DELETE /dashboard/warga/{id}     # Hapus warga
```

---

## 📁 Struktur Database

### **Core Tables:**
```sql
-- Users (Admin & Petugas)
users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Warga (Masyarakat)
warga (
    id_warga INT PRIMARY KEY AUTO_INCREMENT,
    nik VARCHAR(16) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(150) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    rt_rw VARCHAR(10) NOT NULL,
    kecamatan VARCHAR(100) NOT NULL,
    kab_kota VARCHAR(100) NOT NULL,
    provinsi VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20),
    email VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pengaduan Masyarakat
pengaduan (
    id_pengaduan INT PRIMARY KEY AUTO_INCREMENT,
    warga_id INT NOT NULL,
    petugas_id INT,
    judul VARCHAR(200) NOT NULL,
    isi_pengaduan TEXT NOT NULL,
    lokasi VARCHAR(255),
    lampiran VARCHAR(255),
    status ENUM('baru', 'diproses', 'selesai') DEFAULT 'baru',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (warga_id) REFERENCES warga(id_warga),
    FOREIGN KEY (petugas_id) REFERENCES users(id_user)
);

-- Permohonan Layanan
permohonan (
    id_permohonan INT PRIMARY KEY AUTO_INCREMENT,
    warga_id INT NOT NULL,
    jenis_id INT NOT NULL,
    nomor_permohonan VARCHAR(50) UNIQUE,
    status ENUM('diajukan', 'diproses', 'selesai', 'ditolak') DEFAULT 'diajukan',
    tanggal_pengajuan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_selesai TIMESTAMP NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (warga_id) REFERENCES warga(id_warga),
    FOREIGN KEY (jenis_id) REFERENCES jenis_pelayanan(id_jenis)
);

-- Berita & Informasi
berita (
    id_berita INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    isi TEXT NOT NULL,
    excerpt TEXT,
    gambar VARCHAR(255),
    penulis_id INT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    views INT DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (penulis_id) REFERENCES users(id_user)
);

-- Log Status Perubahan
log_status (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    jenis_log ENUM('pengaduan', 'permohonan') NOT NULL,
    record_id INT NOT NULL,
    status_lama ENUM('baru', 'diajukan', 'diproses', 'selesai', 'ditolak'),
    status_baru ENUM('baru', 'diajukan', 'diproses', 'selesai', 'ditolak') NOT NULL,
    user_id INT,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id_user)
);
```

---

## 🎨 UI/UX Features

### **Design System:**
- ✅ **Bootstrap 5.3**: Modern, responsive framework
- ✅ **Custom CSS**: Enhanced styling & animations
- ✅ **Icons**: Bootstrap Icons integration
- ✅ **Typography**: Clean, readable fonts
- ✅ **Color Palette**: Professional government theme

### **Responsive Design:**
- ✅ **Mobile-First**: Optimized for mobile devices
- ✅ **Tablet Support**: Perfect display on tablets
- ✅ **Desktop Enhancement**: Full desktop experience
- ✅ **Print Styles**: Optimized for printing documents

### **Interactive Features:**
- ✅ **Lazy Loading**: Images load on demand
- ✅ **Real-time Search**: Instant filtering
- ✅ **AJAX Operations**: No page refresh for actions
- ✅ **Toast Notifications**: User feedback system
- ✅ **Modal Dialogs**: Confirmation & form dialogs

### **Accessibility:**
- ✅ **WCAG 2.1 AA**: Accessibility compliance
- ✅ **Keyboard Navigation**: Full keyboard support
- ✅ **Screen Reader**: Compatible with screen readers
- ✅ **High Contrast**: Good contrast ratios
- ✅ **Focus Management**: Proper focus indicators

---

## 🛡️ Keamanan

### **Authentication & Authorization:**
- ✅ **Multi-Level Access**: Guest, Warga, Petugas, Admin
- ✅ **Session Security**: Secure session management
- ✅ **Password Hashing**: bcrypt encryption
- ✅ **Rate Limiting**: Protection against brute force
- ✅ **Account Lockout**: Temporary lock on failed attempts

### **Data Protection:**
- ✅ **CSRF Protection**: Cross-site request forgery prevention
- ✅ **XSS Prevention**: Input sanitization & output escaping
- ✅ **SQL Injection**: Parameter binding protection
- ✅ **File Upload Security**: Type, size, & content validation
- ✅ **Data Encryption**: Sensitive data encryption at rest

### **Network Security:**
- ✅ **HTTPS Enforcement**: SSL/TLS encryption
- ✅ **CORS Configuration**: Cross-origin resource sharing control
- ✅ **Security Headers**: Comprehensive security headers
- ✅ **Input Validation**: Server & client-side validation
- ✅ **Audit Logging**: All security events logged

---

## 📈 Monitoring & Logging

### **System Monitoring:**
- ✅ **Performance Metrics**: Response times & throughput
- ✅ **Error Tracking**: Comprehensive error logging
- ✅ **User Activity**: Audit trails for all actions
- ✅ **Database Health**: Connection & query monitoring
- ✅ **File System**: Storage usage monitoring

### **Logging Features:**
- ✅ **Access Logs**: All user access logged
- ✅ **Error Logs**: Detailed error information
- ✅ **Security Logs**: Security events & violations
- ✅ **Performance Logs**: Slow queries & bottlenecks
- ✅ **Audit Logs**: Data modification tracking

---

## 🧪 Testing

### **Testing Framework:**
```bash
# Run all tests
php spark test

# Run specific test group
php spark test --group models
php spark test --group controllers

# Generate coverage report
php spark test --coverage
```

### **Manual Testing Checklist:**

#### **🔐 Authentication Testing:**
- [ ] Warga registration with valid NIK
- [ ] Warga login with NIK
- [ ] Admin login with email/password
- [ ] Petugas login with email/password
- [ ] Session persistence across pages
- [ ] Logout functionality

#### **📢 Complaint System Testing:**
- [ ] Create complaint with file upload
- [ ] Status update by admin
- [ ] Email notifications
- [ ] Search & filter complaints
- [ ] View complaint details

#### **👥 Warga Management Testing:**
- [ ] Add new warga via admin panel
- [ ] Edit existing warga data
- [ ] Delete warga with confirmation
- [ ] Search & filter warga
- [ ] View detailed warga profile

---

## 🚀 Deployment

### **Production Server Requirements:**
- ✅ **Web Server**: Apache/Nginx with PHP 8.2+
- ✅ **Database**: MySQL 8.0+ or MariaDB 10.5+
- ✅ **SSL Certificate**: HTTPS required for production
- ✅ **File Permissions**: Proper permissions for writable directories
- ✅ **Cron Jobs**: Automated tasks setup

### **Deployment Steps:**

#### **1. Server Preparation**
```bash
# Update system packages
sudo apt update && sudo apt upgrade

# Install PHP 8.2+ and extensions
sudo apt install php8.2 php8.2-mysql php8.2-xml php8.2-curl php8.2-mbstring

# Install MySQL 8.0+
sudo apt install mysql-server-8.0

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### **2. Application Deployment**
```bash
# Clone to production server
git clone https://github.com/your-repo/sistem-pelayanan-masyarakat.git /var/www/html/sistem
cd /var/www/html/sistem

# Install dependencies
composer install --no-dev --optimize-autoloader

# Set proper permissions
sudo chown -R www-data:www-data /var/www/html/sistem
sudo chmod -R 755 /var/www/html/sistem/writable
sudo chmod -R 777 /var/www/html/sistem/writable/logs
sudo chmod -R 777 /var/www/html/sistem/writable/cache
sudo chmod -R 777 /var/www/html/sistem/writable/uploads
```

#### **3. Environment Configuration**
```bash
# Copy production environment
cp env .env.production

# Edit production settings
nano .env.production
```

Production `.env` configuration:
```env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com/'
app.forceGlobalSecureRequests = true

# Production database settings
database.default.hostname = localhost
database.default.database = sistem_prod
database.default.username = sistem_user
database.default.password = secure_password_123
```

#### **4. Database Setup**
```bash
# Create production database
mysql -u root -p
CREATE DATABASE sistem_prod;
CREATE USER 'sistem_user'@'localhost' IDENTIFIED BY 'secure_password_123';
GRANT ALL PRIVILEGES ON sistem_prod.* TO 'sistem_user'@'localhost';
FLUSH PRIVILEGES;
exit;

# Run migrations on production
php spark migrate
php spark db:seed UserSeeder
php spark db:seed JenisLayananSeeder
```

#### **5. Web Server Configuration**

**Apache Configuration:**
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/html/sistem/public

    <Directory /var/www/html/sistem/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sistem_error.log
    CustomLog ${APACHE_LOG_DIR}/sistem_access.log combined
</VirtualHost>
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/sistem/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### **6. SSL Configuration**
```bash
# Install Certbot for Let's Encrypt
sudo apt install certbot python3-certbot-apache

# Get SSL certificate
sudo certbot --apache -d yourdomain.com

# Test SSL configuration
sudo apache2ctl configtest
sudo systemctl reload apache2
```

#### **7. Final Checks**
```bash
# Test application
curl -I https://yourdomain.com/

# Check file permissions
ls -la /var/www/html/sistem/writable/

# Verify database connection
php spark db:table --table=users

# Test admin login
# Visit: https://yourdomain.com/admin/login
```

---

## 📞 Support

### **Documentation:**
- 📖 **User Guide**: Detailed user manual
- 🎥 **Video Tutorials**: Step-by-step guides
- 💬 **FAQ**: Frequently asked questions
- 🐛 **Bug Reports**: Issue tracking system

### **Technical Support:**
- 📧 **Email**: support@kembanganraya.go.id
- 💬 **Live Chat**: Available during business hours
- 📞 **Phone**: (021) 123-4567
- 🕐 **Business Hours**: Mon-Fri 08:00-16:00 WIB

### **Community:**
- 🌐 **Forum**: Community discussion board
- 💬 **Discord**: Real-time community chat
- 📱 **Social Media**: Official social media accounts

---

## 📝 Changelog

### **Version 1.0.0** (Current)
- ✅ Initial release dengan fitur lengkap
- ✅ Portal berita & pengaduan masyarakat
- ✅ Admin dashboard dengan warga management
- ✅ Authentication multi-level
- ✅ Responsive Bootstrap 5 UI
- ✅ File upload & management
- ✅ API endpoints lengkap

### **Upcoming Features:**
- 🔄 **Berita Management**: Full CRUD untuk berita
- 🔄 **Wilayah Management**: RT/RW administration
- 🔄 **Email Notifications**: Automated email system
- 🔄 **SMS Gateway**: SMS notifications
- 🔄 **Mobile App**: React Native mobile application
- 🔄 **Advanced Analytics**: Detailed reporting system

---

## 🤝 Contributing

### **Development Setup:**
```bash
# Fork the repository
git clone https://github.com/your-username/sistem-pelayanan-masyarakat.git
cd sistem-pelayanan-masyarakat

# Create feature branch
git checkout -b feature/new-feature

# Install dependencies
composer install
npm install

# Run tests
php spark test

# Code style check
./vendor/bin/php-cs-fixer fix
```

### **Coding Standards:**
- 📝 **PSR-4**: Autoloading standard
- 📝 **PSR-12**: Extended coding style guide
- 📝 **PHPStan**: Static analysis
- 📝 **PHPUnit**: Unit testing
- 📝 **PHP-CS-Fixer**: Code formatting

### **Commit Guidelines:**
```bash
# Format: [TYPE] Brief description
# Types: feat, fix, docs, style, refactor, test, chore

git commit -m "feat: add warga management dashboard"
git commit -m "fix: resolve complaint status update bug"
git commit -m "docs: update API documentation"
```

---

## 📜 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 Pemerintah Kembangan Raya

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

---

## 🙏 Acknowledgments

- **CodeIgniter Team** - Excellent PHP framework
- **Bootstrap Team** - Amazing CSS framework
- **Pemerintah Kembangan Raya** - Support & requirements
- **Open Source Community** - Libraries & tools

---

## 🎯 Quick Start

```bash
# 1. Clone & Install
git clone https://github.com/your-repo/sistem-pelayanan-masyarakat.git
cd sistem-pelayanan-masyarakat
composer install

# 2. Setup Database
mysql -u root -p -e "CREATE DATABASE sistem_pelayanan_masyarakat;"
php spark migrate
php spark db:seed UserSeeder

# 3. Configure Environment
cp env .env
# Edit .env with your database settings

# 4. Start Server
php spark serve --host 0.0.0.0 --port 8081

# 5. Access Application
# Frontend: http://localhost:8081
# Admin: http://localhost:8081/admin/login
# Admin credentials: admin@sistem.com / admin123
```

---

**🏛️ Sistem Pelayanan Masyarakat Kembangan Raya - Melayani dengan Sepenuh Hati** 💙🇮🇩
