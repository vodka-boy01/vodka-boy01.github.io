@echo off
cd /d "C:\Users\tonyk\Desktop\CODING\firebase\esame_di_stato"
echo Deploying Firebase from %CD%
firebase deploy
echo Operazione completata. Premi un tasto per chiudere...
pause >nul
