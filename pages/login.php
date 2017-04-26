<script>
	$(document).ready(function() {
		$("#loginForm").submit(function(event) {
		    event.preventDefault();
				$.ajax({
				  type: "POST",
				  url: "https://mymtg-api.finlaydag33k.nl/index.php",
				  data: $(this).serialize(),
				  success: function(json){
						let data = $.parseJSON(json);
						switch(data.code){
							case 400:
								<?= sendNotification("<strong>Invalid Captcha!</strong><br />It seems that the captcha you\'ve entered is invalid. Please try again!","danger"); ?>
								grecaptcha.reset(); // Reload the google captcha to prevent a bug: https://github.com/FinlayDaG33k/MyMTG-Web/issues/1
								break;
							case 403:
								<?= sendNotification("<strong>Invalid login credentials!</strong><br />It seems that you\'ve entered the wrong user credentials. Please try again!","danger"); ?>
								grecaptcha.reset(); // Reload the google captcha to prevent a bug: https://github.com/FinlayDaG33k/MyMTG-Web/issues/1
								break;
							case 200:
								<?= sendNotification("<strong>Login Success!</strong><br />You\'ve been successfully logged in! You will be redirected to MyMTG in a few moments!","success"); ?>
								$.cookie("Userdata", json);
								window.location.replace("https://mymtg.finlaydag33k.nl/inventory");
								break;
						}
					}
				});
		});
	});
</script>

<form id="loginForm" class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Username/Email</label>
      <div class="col-lg-10">
        <input class="form-control" id="username" name="Username" placeholder="Username/Email" type="text">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input class="form-control" id="password" name="Password" placeholder="Password" type="password">
				<br />
				<div id="RecaptchaField1"></div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
				<input type="hidden" name="action" value="Authenticate">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
