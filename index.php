<?php
// untuk memanggil file
include 'Crud.php';
// untuk mendeklarasikan class menjadi variabel
$crud = new Crud();
$arrayName = $crud->readGejala();

?>
<script type="text/javascript">
    function EnableDisableTextBox(gejala) {	
		
        var kondisi = document.getElementById("kondisi"+gejala);
		isCheckGejala = document.getElementById('gejala'+gejala).checked;
		

        if (isCheckGejala) {
			kondisi.disabled = gejala.checked ;
            kondisi.removeAttr();
			
        }else {
			kondisi.disabled = !gejala.checked ;
			kondisi.setAttribute("disabled");
			
		}
    }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Kecerdasan buatan Metode CF (Certainty Factor)</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 style="text-align: center;">Kecerdasan Buatan Metode CF (Certainty Factor)</h1>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="col-lg-12">
			<table width="1000" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000099">
				<tr>
					<td align="center" valign="top" bgcolor="#FFFFFF"><br />
						<form name="form1" method="post" action="hasil.php"><br>
							<table align="center" width="600" class="table table-bordered table-striped table-hover">
								<th bgcolor="#DBEAF5">NO</th>
								<th bgcolor="#DBEAF5">GEJALA</th>
								<th bgcolor="#DBEAF5" colspan ="2">KONDISI</th>
							
								<tr>
									<?php
									// untuk membuat array
									foreach ($arrayName as $r) {
									?>
								<tr>
									<td>
										<?php echo $r['id_gejala']; ?>
									</td>
									<td width="600">
										<?php echo $r['nama_gejala']; ?>
									</td>
									<td>
										
										<input id="gejala<?php echo $r['id_gejala'];?>" name="gejala[]" type="checkbox" value="<?php echo $r['id_gejala']; ?>" onclick="EnableDisableTextBox(<?php echo $r['id_gejala'];?>)"/>
										<br />
									
									</td>
									<td>
									<select id="kondisi<?php echo $r['id_gejala'];?>" name="kondisi[]" disabled="disabled">
									  
	                                   <option  value="1.0" >PASTI IYA</option>
	                                   <option  value="0.8" >HAMPIR PASTI IYA</option>
	                                   <option  value="0.6">KEMUNGKINAN BESAR IYA</option>
	                                   <option  value="0.4">MUNGKIN IYA</option>
                                       <option  value="0">TIDAK TAHU</option>
	                                   <option  value="-0.4">MUNGKIN TIDAK</option>
	                                   <option  value="-0.6">KEMUNGKINAN BESAR TIDAK</option>
                                       <option  value="-0.8">HAMPIR PASTI TIDAK</option>
	                                   <option  value="-1.0">PASTI TIDAK</option> 
                                        </select>
										<br />
									</td>
								<?php
									}
								?>
								<tr>
									<td colspan="4" align="center"><input type="submit" name="button" value="Proses"></td>
								</tr>
							</table>
							<br>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>

</html>