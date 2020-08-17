<style>
.intro {
	background-color: yellow;
}
</style>
<div class="panel-body" id="client_three_n">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-sm-6">
					<select id="client_id_n" class="form-control search-select"
						placeholder="Select Client">
						<option value="">--Select Client--</option>
                        <?php
																								foreach ( $all_clients as $value ) {
																									?>
                            <option value="<?= $value['id']; ?>"><?= $value['clientname'] . "  " . $value['client_number'] ?></option>
                            <?php
																								}
																								?>
                    </select>
				</div>
				<div class="col-sm-5">
					<select id="projectid_n" class="form-control search-select"
						onChange="loadtablecostproject_n();" name="projectid_n"
						placeholder="Select Project">
						<option value="0">--Select Employee-</option>
						<?php
						foreach ( $all_users as $valueusers ) {
							?>
                            <option
							value="<?= $valueusers['user_id']; ?>"><?= $valueusers['firstname'] . "  " . $valueusers['lastname']." ". $valueusers['emailaddress'] ?></option>
                            <?php
						}
						?>
					</select>
				</div>
				<div class="col-sm-1">
					<div class="btn-group pull-right">
						<button data-toggle="dropdown"
							class="btn btn-green dropdown-toggle">
							Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu dropdown-light pull-right">
							<li><a href="#" id="exportpdf_n"
								onclick="printJS({printable: 'timecostbyclientstaff', type: 'html', header: 'Clients Costing Details', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
									Save as PDF </a></li>
							<li><a href="#" onclick="export_damclinet_n()"> Export to Excel </a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div id="contentdetailscost_n"></div>
</div>
<script type="text/javascript">
var getmereport_n = "<?php echo base_url('ts/getreportperstaff'); ?>";
function loadtablecostproject_n() {
    var projectid = document.getElementById("projectid_n");
    var projectidvalue = projectid.options[projectid.selectedIndex].value;
    var projectidtext = projectid.options[projectid.selectedIndex].text;
    //
    var clientid = document.getElementById("client_id_n");
    var clientidvalue = clientid.options[clientid.selectedIndex].value;
    var clientidtext = clientid.options[clientid.selectedIndex].text;
    //
    $.ajax({
        method: "POST",
        url: getmereport_n,
        dataType: "JSON",
        data: {'userid': projectidvalue, 'clientid': clientidvalue, 'client_name': clientidtext, 'usernames':projectidtext}
    }).done(function (response) {
//         console.log(JSON.stringify(response));
        if (response.status === 1) {
            $.notify(response.report, "success");
            $("#contentdetailscost_n").html(response.data);
        } else {
            $.notify(response.report, "error");
            $("#contentdetailscost_n").html('');
        }
    });
}
</script>