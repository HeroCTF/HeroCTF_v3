#!/usr/bin/env bash

unzip -q archive.zip

folder=you
nb=1

while [ $nb -gt 0 ]
do
	cd $folder
	folder=$(ls -d */ 2>/dev/null)
	nb=$(ls -d */ 2>/dev/null | wc -l)
done
	
cat flag.txt