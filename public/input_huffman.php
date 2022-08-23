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
     <h3 class="text-center my-2">Algoritma Kompresi Huffman</h3>
        <div class="card row-col-2">
            <div class="card-header">
                Algorima Kompresi Huffman
            </div>
            <div class="card-body">
                <p class="text-danger">Masukkan file teks yang akan di kompres!!</p>
                <form action="kompres_huffman.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="dokumen" name="dokumen" required>
                    </div>
                    <div class="">
                        <a href="index.php" class="btn btn-danger d-inline-flex">Kembali</a>
                        <button type="submit" class="btn btn-primary">Kompres</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>