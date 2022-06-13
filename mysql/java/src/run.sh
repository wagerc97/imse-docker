#!/bin/sh
#pwd
#project_dir="/var/java/src"
#cd $project_dir
echo "[INFO] === run.sh start ==="
pwd
ls
echo "[INFO] Compiling Test project..."
if ( javac *.java -verbose );
then
   echo "[SUCCESS] Compilation successful!"
   ls
   echo "[INFO] Run HelloWorld..."
   java HelloWorld
   echo "[INFO] Run Main..."
   java Main
else
   echo "[FAIL] Compilation failed. Cannot run project"
fi
echo "[INFO] === run.sh end ==="
