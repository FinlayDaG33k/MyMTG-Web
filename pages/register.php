<script>
	$(document).ready(function() {
		$("#passwordForm").submit(function(event) {
			event.preventDefault();
			$("#waiting").modal({
				backdrop: 'static',
				keyboard: false
			});
			$.ajax({
			  type: "POST",
			  url: "https://mymtg-api.finlaydag33k.nl/index.php",
			  data: $(this).serialize(),
			  success: function(json){
					$('#waiting').modal('hide');
					let data = $.parseJSON(json);
					switch(data.code){
						case 400:
							<?= sendNotification("<strong>Invalid Captcha!</strong><br />It seems that the captcha you\'ve entered is invalid. Please try again!","danger"); ?>
							break;
						case 403:
							switch(data.message){
								case "Username Taken":
									<?= sendNotification("<strong>Username Taken!</strong><br />It seems that the username you wanted to claim has already been taken!","danger"); ?>
									break;
								case "Email Taken":
									<?= sendNotification("<strong>Email Taken!</strong><br />It seems that the email you wanted to use has already been taken!","danger"); ?>
									break;
							}
							break;
						case 200:
							<?= sendNotification("<strong>Success!</strong><br />You\'ve successfully registered!","success"); ?>
							window.location.replace("https://mymtg.finlaydag33k.nl/?page=login");
							break;
						default:
							<?= sendNotification("<strong>Well ehm...</strong><br />It seems that something went wrong. Please try again!","danger"); ?>
							break;
					}
				}
			});
			grecaptcha.reset(); // Reload the google captcha to prevent a bug: https://github.com/FinlayDaG33k/MyMTG-Web/issues/1
		});
	});
</script>

<div id="waiting" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Goblins Dispatched!</h4>
      </div>
      <div class="modal-body">
        <center>
					<p>
						We have dispatched a few Goblins to send the data,<br />
						Please hang on tight!<br />
					</p>
					<p>
						<div class="loader"></div>
					</p>
				</center>
      </div>
    </div>
  </div>
</div>

<form id="passwordForm" class="form-horizontal">
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="Username" placeholder="Username" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="text">
    </div>
  </div>
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="Email" placeholder="Email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="text">
    </div>
  </div>
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="Password" placeholder="Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password">
    </div>
  </div>
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="confPassword" placeholder="Confirm Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password">
			<br />
			<div id="RecaptchaField1"></div>
		</div>
  </div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input type="hidden" name="action" value="Register">
			<button type="reset" class="btn btn-default">Cancel</button>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
</form>
