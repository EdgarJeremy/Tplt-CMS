
		<div class="overlay" id="edit-profile">
			<div class="popup-body">
				<div class="contain card">
					<div class="head">
						<span class="fa fa-close fa-lg close"></span>
						<h1><i class="fa fa-pencil-square-o fa-lg"></i>&nbsp;Edit Profile</h1><hr />
						<div class="form">
							<form action="updateDataUser" method="post">
							<input type="hidden" name="currFile" value="<?php echo explode(".",end(explode("/",$_SERVER["PHP_SELF"])))[0];?>"/>
							<div class="input-group">
								<p>Username : </p>
								<input id="username" type="text" name="username" value="<?php echo $_SESSION["username"];?>" class="input-text"/>
							</div>
							<div class="input-group">
								<p>Nama Lengkap : </p>
								<input id="nama_lengkap" type="text" name="nama_lengkap" value="<?php echo $_SESSION["nama_lengkap"];?>" class="input-text" />
							</div>
							<div class="input-group">
								<p>Email : </p>
								<input id="email" type="email" name="email" value="<?php echo $_SESSION["email"];?>" class="input-text" />
							</div>
							<div class="input-group">
								<p>Password : </p>
								<input id="password" type="text" name="password" class="input-text" />
							</div>
						</div>
					</div>
					<div class="input-group">
						<button type="submit" class="btn disabled" id="confirmEditProfile" disabled="true"><i class="fa fa-pencil-square fa-lg"></i>&nbsp;Save</button> <button type="button" class="btn red batal"><i class="fa fa-chevron-circle-left fa-lg"></i>&nbsp;Batal</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<footer>
		</footer>
		<script src="js/sidebar.js">
		</script>
		<script>
			$(document).ready(function(){
        function deteksiPerubahan(username_input,nama_lengkap_input,email_input,password_input) {
          var username = "<?php echo $_SESSION["username"];?>";
          var nama_lengkap = "<?php echo $_SESSION["nama_lengkap"];?>";
					var email = "<?php echo $_SESSION["email"];?>";
          if(username != username_input || nama_lengkap != nama_lengkap_input || email != email_input || password_input != "") {
            return true;
          } else {
            return false;
          }
        }
				$("#username").on("keyup",function(){
					if(deteksiPerubahan($(this).val(),$("#nama_lengkap").val(),$("#email").val(),$("#password").val())) {
						$("#confirmEditProfile").addClass("blue").prop("disabled",false);
					} else {
						$("#confirmEditProfile").removeClass("blue").prop("disabled",true);
					}
				});
				$("#nama_lengkap").on("keyup",function(){
					if(deteksiPerubahan($("#username").val(),$(this).val(),$("#email").val(),$("#password").val())) {
						$("#confirmEditProfile").addClass("blue").prop("disabled",false);
					} else {
						$("#confirmEditProfile").removeClass("blue").prop("disabled",true);
					}
				});
				$("#email").on("keyup",function(){
					if(deteksiPerubahan($("#username").val(),$("#nama_lengkap").val(),$(this).val(),$("#password").val())) {
						$("#confirmEditProfile").addClass("blue").prop("disabled",false);
					} else {
						$("#confirmEditProfile").removeClass("blue").prop("disabled",true);
					}
				});
				$("#password").on("keyup",function(){
					if(deteksiPerubahan($("#username").val(),$("#nama_lengkap").val(),$("#email").val(),$(this).val())) {
						$("#confirmEditProfile").addClass("blue").prop("disabled",false);
					} else {
						$("#confirmEditProfile").removeClass("blue").prop("disabled",true);
					}
				});
				$("#edit-profile-btn").on("click",function(){
					$(".overlay#edit-profile").fadeIn(100);
					$("#edit-profile .popup-body").slideDown(300);
				});
				function closePopup() {
					$(".overlay").fadeOut(100);
					$(".popup-body").slideUp(300);
				}
				$(".close").on("click",closePopup);
				$(".batal").on("click",closePopup);

				$(".alert").addClass("come");
				setInterval(function(){
					$(".alert").addClass("out");
				},3000);
			});
		</script>
	</body>
</html>
