<script>
	$(document).ready(function() {
		$("#passwordForm").submit(function(event) {
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
							case 400:
								$("#invalidcaptcha").show();
								break;
							case 403:
								$("#invalidpassword").show();
								break;
							case 200:
								$("#success").show();
								break;
						}
					}
				});
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
      <input class="form-control" name="oldPassword" placeholder="Old Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password">
    </div>
  </div>
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="newPassword" placeholder="New Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password">
    </div>
  </div>
	<div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="confnewPassword" placeholder="Confirm New Password" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" type="password">
			<br />
			<div class="g-recaptcha" data-sitekey="6Le_3RkUAAAAADBQXnsaMdR7-HNGpuIzXSNPJMaY"></div>
		</div>
  </div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input type="hidden" name="action" value="changePassword">
			<button type="reset" class="btn btn-default">Cancel</button>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
</form>

<div id="invalidcaptcha" style="display:none" class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Invalid Captcha!</strong><br />
	It seems that the captcha you've entered is invalid. Please try again!
</div>

<div id="invalidpassword" style="display:none" class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Invalid password!</strong><br />
	It seems that you've entered incorrect the old password. Please try again!
</div>

<div id="success" style="display:none" class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Success!</strong><br />
	We've Successfully changed your password!
</div>
