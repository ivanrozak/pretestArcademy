<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "arkademy";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, 
			"UPDATE produk set
				nama_produk = '$_POST[tnama_produk]',
				keterangan = '$_POST[tketerangan]',
				harga = '$_POST[tharga]',
				jumlah = '$_POST[tjumlah]'
				WHERE id_produk = '$_GET[id]'
			");
			if($edit) //jika edit sukses
			{
				echo "<script>
				alert('Edit data suksess!');
				document.location='index.php';
				</script>";
			}
			else
			{
				echo "<script>
				alert('Edit data GAGAL!!');
				document.location='index.php';
				</script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, 
			"INSERT INTO produk (nama_produk, keterangan, harga, jumlah)
			VALUES ('$_POST[tnama_produk]', 
					'$_POST[tketerangan]', 
					'$_POST[tharga]', 
					'$_POST[tjumlah]')
			");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
				alert('Simpan data suksess!');
				document.location='index.php';
				</script>";
			}
			else
			{
				echo "<script>
				alert('Simpan data GAGAL!!');
				document.location='index.php';
				</script>";
			}
		}	
	}
	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vnama_produk = $data['nama_produk'];
				$vketerangan = $data['keterangan'];
				$vharga = $data['harga'];
				$vjumlah = $data['jumlah'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$_GET[id]' ");
			if($hapus){
				echo "<script>
				alert('Hapus Data Suksess!!');
				document.location='index.php';
				</script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Arkademy Pre Test</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

	<h1 class="text-center">Pretest Arkademy Bootcamp</h1>
	<h2 class="text-center">Web CRUD menggunakan PHP, mySQL dan bootstrap</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Produk
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nama Produk</label>
	    		<input type="text" name="tnama_produk" value="<?=@$vnama_produk?>" class="form-control" placeholder="Input Nama Produk disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Keterangan</label>
	    		<input type="text" name="tketerangan" value="<?=@$vketerangan?>" class="form-control" placeholder="Input Keterangan disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Harga</label>
	    		<input type="text" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Input Harga disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Jumlah</label>
	    		<input type="text" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Input Jumlah disini!" required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Produk
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nama Produk</th>
	    		<th>Keterangan</th>
	    		<th>Harga</th>
	    		<th>Jumlah</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from produk order by id_produk desc");
	    		while($data = mysqli_fetch_array($tampil)) :
	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nama_produk']?></td>
	    		<td><?=$data['keterangan']?></td>
	    		<td><?=$data['harga']?></td>
	    		<td><?=$data['jumlah']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_produk']?>" class="btn btn-warning"> Edit </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_produk']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>