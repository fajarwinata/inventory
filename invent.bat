@echo off
cls
:start
@start /b "" server\apache\bin\httpd.exe

echo WEI Tech Corporation by Fajar Winata
echo SISTEM INVENTORY PT BINAKARIR
echo ====================
echo.
echo Biarkan jendela ini terbuka saat aplikasi digunakan
echo Pilih Salah Satu Browser dibawah:
echo.

	echo.
	echo 1. Mozilla Firefox
	echo 2. Google Chrome
	echo.
	echo.	
	set /p pilihan=Pilih nomor Browser yang akan digunakan: & echo.
echo ====================
	@start /b "" server\mysql\bin\mysqld
	IF '%pilihan%' == '%pilihan%' GOTO Item_%pilihan%
	:Item_1
	start /MIN /D"C:\Program Files\Mozilla Firefox" firefox.exe http://localhost/inventory
	GOTO Start
	:Item_2
	start /MIN /D"C:\Program Files\Google\Chrome\Application" chrome.exe http://localhost/inventory
	GOTO Start
	
	