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
			$.ajax({
				type: "POST",
				url: "https://mymtg-api.finlaydag33k.nl/index.php",
				data: data,
				success: function(json){
					$('#waiting').modal('hide');
					let data = $.parseJSON(json);
					switch(data.code){
						case 404:
							<?= sendNotification("<strong>Invalid Card!</strong><br />Unfortunately, our goblins had no clue what card you wanted to add. Please try again!","danger"); ?>
							break;
						case 500:
							<?= sendNotification("<strong>Well ehm...</strong><br />Unfortunately, our goblins lost their way. Please try again!","danger"); ?>
							break;
						case 200:
							<?= sendNotification("<strong>Hooraay!</strong><br />Our goblins returned with the news that everything went right! Some actions require you to refresh the page to see changes.","success"); ?>
							$('#table-inventory > tbody:last-child').append('<tr><td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name='+$('input[id="addCard-Name"]').val()+'" target="_blank">'+$('input[id="addCard-Name"]').val()+'</a></td><td><span class="badge"><img src="http://www.bazaarofmagic.nl/images/editions/'+$('select[id="select"]').val()+'_c.png">'+$('select[id="select"]').val()+'</span></td><td></td><td></td><td></td><td></td></tr>');
							$('input[id="addCard-NonFoils"]').val("0");
							$('input[id="addCard-Foils"]').val("0");
							$('input[id="addCard-Name"]').val("");
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

<?php
	if(!empty($cookieData)){
		$query = array(
 			'username' => $cookieData['Username'],
 			'authtoken' => $cookieData['Authtoken'],
			'action' => 'listInventory'
		);
		$url = "https://mymtg-api.finlaydag33k.nl/index.php?" . http_build_query($query);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$inventory = json_decode($result,1);
		$inventory = $inventory['Inventory'];
		?>
			<table class="table table-hover" id="table-inventory">
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
								  <input class="form-control" id="addCard-Name" name="Card" placeholder="Card Name" type="text">
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
									<input class="form-control" id="addCard-Foils" name="Foils" type="text" value="0">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input class="form-control" id="addCard-NonFoils" type="text" value="0" name="Non-Foils">
								</div>
							</td>
							<td>
								<input type="hidden" name="action" value="addHave">
								<input class="btn btn-primary" type="submit" value="Add">
								<input class="btn btn-default" type="reset" value="Clear">
							</td>
						</tr>
					</form>
					<?php
					if(!empty($inventory)){
						foreach($inventory as $card => $value){
							?>
								<form id="updateCard" class="form-horizontal">
									<tr>
										<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
										<td>
											<span class="badge">
												<?php
													if(strpos($value['Set'], 'MPS:') !== FALSE){
														$set = explode (':',$value['Set']);
														?>
															<img src="http://www.bazaarofmagic.nl/images/editions/mps_<?= trim(htmlentities($set[1])); ?>.png">
														<?php
													}else{
														if($value['Set'] == "WPN"){
															?>
																<img src="http://www.bazaarofmagic.nl/images/editions/wpn_c.png">
															<?php
														}else{
															?>
																<img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png">
															<?php
														}
													}
												?>
												<?= htmlentities($value['Set']); ?>
											</span>
										</td>
										<td><input class="form-control" type="text" value="<?= htmlentities($value['Foils']); ?>" name="Foils"></td>
										<td><input class="form-control" type="text" value="<?= htmlentities($value['Non-Foils']); ?>" name="Non-Foils"></td>
										<td>
											<input type="hidden" name="action" value="updateHave">
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
