<script src="<?= base_url() ?>assets/js/editablejss/jquery.tabledit.js"></script>
<div class="row" id="addemployeeleave">
	<div class="col-sm-12">
		<!-- start: TEXT FIELDS PANEL -->
		<div class="panel-body">
			<form id="addemployeeleave_form" method="post"
				class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-1"> Branch </label>
					<div class="col-sm-9">

						<select class="form-control search-select"
							placeholder="Select Employee" name="branch_start_manualleave"
							id="branch_start_manualleave" onChange="selectuserleave();">
							<option selected="selected" value="">-SELECT BRANCH-</option>
							<?php
    if (! empty($allbranches)) {
        ?>
                        <option
								value="<?= $allbranches[0]['readerserial'].'$'.$allbranches[0]['names'].'$'.$allbranches[0]['userpin'] ?>"><?= $allbranches[0]['branchname'] ?></option>
                        <?php
        array_shift($allbranches);
    }
    foreach ($allbranches as $value) {
        ?>
                        <option
								value="<?= $value['readerserial'].'$'.$value['names'].'$'.$value['userpin'] ?>"><?= $value['branchname'] ?></option>
                        <?php
    }
    ?>
                        </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-1"> Employee
					</label>
					<div class="col-sm-9">
						<select id="from_employee_leave" name="from_employee_leave"
							class="form-control search-select" required
							onChange="notmyleaves();">
							<option value="">-SELECT EMPLOYEE-</option>
							<!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"> Leave Period </label>
					<div class="col-sm-6">
						<div id="leaveperiod" class="pull-right"
							style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
							<span></span> <b class="caret"></b>
						</div>
					</div>
				</div>
				<div class="form-group hidden">
					<input type="text" id="startdate" name="startdate"> <input
						type="text" id="enddate" name="enddate">
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-1"> Leave
						Code </label>
					<div class="col-sm-4">
						<select class="form-control search-select"
							placeholder="Leave Code" name="leavecode" id="leavecode">
							<option value="">-SELECT LEAVE-</option>
                            <?php
                            foreach ($leavesall as $valueleave) {
                                ?>
                                <option
								value="<?= $valueleave['type'] ?>"><?= $valueleave['description'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
					</div>
					<div class="col-sm-5">
						<button class="btn btn-orange btn-block" type="submit">
							Load Employee Leave | or Add &nbsp;<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
				<br>
				<div class="form-group" id="tableleavediv">
					<!--<div id="eachTable">-->
					<table id="tableleave" class='table table-striped table-hover'>
					</table>
					<!--</div>-->
				</div>
			</form>
			<div id="leavedelbutton_id">
				<button class="btn btn-green btn-block" type="submit">
					Delete All The Above Leave&nbsp;<i class="fa fa-minus"></i>
				</button>
			</div>
		</div>
		<!-- end: TEXT FIELDS PANEL -->
	</div>
</div>
<script>
function selectuserleave() {
    var e = document.getElementById("branch_start_manualleave");
    $('#from_employee_leave').find('option:not(:first)').remove();
    //To Extraxt
  
    var milearrays_on = new Array();
    var milearrays_on1 = new Array();
    var milearrays_on2 = new Array();
    var fields = new Array();
    var mile_stones = new Array();
    var strUser = "";
    strUser = e.options[e.selectedIndex].value;
    //alert(strUser);
    fields = strUser.split('$');
    mile_stones = fields[1];
//  mile_stones1=fields[2];
    mile_stones2=fields[2];
    milearrays_on = mile_stones.split('@');
    milearrays_on2=mile_stones2.split('@');
   
    var $dropdown = $("#from_employee_leave");
    for (var i = 0; i < milearrays_on.length; i++) {
        $dropdown.append($("<option />").val(milearrays_on[i]+'|'+milearrays_on2[i]).text(milearrays_on[i]+' ~pin~ '+milearrays_on2[i]));
    }
}
    var loadleavedata = "<?php echo base_url("posts/loadleavedata"); ?>";
    var deleteall = "<?php echo base_url("posts/deleteallleaveinhere"); ?>";
    function notmyleaves(){
//     	tableleave
// $("#tableleavediv").hide();
    	$("#leavedelbutton_id").hide();
        }
    $("#leavedelbutton_id").hide();
    $(function () {
//     	notmyleaves()
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#leaveperiod span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startdate = start.format('YYYY-MM-DD');
            var endate = end.format('YYYY-MM-DD');
            //            $('#startdate').val = startdate;
            $("#startdate").val(startdate);
            $("#enddate").val(endate);
            //            alert(startdate + ' ' + end);
        }
        $('#leaveperiod').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        //        alert(start+' '+end);
    });
    $('#addemployeeleave_form')
            .formValidation({
                framework: 'bootstrap',
                icon: {
//                     valid: 'glyphicon glyphicon-ok',
//                     invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                	branch_start_manualleave: {
                        validators: {
                            notEmpty: {
                                message: 'Branch is required'
                            }
                        }
                    },
                    from_employee_leave: {
                        validators: {
                            notEmpty: {
                                message: 'From Employee is required'
                            }
                        }
                    },
                    leavecode: {
                        validators: {
                            notEmpty: {
                                message: 'Leave Code is required'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
        e.preventDefault();
        $.ajax({
            url: loadleavedata,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
        }).done(function (response) {
//             console.log(response);
         $("#tableleavediv").show();
            if (response.status === 1) {
                $.notify(response.report, "error");
                console.log(response.report);
            } else if (response.status === 0) {
                $.notify(response.report, "success");
            } else if (response.status === 2) {
                createTableByJqueryEach(response.data);
                $('#tableleave').DataTable();
                //                alert(JSON.stringify(response.data));
                //               alert(JSON.stringify(response));
            }
            return;
            //            alert(JSON.stringify(response));
        });
    })
    function createTableByJqueryEach(data)
    {
        $("#leavedelbutton_id").show();
        var eTable = "<thead><tr><th>Employee id</th><th>Leave Date</th><th>Leave Code</th><th>Added By</th></tr></thead><tbody>";
        $.each(data, function (index, row) {
            eTable += "<tr>";
            $.each(row, function (key, value) {
                eTable += "<td>" + value + "</td>";
            });
            eTable += "</tr>";
        });
        eTable += "</tbody>";
        $('#tableleave').html(eTable);
        //Removed By Njovu
        $('#tableleave').DataTable();
        $('#tableleave').Tabledit({
            url: '<?= base_url('posts/loadleavedataper') ?>',
            hideIdentifier: true,
            editButton: false,
            restoreButton: false,
            deleteButton: true,
            editmethod: 'post',
            deletemethod: 'post',
            rowIdentifier: 'id',
            columns: {
                identifier: [0, 'id'],
                editable: false
            },
            onSuccess: function (data, textStatus, jqXHR) {
//                alert(JSON.stringify(data));
                if (data.status === 2) {
                    $.notify(data.report, "success");
//                    empleave_list();
                } else {
                    $.notify(data.report, "error");
                }
                return;
            }
        });
        //          $('#tableleave').DataTable();
    }
    document.getElementById('leavedelbutton_id').onclick = function ()
    {
        var from_employee_leave = document.getElementById("from_employee_leave");
        var from_employee_leave_value = from_employee_leave.options[from_employee_leave.selectedIndex].value;
        //One
        var startdate = document.getElementById("startdate").value;
        var endate = document.getElementById("enddate").value;
        var leavecode = document.getElementById("leavecode");
        var leavecode_value = leavecode.options[leavecode.selectedIndex].value;
        $.ajax({
            url: deleteall, //This is the current doc
            type: "POST",
            dataType: 'json', // add json datatype to get json
            data: ({employee: from_employee_leave_value, startdate: startdate, enddate: endate, leavecode: leavecode_value}),
            success: function (data) {
                if (data.status === 1) {
                    $.notify(data.report, "error");
                    $("#leavedelbutton_id").hide();
                } else if (data.status === 2) {
                    $.notify(data.report, "success");
//                     console.log(data.report);
                    empleave_list();
                }
            }
        });
    };
    function empleave_list() {
        sessionStorage.setItem("empleave", "true");
//        document.location.reload();
        window.setTimeout(function () {
            window.location.reload();
        }, 2000);
    }
    ;
    window.onload = function () {
        var reloadingwala = sessionStorage.getItem("empleave");
        if (reloadingwala) {
            sessionStorage.removeItem("empleave");
            empleave();
        }
    };
    function empleave() {
        var l = document.getElementById('listempleaveinput');
        l.click();
    }
    ;
</script>