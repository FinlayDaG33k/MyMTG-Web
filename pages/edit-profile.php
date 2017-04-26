<script>
	$(document).ready(function() {
		$("#editprofile").submit(function(event) {
			event.preventDefault();
			$("#waiting").modal({
				backdrop: 'static',
				keyboard: false
			});
			let Userdata = $.parseJSON($.cookie('Userdata'));
			Userdata = Userdata.message;
			let data = $(this).serialize() +'&'+$.param({'Authtoken':Userdata.Authtoken})+'&'+$.param({'Username':Userdata.Username});
			$.ajax({
			  type: "POST",
			  url: "https://mymtg-api.finlaydag33k.nl/index.php",
			  data: data,
			  success: function(json){
					$('#waiting').modal('hide');
					let data = $.parseJSON(json);
					switch(data.code){
						case 200:
							<?= sendNotification("<strong>Hooraay!</strong><br />Our goblins returned with the news that everything went right!","success"); ?>
							break;
						case 500:
							<?= sendNotification("<strong>Well ehm...</strong><br />Unfortunately, our goblins lost their way. Please try again!","danger"); ?>
							break;
						case 400:
							<?= sendNotification("<strong>Invalid Captcha!</strong><br />It seems that the captcha you\'ve entered is invalid. Please try again!","danger"); ?>
							break;
						default:
							<?= sendNotification("<strong>Well ehm...</strong><br />It seems that something went wrong. Please try again!","danger"); ?>
							break;
					}
				}
			});
		});
	});
</script>


<?php
	if(!empty($cookieData)){
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Userdata</h3>
					</div>
					<div class="panel-body">
						<form id="editprofile" class="form-horizontal">
							<div class="form-group">
								<div class="col-lg-10">
									<input class="form-control" name="realName" placeholder="Real Name" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10">
									<input class="form-control" name="DCINumber" placeholder="DCI Number" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="text">
									<br />
									<div id="RecaptchaField1"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<input type="hidden" name="action" value="editProfile">
									<button type="reset" class="btn btn-default">Cancel</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Account</h3>
					</div>
					<div class="panel-body">
						<form id="editprofile" class="form-horizontal">
							<div class="form-group">
								<div class="col-lg-10">
									<input type="checkbox" name="killsessions" value=""> Logout Everywhere (including here)
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10">
									<input type="checkbox" name="deactivate" value=""> Deactivate Account
									<br />
									<div id="RecaptchaField2"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<input type="hidden" name="action" value="editaccount">
									<button type="reset" class="btn btn-default">Cancel</button>
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		-->
		</div>
		<?php
	}else{
		?>
			Please login to continue!
		<?php
	}
