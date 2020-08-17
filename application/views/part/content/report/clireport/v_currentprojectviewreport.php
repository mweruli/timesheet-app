<div class="panel-body" id="employeetimeone">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="col-sm-6">
					<select id="client_id_time" class="form-control search-select"
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
					<select id="taskidcost" class="form-control search-select"
						onChange="loadtableclienttaskcost();" name="taskidcost"
						placeholder="Select Task">
						<option value="">--Select Task--</option>
						<?php
						foreach ( $task as $value_task ) {
							?>
                            <option value="<?= $value_task['id']; ?>"><?= $value_task['name'] ?></option>
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
							<li><a href="#" id="exportpdf"
								onclick="printJS({printable: 'costclienttaskcomb', type: 'html', header: 'Time Per Task', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
									Save as PDF </a></li>
							<li><a href="#" onclick="export_damclinet()"> Export to Excel </a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div id="costclienttaskcomb"></div>
</div>
<script type="text/javascript">
var getmetaskclientreportone = "<?php echo base_url('ts/getreportbyclienttask'); ?>";
function loadtableclienttaskcost(){
	var projectidn = document.getElementById("taskidcost");
    var projectidvaluen = projectidn.options[projectidn.selectedIndex].value;
    var projectidtextn = projectidn.options[projectidn.selectedIndex].text;
    var clientidn = document.getElementById("client_id_time");
    var clientidvaluen = clientidn.options[clientidn.selectedIndex].value;
    var clientidtextn = clientidn.options[clientidn.selectedIndex].text;
    $.ajax({
        method: "POST",
        url: getmetaskclientreportone,
        dataType: "JSON",
        data: {'gettaskname': projectidtextn, 'gettaskid': projectidvaluen, 'getclientid': clientidvaluen}
    }).done(function (response) {
//     	alert(JSON.stringify(response));
//        alert(response);
        if (response.status === 1) {
            $.notify(response.report, "success");
            $("#costclienttaskcomb").html(response.data);
        } else {
            $.notify(response.report, "error");
            $("#costclienttaskcomb").html('');
        }
    });
}
function loadtableclienttaskcostxx() {
    var projectidn = document.getElementById("taskidcost");
    var projectidvaluen = projectidn.options[projectidn.selectedIndex].value;
    var projectidtextn = projectidn.options[projectidn.selectedIndex].text;
    //
    var clientidn = document.getElementById("client_id_time");
    var clientidvaluen = clientidn.options[clientidn.selectedIndex].value;
    var clientidtextn = clientidn.options[clientidn.selectedIndex].text;
    //
    $.ajax({
        method: "POST",
        url: getmeclientprojects,
        dataType: "JSON",
        data: {'client_id': clientidvaluen, 'task_id': projectidvaluen, 'client_name': projectidtextn}
    }).done(function (response) {
//         console.log(projectidvalue+' '+clientidvalue);
        if (response.status === 1) {
//             $.notify(response.report, "success");
            $("#costclienttaskcomb").html(response.data);
        } else {
//             $.notify(response.report, "error");
            $("#costclienttaskcomb").html('');
        }
    });
}
</script>