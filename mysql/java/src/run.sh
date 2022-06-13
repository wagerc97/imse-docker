#!/bin/sh
#pwd
#project_dir="/var/java/src"
#cd $project_dir
echo "=== run.sh start ==="
pwd
ls
echo "Compiling Test project..."
if ( javac *.java -verbose );
then
   echo "Compilation successful!"
   ls
   java HelloWorld
   java Main
else
   echo "Compilation failed. Cannot run project"
fi
echo "=== run.sh end ==="
