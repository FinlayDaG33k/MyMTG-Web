<script>
	$(document).ready(function() {
		$("#logOut").click(function(e) {
			$.removeCookie("Userdata");
			window.location.replace("https://<?= $_SERVER['HTTP_HOST']; ?>/");
		});
	});
</script>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">MyMTG</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
				<li><a href="?page=roadmap">Roadmap</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
				<li><a href="http://bit.ly/2nQX1OE" target="_blank">Feedback</a></li>
				<?php if(!empty($cookieData)){ ?>
					<li class="dropdown">
				    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
				    <ul class="dropdown-menu" role="menu">
							<li><a href="#">Welcome <?= htmlentities($cookieData['Username']); ?></a></li>
							<li><a href="?page=profile&username=<?= htmlentities($cookieData['Username']); ?>">My Profile</a></li>
							<li><a href="?page=edit-profile">Edit Profile</a></li>
							<li class="divider"></li>
				      <li><a href="?page=inventory">My Inventory</a></li>
							<li><a href="?page=wants">My Wants</a></li>
				      <li class="divider"></li>
							<li><a href="?page=change-password">Change Password</a></li>
							<li class="divider"></li>
							<li><a href="#" id="logOut">Log Out</a></li>
				    </ul>
				  </li>
				<?php	}else{ ?>
					<li><a href="?page=login">Login</a></li>
					<li><a href="?page=register">Register</a></li>
				<?php } ?>
      </ul>
    </div>
  </div>
</nav>
