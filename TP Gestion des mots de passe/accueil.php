<?php

echo "Question 1 : Pour le premier c'est un MD5, pour le second c'est un SHA256";
echo "<br><br>";

echo "Question 2 : 8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918 = admin (SHA256) 
541616566e62564b788910f190cb70e6 = supermanX (MD5)";
echo "<br><br>";

echo "Question 3 : = MD5 =$1$ " . crypt("Vive#Les#S1aux", '$1$duSel$');
echo "<br><br>";

echo "Question 4 : = SHA256 =$5$ " . crypt("Vive#Les#S1aux", '$5$duSel$');
echo "<br><br>";

echo "Question 5 : = SHA512 =$6$ " . crypt("Vive#Les#S1aux", '$6$duSel$');

echo "Question 6 : "

?>
