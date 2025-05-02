@echo off
SET HOST=ftpupload.net
SET USER=epiz_12345678
SET PASS=LA_TUA_PASSWORD
SET LOCALDIR=C:\Percorso\al\tuo\sito
SET REMOTEDIR=/htdocs

echo open %HOST%> ftpcmd.dat
echo %USER%>> ftpcmd.dat
echo %PASS%>> ftpcmd.dat
echo binary>> ftpcmd.dat
echo lcd %LOCALDIR%>> ftpcmd.dat
echo cd %REMOTEDIR%>> ftpcmd.dat

:: Carica tutti i file dal locale al server
for /R "%LOCALDIR%" %%F in (*.*) do (
    set "FILE=%%~nxF"
    call echo put "%%F" >> ftpcmd.dat
)

echo bye>> ftpcmd.dat
ftp -n -s:ftpcmd.dat
del ftpcmd.dat

echo Upload completato!
pause
