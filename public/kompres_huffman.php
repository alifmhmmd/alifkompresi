<?php
require 'huffmancoding.php';
// var_dump($_FILES);
# kode dapat inputan file upload
// print_r($_FILES); 
// echo "<br>";
// mkdir('berkas');

$namafile = $_FILES['dokumen']['name']; 
$ekstensi = pathinfo($namafile,PATHINFO_EXTENSION);
$file = $_FILES['dokumen']['tmp_name']; 
$ukuran = filesize($file);
$buka = fopen($file, 'r');
$baca = fread($buka, $ukuran); 

# kode proses encoding huffman
$start_encoding = microtime(TRUE);
$getChar = HuffmanCoding::getCharacter($baca);
$encoding = HuffmanCoding::createCodeTree ($baca);
$encoded = HuffmanCoding::encode ($baca, $encoding);
$dir_encoding = "encoding-huffman";
if( is_dir($dir_encoding) === false )
{
    mkdir($dir_encoding);
}
$newfile = fopen($dir_encoding.'/'.'encoding-'.$namafile.'.'.$ekstensi, 'w');
fwrite($newfile, $encoded);
fclose($newfile);
$finish_encoding = microtime(TRUE);
$totaltimeencoding = $finish_encoding - $start_encoding;

#kode proses decoding huffman
$start_decoding = microtime(TRUE);
$decoded = HuffmanCoding::decode ($encoded);
$dir_decoding = "decoding-huffman";
if( is_dir($dir_decoding) === false )
{
    mkdir($dir_decoding);
}
$newfile_decoding = fopen($dir_decoding.'/'.'decoding-'.$namafile.'.'.$ekstensi, 'w');
fwrite($newfile_decoding, $decoded);
fclose($newfile_decoding);
assert ($decoded == $baca);
$finish_decoding = microtime(TRUE);
$totaltimedecoding = $finish_decoding - $start_decoding;

// echo "\tUkuran File Awal sebelum dikompres: " . strlen ($baca) . " bytes \n <br>";
// echo "\tEncoded Tree: " . strlen ($encoding) . "\n <br>";
// echo "\tUkuran File Setelah dikompres: " . strlen ($encoded) . " bytes\n <br>";
// echo "\tRasio Kompresi: " . number_format (((strlen ($baca) - strlen ($encoded)) / strlen ($baca)) * 100, 2) . "%\n\n  <br>";
// echo "Waktu Kompresi: ".number_format($totaltime,2) ."detik"; 

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <title>Algoritma Huffman</title>
</head>
<body>
    <div class="container">
        <h3 class="text-center my-4">Hasil Kompresi Algoritma Huffman</h3>
        <table class="table table-bordered">
            <tr>
            <td>Nama File :</td>
            <td><?= $namafile; ?></td>
            </tr>
            <tr>
            <!-- <td>Frekuensi Karakter :</td>
            <td>
                <?php 
                    // print_r($getChar);
                ?>  
            </td> -->
            </tr>
            <tr>
            <td>Ukuran File Sebelum dikompres :</td>
            <td><?= strlen ($baca); ?> bytes</td>
            </tr>
            <tr>
            <td>Ukuran File Setelah di kompres :</td>
            <td><?= strlen ($encoded); ?> bytes</td>
            </tr>
            <tr>
            <td>Rasio Kompresi :</td>
            <td><?= number_format (((strlen ($baca) - strlen ($encoded)) / strlen ($baca)) * 100, 2); ?> % </td>
            </tr>
            <tr>
            <td>Waktu Kompresi :</td>
            <td><?= number_format($totaltimeencoding,2); ?> detik</td>
            </tr>
            <tr>
            <!-- <td>Encoded Tree :</td>
            <td> </td>
            </tr> -->
            <tr>
            <!-- <td>Waktu Dekompresi :</td>
            <td><?
            //  number_format($totaltimedecoding,2); ?> detik</td>
            </tr> -->
        </table>
        <a href="index.php" class="btn btn-danger">Kembali</a>
        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
