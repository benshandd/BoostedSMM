<div class="col-md-8">
            <?php if($panel["panel_type"] != "Child" ): ?>

<div class="settings-header__table">

            <div class="col-md-8">
	<div class="settings-header__table">
		<button type="button" class="btn btn-default m-b" data-toggle="modal" data-target="#modalDiv" data-action="new_provider">Add new Provider</button>
	</div>
	<hr>
      <?php endif; ?>

<table class="table providers_list" id="service-table">
    <thead>
    <tr>
<th>ID</th>
					<th class="p-l" width="45%">Provider</th>
					<th>Balance</th>
					<th></<th>

				</tr>
			</thead>
			<tbody>

				<?php foreach ($providersList as $provider) : ?>


					<tr      data-provider-id="<?php echo $provider["id"]; ?>" id="<?php echo $provider["api_name"]; ?>"   class="list_item ">
					<td><?php echo $provider["id"]; ?> </td>
						<td class="<?php if( $provider["status"] == 2 ): echo "grey "; endif; ?>" data-label="Service" class="table-service" data-filter-table-service-name="true" class="name p-l"><?php echo $provider["api_name"]; ?> </td>
						<td>

							<?php



							$api_id = $provider["id"];
							$api_url = $provider["api_url"];

							$api_key = $provider["api_key"];

 if( $provider["status"] == "1" ): 
							$veri = json_decode(kontrol($api_url, $api_key));

							echo $veri->balance . " " . $veri->currency;
 if(!empty($veri->error)) : 
$update = $conn->prepare("UPDATE service_api SET status=:status WHERE id=:id ");
          $update->execute(array("id"=>$api_id,"status"=> 2 ));

endif; 


else:

echo '<div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Balance info not available for that provider</span></div>'  ;
 
 endif; 

							?>


						</td>
						<td >

							<button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalDiv" data-action="edit_provider" data-id="<?= $provider["id"] ?>">Edit</button>

<?php if($panel["panel_type"] != "Child" ): ?>
<a class="btn btn-default btn-xs pull-right danger"  href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/providers/delete/".$provider["id"])?>">Delete</a>
<?php endif; ?>
						</td>


						<input type="hidden" name="privder_changes" value="privder_changes">
					<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
</div>




<?php

function kontrol($api_url, $api_key)
{

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


	$_post = 	array(
		'key' => $api_key,
		'action' => 'balance',
	);
	if (is_array($_post)) {
		foreach ($_post as $name => $value) {
			$_post[] = $name . '=' . urlencode($value);
		}
	}

	if (is_array($_post)) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
	}


	$result = curl_exec($ch);
	return $result;
	curl_close($ch);
}


?>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <h4>Are you sure you want to Delete?</h4>
            <div align="center">
               <a class="btn btn-primary" href="" id="confirmYes">Yes</a>
               <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
         </div>
      </div>
   </div>
</div>