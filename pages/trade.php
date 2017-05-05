<script>
	$(document).ready(function() {
		$("#addTrade").submit(function(event) {
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
							$('#table-inventory > tbody:last-child').append('<tr><td><a href="http://gatherer.wizards.com/Pages/Card/Details.aspx?name='+$('input[id="addCard-Name"]').val()+'" target="_blank">'+$('input[id="addCard-Name"]').val()+'</a></td><td><span class="badge"><img src="http://www.bazaarofmagic.nl/images/editions/'+$('select[id="select"]').val()+'_c.png">'+$('select[id="select"]').val()+'</span></td><td></td><td></td><td></td><td></td></tr>');
							$('input[id="addCard-NonFoils"]').val("0");
							$('input[id="addCard-Foils"]').val("0");
							$('input[id="addCard-Name"]').val("");
							break;
					}
				}
			});
		});
		$("form[id=updateTrade]").submit(function(event) {
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
      'action' => 'listTrades'
    );
    $url = "https://mymtg-api.finlaydag33k.nl/index.php?" . http_build_query($query);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $trades = json_decode(curl_exec($ch),1);
    curl_close($ch);
    ?>
    <table class="table table-hover" id="table-trade">
      <thead>
        <th class="col-md-1">Trade ID</th>
        <th class="col-md-2">Gives</th>
        <th class="col-md-2">Gets</th>
				<th class="col-md-1">Date Created</th>
				<th class="col-md-1">Last Updated</th>
				<th class="col-md-2">Status</th>
        <th>Actions</th>
      </thead>
      <tbody>
        <tr>
          <form id="addTrade" class="form-horizontal">
            <td></td>
            <td>
              <div class="form-group">
                <textarea class="form-control" id="Gives" name="Gives"></textarea>
                <span class="help-block">One card per row. format example: 1x Black Lotus</span>
              </div>
            </td>
            <td>
              <div class="form-group">
                <textarea class="form-control" id="Gets" name="Gets"></textarea>
                <span class="help-block">One card per row. format example: 1x Black Lotus</span>
              </div>
            </td>
						<td></td>
						<td></td>
						<td>
              <div class="form-group">
                <select class="form-control" id="Status" name="Status">
									<option value="Awaiting">Awaiting Response</option>
									<option value="Ready">Ready for shipment</option>
									<option value="Shipped">Shipped</option>
									<option value="RLT">Real-Life Trade</option>
									<option value="Complete">Complete</option>
									<option value="Canceled">Canceled</option>
								</select>
              </div>
            </td>
            <td>
              <input type="hidden" name="action" value="addTrade">
              <input class="btn btn-primary" type="submit" value="Add">
              <input class="btn btn-default" type="reset" value="Clear">
            </td>
          </form>
        </tr>
        <?php
					foreach($trades['Trades'] as $trade => $value){
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
								<form id="updateTrade" class="form-horizontal">
									<td>
										<div class="form-group">
			                <select class="form-control" id="Status" name="Status">
												<option value="Awaiting" <?php if($value['Status'] == "Awaiting"){?>Selected<?php } ?>>Awaiting Response</option>
												<option value="Ready" <?php if($value['Status'] == "Ready"){?>Selected<?php } ?>>Ready for shipment</option>
												<option value="Shipped" <?php if($value['Status'] == "Shipped"){?>Selected<?php } ?>>Shipped</option>
												<option value="RLT" <?php if($value['Status'] == "RLT"){?>Selected<?php } ?>>Real-Life Trade</option>
												<option value="Complete" <?php if($value['Status'] == "Completed"){?>Selected<?php } ?>>Complete</option>
												<option value="Canceled" <?php if($value['Status'] == "Canceled"){?>Selected<?php } ?>>Canceled</option>
											</select>
			              </div>
									</td>
									<td>
										<input type="hidden" name="action" value="updateTrade">
										<input type="hidden" name="TradeID" value="<?= htmlentities($value['ID']); ?>">
			              <input class="btn btn-primary" type="submit" value="Update">
			              <input class="btn btn-default" type="reset" value="Clear">
									</td>
								</form>
							</tr>
						<?php
					}
        ?>
      </tbody>
    <?php
  }
?>
