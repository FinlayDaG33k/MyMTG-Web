<script>
	$(document).ready(function() {
		$(".js-example-basic-single").select2({
			placeholder: "Set",
			allowClear: true
		});

		$("#addCard").submit(function(event) {
			event.preventDefault();
			$("#waiting").modal({
			  backdrop: 'static',
			  keyboard: false
			});
			let Userdata = $.parseJSON($.cookie('Userdata'));
			Userdata = Userdata.message;
			let data = $(this).serialize() +'&'+$.param({'Authtoken':Userdata.Authtoken})+'&'+$.param({'Username':Userdata.Username});
			console.log(data);
			$.ajax({
				type: "POST",
				url: "https://mymtg-api.finlaydag33k.nl/index.php",
				data: data,
				success: function(json){
					$('#waiting').modal('hide');
					let data = $.parseJSON(json);
					switch(data.code){
						case 404:
							<?= sendNotification("<strong>Invalid Captcha!</strong><br />Unfortunately, our goblins had no clue what card you wanted to add. Please try again!","danger"); ?>
							break;
						case 500:
							<?= sendNotification("<strong>Well ehm...</strong><br />Unfortunately, our goblins lost their way. Please try again!","danger"); ?>
							break;
						case 200:
							<?= sendNotification("<strong>Hooraay!</strong><br />Our goblins returned with the news that everything went right! Some actions require you to refresh the page to see changes.","success"); ?>
							break;
					}
				}
			});
		});
		$("form[id=updateCard]").submit(function(event) {
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
						case 500:
							<?= sendNotification("<strong>Well ehm...</strong><br />Unfortunately, our goblins lost their way. Please try again!","danger"); ?>
							break;
						case 200:
							<?= sendNotification("<strong>Hooraay!</strong><br />Our goblins returned with the news that everything went right! Some actions require you to refresh the page to see changes.","success"); ?>
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

<?php
	if(!empty($cookieData)){
		$query = array(
 			'username' => $cookieData['Username'],
 			'authtoken' => $cookieData['Authtoken'],
			'action' => 'listWants'
		);
		$url = "https://mymtg-api.finlaydag33k.nl/index.php?" . http_build_query($query);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$Wants = json_decode($result,1);
		$Wants = $Wants['Wants'];
		?>
			<table class="table table-hover" id="table-Wants">
				<thead>
					<th>Card Name</th>
					<th class="col-md-2">Set</th>
					<th class="col-md-2">Foils</th>
					<th class="col-md-2">Non-Foils</th>
					<th>Actions</th>
				</thead>
				<tbody>
					<form id="addCard" class="form-horizontal">
						<tr>
							<td>
								<div class="form-group">
								  <input class="form-control" id="focusedInput" name="Card" placeholder="Card Name" type="text">
								</div>
							</td>
							<td>
								<div class="form-group">

									<select class="form-control js-example-basic-single js-states" name="Set" id="select">
					          <?php
											$url = "https://mymtg-api.finlaydag33k.nl/index.php?action=listSets";
											$ch = curl_init();
											curl_setopt($ch, CURLOPT_URL, $url);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
											$result = json_decode(curl_exec($ch),1);
											curl_close($ch);

											foreach($result as $set => $value){
												?>
													<option value="<?= htmlentities($value['code']); ?>"><?= htmlentities($value['Name']); ?> (<?= htmlentities($value['code']); ?>)</option>
												<?php
											}
										?>
					        </select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<input class="form-control" name="Foils" type="text" value="0">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input class="form-control" type="text" value="0" name="Non-Foils">
								</div>
							</td>
							<td>
								<input type="hidden" name="action" value="addWant">
								<input class="btn btn-primary" type="submit" value="Add">
								<input class="btn btn-default" type="reset" value="Clear">
							</td>
						</tr>
					</form>
					<?php
					if(!empty($Wants)){
						foreach($Wants as $card => $value){
							?>
								<form id="updateCard" class="form-horizontal">
									<tr>
										<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
										<td><span class="badge"><?php if($value['Set'] != "MPS"){ ?><img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png"><?php }else{ ?><img src="http://www.bazaarofmagic.nl/images/editions/mps_kld.png"><?php } ?> <?= htmlentities($value['Set']); ?></span></td>
										<td><input class="form-control" type="text" value="<?= htmlentities($value['Foils']); ?>" name="Foils"></td>
										<td><input class="form-control" type="text" value="<?= htmlentities($value['Non-Foils']); ?>" name="Non-Foils"></td>
										<td>
											<input type="hidden" name="action" value="updateWant">
											<input type="hidden" name="cardID" value="<?= htmlentities($card); ?>">
											<input class="btn btn-primary" type="submit" value="Save">
											<input class="btn btn-default" type="reset" value="Reset">
										</td>
									</tr>
								</form>
							<?php
						}
					}else{
						?>
							<tr>
								<td>No Results</td>
							</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		<?php
	}else{
		?>
			Please login to continue!
		<?php
	}
?>
