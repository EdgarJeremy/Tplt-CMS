<?php
require_once "engine/init.php";
$helper->logged_out_protect();
$helper->admin_area_protect();
if(isset($_POST["btnSubmit"])) {
  $cond = $infoweb->setInfoWeb($_POST["nama_web"],$_POST["deskripsi_web"]);
  if($cond === true) {
    $helper->set_flashdata("green","Informasi website berhasil diupdate!");
    $helper->buatLog("Update Informasi Web","Informasi web diubah oleh ".$_SESSION["nama_lengkap"]);
  } else {
    $helper->set_flashdata("red","Terjadi kesalahan saat mengupdate informasi website!");
    $helper->buatLog("Percobaan Update Informasi Web","User ".$_SESSION["nama_lengkap"]." gagal mengupdate informasi web");
  }
  header("location: infoweb");
  exit();
}

$menu = $helper->tentukan_menu_aktif("infoweb");
$title = "Informasi Website - Administrator";
include "frames/menu.php";
?>

    <div class="content">
      <?php $helper->get_notif();?>
      <div class="main-box">
        <div class="header">
          <h1>Update Informasi Web</h1>
        </div>
        <div class="contain card">
          <form class="inside" method="post">
            <div class="input-group">
              <p><b>Nama Web</b></p>
              <input id="nama_web" type="text" name="nama_web" class="input-text" value="<?php echo $infoweb->ambilNamaWeb();?>" required/>
            </div>
            <div class="input-group">
              <p><b>Deskripsi Web</b></p>
              <textarea id="deskripsi_web" name="deskripsi_web" class="input-text textarea"><?php echo $infoweb->ambilDeskripsiWeb();?></textarea>
            </div>
            <div class="input-group">
              <button id="send" type="submit" name="btnSubmit" class="btn" disabled="true"><i class="fa fa-edit fa-lg"></i>&nbsp;Perbarui Informasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){

        function deteksiPerubahan(nama_web_input,deskripsi_input) {
          var nama_web = "<?php echo $infoweb->ambilNamaWeb();?>";
          var deskripsi = "<?php echo $infoweb->ambilDeskripsiWeb();?>";
          if(nama_web != nama_web_input || deskripsi != deskripsi_input) {
            return true;
          } else {
            return false;
          }
        }

        $("#nama_web").on("keyup",function(){
          if(deteksiPerubahan($(this).val(),$("#deskripsi_web").val())) {
            $("#send").addClass("blue").prop("disabled",false);
          } else {
            $("#send").removeClass("blue").prop("disabled",true);
          }
        });
        $("#deskripsi_web").on("keyup",function(){
          if(deteksiPerubahan($("#nama_web").val(),$(this).val())) {
            $("#send").addClass("blue").prop("disabled",false);
          } else {
            $("#send").removeClass("blue").prop("disabled",true);
          }
        });

        $("#alert").on("click",function(){
          $(this).fadeOut(100);
        });
      });
    </script>

<?php include "frames/footer.php";?>
