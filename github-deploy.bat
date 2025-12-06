@echo off
echo ================================================
echo SISTEM PELAYANAN MASYARAKAT KEMBANGAN RAYA
echo GitHub Deployment Script
echo ================================================
echo.

set /p repo_url="Masukkan GitHub repository URL: "

echo.
echo Menambahkan remote origin...
git remote add origin %repo_url%

echo.
echo Mendorong ke GitHub...
git push -u origin master

echo.
echo ================================================
echo DEPLOYMENT SELESAI!
echo ================================================
echo.
echo Repository GitHub: %repo_url%
echo.
echo 🎉 Selamat! Sistem Pelayanan Masyarakat Kembangan Raya
echo    telah berhasil di-deploy ke GitHub!
echo.
echo 📋 Yang perlu dilakukan selanjutnya:
echo 1. Buka repository di GitHub untuk memverifikasi
echo 2. Setup GitHub Actions untuk CI/CD (opsional)
echo 3. Invite collaborators jika diperlukan
echo 4. Setup project boards untuk development tracking
echo.
echo 🏛️ Sistem siap untuk collaboration & deployment!
echo ================================================

pause
