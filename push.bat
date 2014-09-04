@echo off
IF %1.==. GOTO COMMENT
cd ./system/db
cd
git add *
git commit -a -m %1
git push origin master
cd ../
cd
git add *
git commit -a -m %1
git push origin master
cd ../skins/mp7
cd
git add *
git commit -a -m %1
git push origin master
cd ../../
cd
git add *
git commit -a -m %1
git push origin master
GOTO END
:COMMENT
echo no commit comment
:END