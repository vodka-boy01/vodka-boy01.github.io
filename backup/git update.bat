@echo off
cd /d "C:\Users\tonyk\Desktop\CODING\firebase\esame_di_stato\luigi-tanzillo.com"
git status
git add .
git commit -m "Deploy Firebase e aggiornamento file"
git push origin main
pause