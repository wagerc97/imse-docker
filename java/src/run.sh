#!/bin/sh
#exec cd /var/src/
#exec javac Main.java
#exec java -jar Main.jar

#project_dir="/var/java/src"
#cd $project_dir
echo "Compiling Test project.."
#if [ javac Main.java ] && [ javac DatabasHelper.java ] && [ jvavac TestConnection.java ] && [ javac HelloWorld.java ];
if [ javac HelloWorld.java ];
then
   echo "Compilation successful! Running project Test"
   java HelloWorld
else
   echo "Compilation failed. Cannot run project"
fi