<?php
	$query = array(
		'action' => 'listProfile',
		'username' => $_GET['username']
	);
	$url = "https://mymtg-api.finlaydag33k.nl/index.php?" . http_build_query($query);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	if($result !== "Invalid User"){
	$result = json_decode($result,1);
	$inventory = $result['Inventory'];
	$wants = $result['Wants'];
	$userdetails = $result['UserDetails'];
	$trades = $result['Trades'];
?>

<script>
	$(document).ready(function(){
    $("#table-haves").tablesorter();
		$("#table-wants").tablesorter();

		$('#Inventory-body').on('shown.bs.collapse', function() {
			$("#Inventory").find('i').toggleClass("down");
  	});

		$('#Inventory-body').on('hidden.bs.collapse', function() {
			$("#Inventory").find('i').toggleClass("down");
  	});

		$('#Wants-body').on('hidden.bs.collapse', function() {
			$("#Wants").find('i').toggleClass("down");
  	});

		$('#Wants-body').on('hidden.bs.collapse', function() {
			$("#Wants").find('i').toggleClass("down");
  	});

		$('#Userdetails-body').on('hidden.bs.collapse', function() {
			$("#Userdetails").find('i').toggleClass("down");
		});

		$('#Userdetails-body').on('hidden.bs.collapse', function() {
			$("#Userdetails").find('i').toggleClass("down");
		});


		$('#Trades-body').on('hidden.bs.collapse', function() {
			$("#Trades").find('i').toggleClass("down");
		});
		$('#Trades-body').on('hidden.bs.collapse', function() {
			$("#Trades").find('i').toggleClass("down");
		});
  });
</script>
		<h2>Profile of <?= htmlentities($_GET['username']); ?>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary" id="Inventory">
					<div class="panel-heading">
		        <div class="panel-title pull-left">
		          Inventory
		        </div>
		        <div class="panel-title pull-right" data-toggle="collapse" data-target="#Inventory-body">
							<i class="fa fa-chevron-right rotate" aria-hidden="true"></i>
						</div>
		        <div class="clearfix"></div>
	    		</div>
				  <div class="panel-body collapse" id="Inventory-body">
								<?php
								if(!empty($inventory)){
									?>
									<table class="table table-hover" id="table-haves">
										<thead>
											<th>Card Name</th>
											<th class="col-md-2">Set</th>
											<th class="col-md-2">Foils</th>
											<th class="col-md-2">Non-Foils</th>
										</thead>
										<tbody>
											<?php
									foreach($inventory as $card => $value){
										if(($value['Foils'] + $value['Non-Foils']) > 0){
										?>
											<tr>
												<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
												<td>
												<span class="badge">
													<?php
														if($value['Rarity'] == "Special"){
															if(strpos($value['Set'], 'MPS:') !== FALSE){
																$set = explode (':',$value['Set']);
																?>
																	<img src="http://www.bazaarofmagic.nl/images/editions/MPS_<?= trim(htmlentities($set[1])); ?>_m.png">
																<?php
															}elseif($value['Set'] == "pWPN"){
																?>
																	<img src="http://www.bazaarofmagic.nl/images/editions/wpn_c.png">
																<?php
															}
														}elseif($value['Rarity'] == "Basic Land"){
															?>
																<img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png">
															<?php
														}else{
															?>
																<img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_<?= htmlentities($value['Rarity'][0]); ?>.png">
															<?php
														}
													?>
													<?= htmlentities($value['Set']); ?>
												</span>
												</td>
													<td><?= htmlentities($value['Foils']); ?></td>
													<td><?= htmlentities($value['Non-Foils']); ?></td>
												</tr>
											</form>
										<?php
										}
									}
									?>
								</tbody>
							</table>
									<?php
								}else{
									?>
									Nothing here...
									<?php
								}
								?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
					<div class="panel panel-primary" id="Haves">
						<div class="panel-heading">
			        <div class="panel-title pull-left">
			          Haves
			        </div>
			        <div class="panel-title pull-right" data-toggle="collapse" data-target="#Haves-body">
								<i class="fa fa-chevron-right rotate" aria-hidden="true"></i>
							</div>
			        <div class="clearfix"></div>
		    		</div>
					  <div class="panel-body collapse" id="Haves-body">
									<?php
									if(!empty($wants)){
										?>
										<table class="table table-hover" id="table-wants">
											<thead>
												<th>Card Name</th>
												<th class="col-md-2">Set</th>
												<th class="col-md-2">Foils</th>
												<th class="col-md-2">Non-Foils</th>
											</thead>
											<tbody>
										<?php
										foreach($wants as $card => $value){
											?>
													<tr>
														<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
														<td>
															<span class="badge">
																<?php
																	if($value['Rarity'] == "Special"){
																		if(strpos($value['Set'], 'MPS:') !== FALSE){
																			$set = explode (':',$value['Set']);
																			?>
																				<img src="http://www.bazaarofmagic.nl/images/editions/MPS_<?= trim(htmlentities($set[1])); ?>_m.png">
																			<?php
																		}elseif($value['Set'] == "pWPN"){
																			?>
																				<img src="http://www.bazaarofmagic.nl/images/editions/wpn_c.png">
																			<?php
																		}
																	}elseif($value['Rarity'] == "Basic Land"){
																		?>
																			<img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png">
																		<?php
																	}else{
																		?>
																			<img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_<?= htmlentities($value['Rarity'][0]); ?>.png">
																		<?php
																	}
																?>
																<?= htmlentities($value['Set']); ?>
															</span>
														</td>
														<td><?= htmlentities($value['Foils']); ?></td>
														<td><?= htmlentities($value['Non-Foils']); ?></td>
													</tr>
												</form>
											<?php
										}
										?>
									</tbody>
								</table>
										<?php
									}else{
										?>
										Nothing Here...
										<?php
									}
									?>
					  </div>
					</div>
				</div>
					<div class="col-md-4">
						<div class="panel panel-primary" id="Userdetails">
							<div class="panel-heading">
				        <div class="panel-title pull-left">
				          User Details
				        </div>
				        <div class="panel-title pull-right" data-toggle="collapse" data-target="#Userdetails-body">
									<i class="fa fa-chevron-right rotate" aria-hidden="true"></i>
								</div>
				        <div class="clearfix"></div>
			    		</div>
						  <div class="panel-body collapse" id="Userdetails-body">
								<?php
									if(!empty($userdetails)){
										?>
										<table class="table table-hover" id="table-userdetails">
											<tbody>
												<?php if(!empty($userdetails['Name'])){ ?>
													<tr>
														<td>Name</td>
														<td><?= htmlentities($userdetails['Name']); ?></td>
													</tr>
												<?php } ?>
												<?php if(!empty($userdetails['DCI']) && $userdetails['DCI'] !=="0"){ ?>
													<tr>
														<td>DCI</td>
														<td><?= htmlentities($userdetails['DCI']); ?></td>
													</tr>
												<?php } ?>
											</tbody>
									</table>
										<?php
									}else{
										?>
										Nothing Here...
										<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary" id="Trades">
							<div class="panel-heading">
								<div class="panel-title pull-left">
									Trades
								</div>
								<div class="panel-title pull-right" data-toggle="collapse" data-target="#Trades-body">
									<i class="fa fa-chevron-right rotate" aria-hidden="true"></i>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body collapse" id="Trades-body">
								<?php
									if(!empty($trades)){
										?>
										<table class="table table-hover" id="table-trade">
											<thead>
												<th>Trade ID</th>
												<th>Gives</th>
												<th>Gets</th>
												<th>Date Created</th>
												<th>last Updated</th>
												<th>Status</th>
											</thead>
											<tbody>
												<?php
													foreach($trades as $trade => $value){
														?>
														<tr>
															<td><?= htmlentities($value['ID']); ?></td>
															<td>
																<?php
																	foreach($value['Cards']['Gives'] as $card => $amount){
																		echo $amount . "x " . $card . "<br />";
																	}
																?>
															</td>
															<td>
																<?php
																	foreach($value['Cards']['Gets'] as $card => $amount){
																		echo $amount . "x " . $card . "<br />";
																	}
																?>
															</td>
															<td>
																<?= htmlentities($value['Date_Created']); ?>
															</td>
															<td>
																<?= htmlentities($value['Last_Updated']); ?>
															</td>
															<td>
																<?php
																	switch($value['Status']){
																		case "Awaiting":
																			?>
																				Awaiting Response
																			<?php
																			break;
																		case "Ready":
																			?>
																				Ready for shipment
																			<?php
																			break;
																		case "Shipped":
																			?>
																				Shipped
																			<?php
																			break;
																		case "Real-Life Trade":
																			?>
																				Real-Life Trade
																			<?php
																			break;
																		case "Complete":
																			?>
																				Complete
																			<?php
																			break;
																		case "Canceled":
																			?>
																				Canceled
																			<?php
																			break;
																	}
																?>
															</td>
														</tr>
														<?php
													}
												?>
											</tbody>
									</table>
										<?php
									}else{
										?>
										Nothing Here...
										<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
		</div>
			<?php
				}else{
					?>
					<div class="alert alert-danger">
					  <strong>Goblin not found!</strong><br />
						We could not find that user, please try again!
					</div>
					<?php
				}
			?>
