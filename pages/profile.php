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

		$result = json_decode($result,1);
		$inventory = $result['Inventory'];

		$wants = $result['Wants'];
		?>
			<h2>Profile of <?= htmlentities($_GET['username']); ?>
			<hr>
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Inventory</h3>
					  </div>
					  <div class="panel-body">
							<table class="table table-hover" id="table-inventory">
								<thead>
									<th>Card Name</th>
									<th class="col-md-2">Set</th>
									<th class="col-md-2">Foils</th>
									<th class="col-md-2">Non-Foils</th>
								</thead>
								<tbody>
									<?php
									if(!empty($inventory)){
										foreach($inventory as $card => $value){
											?>
													<tr>
														<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
														<td><span class="badge"><?php if($value['Set'] != "MPS"){ ?><img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png"><?php }else{ ?><img src="http://www.bazaarofmagic.nl/images/editions/mps_kld.png"><?php } ?> <?= htmlentities($value['Set']); ?></span></td>
														<td><?= htmlentities($value['Foils']); ?></td>
														<td><?= htmlentities($value['Non-Foils']); ?></td>
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
					  </div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Wants</h3>
					  </div>
					  <div class="panel-body">
							<table class="table table-hover" id="table-inventory">
								<thead>
									<th>Card Name</th>
									<th class="col-md-2">Set</th>
									<th class="col-md-2">Foils</th>
									<th class="col-md-2">Non-Foils</th>
								</thead>
								<tbody>
									<?php
									if(!empty($wants)){
										foreach($wants as $card => $value){
											?>
													<tr>
														<td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name=<?= htmlentities($value['Name']); ?>" target="_blank"><?= htmlentities($value['Name']); ?></a></td>
														<td><span class="badge"><?php if($value['Set'] != "MPS"){ ?><img src="http://www.bazaarofmagic.nl/images/editions/<?= htmlentities($value['Set']); ?>_c.png"><?php }else{ ?><img src="http://www.bazaarofmagic.nl/images/editions/mps_kld.png"><?php } ?> <?= htmlentities($value['Set']); ?></span></td>
														<td><?= htmlentities($value['Foils']); ?></td>
														<td><?= htmlentities($value['Non-Foils']); ?></td>
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
					  </div>
					</div>
				</div>
			</div>
