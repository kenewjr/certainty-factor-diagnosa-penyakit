<?php
    // untuk memanggil file
    include 'Crud.php';
    
    // untuk mendeklarasikan class menjadi variabel
    $crud = new Crud();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kecerdasan Buatan Metode CF (Certainty Factor)</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12" style="margin-bottom: 10px;">
        <h1 style="text-align: center;">Kecerdasan Buatan Metode CF (Certainty Factor)</h1>
        <a class="btn btn-primary" href="index.php"><< Kembali</a><br/>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav class="nav nav-tabs" id="myTab" role="tablist">
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Proses Perhitungan</a>
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Hasil Perhitungan</a>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div row>
              <div class="col-md-12" style="text-align: center;">
                <?php
                  if (isset($_POST['button']))
                  {
                    // group kemungkinan terdapat penyakit
                    $groupKemungkinanPenyakit = $crud->getGroupPengetahuan(implode(",", $_POST['gejala']));

                    // menampilkan kode gejala yang di pilih
                    $sql = $_POST['gejala'];    
                    $test = $_POST['kondisi']; 
                    $wxgejala =implode( $_POST['gejala']);
                    $host="localhost";
                      $id="root";
                      $password="";
                      $db="diagnosa";  
                   
                    if (isset($sql)) {
                      // mencari data penyakit kemungkinan dari gejala
                    
                      for ($h=0; $h < count($sql); $h++) {
                        $kemungkinanPenyakit[] = $crud->getKemungkinanPenyakit($sql[$h]);
                        
                        
                        for ($x=0; $x < count($kemungkinanPenyakit[$h]); $x++) {
                          for ($i=0; $i < count($groupKemungkinanPenyakit); $i++) {
                            $namaPenyakit = $groupKemungkinanPenyakit[$i]['nama_penyakit'];               
                         
                            if ($kemungkinanPenyakit[$h][$x]['nama_penyakit'] == $namaPenyakit) {
                              // list di kemungkinan dari gejala
                                             
                              // echo '<pre>'; var_dump($kemungkinanPenyakit[$h][$x]['id_pengetahuan']);
                              $listIdKemungkinan[$namaPenyakit][] = $kemungkinanPenyakit[$h][$x]['id_pengetahuan'];
                            
                          }
                          }
                          $pengetahuanid[] = $kemungkinanPenyakit[$h][$x]['id_pengetahuan'];  
                          // echo '<pre>'; var_dump($pengetahuanid) ;       
                      
                        }
                      }     
                         
                            /**
                         * @var float|array $test
                       */               
                     
                      for ($ba = 0; $ba < count($sql); $ba++) {                      
                      $updatemb = "UPDATE pengetahuan SET mb=$test[$ba] WHERE id_gejala = $wxgejala[$ba]";
                      $kon = mysqli_connect($host,$id,$password,$db);
                      $query = mysqli_query($kon,$updatemb);
                      //  if(mysqli_affected_rows($kon)>0){
                      //  echo 'data berhasil diubah'; 
                      //  echo "<br/>";
                      //  echo var_dump((int)$wxgejala);
                      //  echo "<br/>";
                      //  echo  var_dump($test[$ba]);
                      
                      //  }else{
                      // echo 'data gagal diubah';
                      //  echo "<br/>";
                      //  echo  var_dump($wxgejala[$ba]);
                     
                      //  echo  var_dump($test[$ba]);
                      //  }
                    }               
                      $id_penyakit_terbesar = '';
                      $nama_penyakit_terbesar = '';
                      $kombin=[];
                      $cfkombin=0;     
                  
                      // list penyakit kemungkinan
                      for ($h=0; $h < count($groupKemungkinanPenyakit); $h++) { 
                        $namaPenyakit = $groupKemungkinanPenyakit[$h]['nama_penyakit'];
                        $cfuser=[];         
                        echo "<br/>===========================================".
                        "<br/>Proses Penyakit ".$h.".".$namaPenyakit.
                        "<br/>===========================================<br/>";                     
                        // list penyakit kemungkinan dari gejala    
                        for ($x=0; $x < count($listIdKemungkinan[$namaPenyakit]); $x++) { 
                          
                          $daftarKemungkinanPenyakit = $crud->getListPenyakit($listIdKemungkinan[$namaPenyakit][$x]);                    
                          echo "<br/>proses ".$x."<br/>-------------------------------------------<br/>";          
                          for ($i=0; $i < count($daftarKemungkinanPenyakit); $i++) {   
                           
                            $persen = 100;
                            $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];
                            $mdbaru = (float)($mdbaru);
                              if (count($listIdKemungkinan) == 1) {
                            
                                
                                echo "Jumlah Gejala = ".
                                  count($listIdKemungkinan[$namaPenyakit])."<br/>";                     
                                // bila list kemungkinan terdapat 1
                                $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                                $md = $daftarKemungkinanPenyakit[$i]['md'];
                                $cf = $mb * $md;
                                $cf1 =$cf*$persen;
                                $daftar_cf[$namaPenyakit][] = $cf;
                                echo "<br/>proses 1<br/>-------------------------------------------<br/>";
                                echo "cfR = ".$mb."<br/>";
                                echo "cfEvid = ".$md."<br/>";
                                echo "cf = cfR * cfEvid = ".$mb." * ".$md." = ".$cf1."%"."<br/><br/><br/>";
                                // end bila list kemungkinan terdapat 1
                                
                              } else {
                                // list kemungkinanan lebih dari satu                               
                                if ($x == 0)
                                {
                                //  if($x==4){
                                //    $x=$x-1;
                                //  }                           
                                  echo "Jumlah Gejala = ".
                                  count($listIdKemungkinan[$namaPenyakit])."<br/>";
                                  // record md dan mb sebelumnya
                                  // md yang di esekusi
                                  $mb = $daftarKemungkinanPenyakit[$i]['mb'];
                                  $md = $daftarKemungkinanPenyakit[$i]['md'];
                                  echo "<br/>";
                                  echo "cfR = ".$mb ."<br/>";
                                  echo "cfEvid = ".$md."<br/>";
                                  $cf = $mb * $md;
                                  $cf1=$cf*$persen;
                                  $cflama= $cf;
                                  $cfkombin=$cflama;
                                  echo "cf = cfR * cfEvid = ".$mb." * ".$md." = ".$cf."<br/>";
                                  echo "cf = cf * 100% = ".$cf." * ".$persen." = ".$cf1."%"."<br/><br/><br/>";
                                  $daftar_cf[$namaPenyakit][] = $cf;  
                                  array_push($kombin, $cflama);                                
                                }                       
                                else {
                                if($mdbaru>0 && $kombin>0)
                                {            
                              //     echo  var_dump($mdbaru); 
                              // echo "<br/>";           
                              // echo  var_dump(current($kombin));
                              // echo "<br/>";                       
                                  $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];    
                                  $cflama=0;
                                  for ($z=0; $z < count($kombin); $z++) {                            
                                       $cflama = $kombin[$z] +($mdbaru*(1-$kombin[$z]));    
                                  }array_push($kombin, $cflama);
                                    echo "cfbaru = ".$mdbaru."<br/>";
                                     echo " cflama = ".$kombin[$z-1]."<br/>";               
                                      echo "proses CF = cflama + (cfbaru * (1 - cflama)) = ".$kombin[$z-1]." + ($mdbaru * (1 - ".$kombin[$z-1].")) = ".$cflama."<br/>";
                                      $cf = $cflama * $persen;
                                      echo "cf = CFlama - 100% = ".$cflama." * ".$persen."%". " = ".$cf."%"."<br/><br/><br/>";                                               
                                  $daftar_cf[$namaPenyakit][] = $cf;            
                                
                            } else if($mdbaru<-0 && $kombin<-0)
                            {           
                              // echo  var_dump($mdbaru); 
                              // echo "<br/>";           
                              // echo  var_dump($kombin);
                              // echo "<br/>";                                              
                              $mdbaru = $daftarKemungkinanPenyakit[$i]['md'];     
                              $cflama=0;
                              for ($z=0; $z < count($kombin); $z++) {                            
                                   $cflama = $kombin[$z] +($mdbaru*(1+$kombin[$z]));    
                              }array_push($kombin, $cflama);
                                echo "cfbaru = ".$mdbaru."<br/>";
                                 echo " cflama = ".$kombin[$z-1]."<br/>";               
                                  echo "proses CF = cflama + (cfbaru * (1 + cflama)) = ".$kombin[$z-1]." + ($mdbaru * (1 + ".$kombin[$z-1].")) = ".$cflama."<br/>";
                                  $cf = $cflama * $persen;
                                  echo "cf = CFlama - 100% = ".$cflama." * ".$persen."%". " = ".$cf."%"."<br/><br/><br/>";                                               
                              $daftar_cf[$namaPenyakit][] = $cf;  

                            }  else if($mdbaru<-0 || $kombin<-0)
                            {                                                               
           
                              for ($z=0; $z < count($kombin); $z++) {                            
                                   $cflama = ($kombin[$z] +$cfkombin)/(1-min(abs($kombin[$z]),abs($cfkombin)));    
                              }array_push($kombin, $cflama);
                                echo "cfbaru = ".$cfkombin."<br/>";
                                 echo "cflama = ".$kombin[$z-1]."<br/>";               
                                  echo "proses CF = {CF1 + CF2} / (1-min{| CF1|,| CF2|})  = (".$kombin[$z-1]."+".$cfkombin.")/(1-min{|".$kombin[$z-1]."|,|".$cfkombin."|}) = ".$cflama."<br/>";
                                  $cf = $cflama * $persen;
                                  echo "cf = CFlama - 100% = ".$cflama." * ".$persen."%". " = ".$cf."%"."<br/><br/><br/>";                                               
                              $daftar_cf[$namaPenyakit][] = $cf;  
                          }
                           // end list kemungkinanan lebih dari satu
                        }
                      }
                            }
                            
                        }
                      }
                    }
                ?>
                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row">
              <div class="col-md-12" style="text-align: center;">
                <?php           
                  $crud->hasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit);
                   $crud->hasilAkhir($daftar_cf,$groupKemungkinanPenyakit);
                   $historytinggicf=$crud->hasilCFTertinggi($daftar_cf,$groupKemungkinanPenyakit);
                   $historyhasilakhir= $crud->hasilAkhir($daftar_cf,$groupKemungkinanPenyakit);               
                  }

                 ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
