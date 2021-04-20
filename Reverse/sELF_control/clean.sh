#!/bin/bash

cd ~/HeroCTF
rm $(ls | grep "^.\{8\}\(-.\{4\}\)\{3\}-.\{12\}$")
