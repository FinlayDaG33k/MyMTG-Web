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
	?>

<script>
	$(document).ready(function()  {
    $("#table-haves").tablesorter();
		$("#table-wants").tablesorter();
  });
</script>
		<h2>Profile of <?= htmlentities($_GET['username']); ?>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">Inventory</h3>
				  </div>
				  <div class="panel-body">
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
										?>
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
									Nothing here...
									<?php
								}
								?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Wants</h3>
					  </div>
					  <div class="panel-body">
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
				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">User Details</h3>
						  </div>
						  <div class="panel-body">
								<?php
									if(!empty($userdetails)){
										?>
										<table class="table table-hover" id="table-userdetails">
											<tbody>
										<?php
										foreach($userdetails as $detail=> $value){
											?>
												<td><?= htmlentities(key($value)); ?></td>
												<td><?= htmlentities($value['DCI']); ?></td>
											<?php
										}
										?>
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
