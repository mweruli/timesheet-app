<?php
// print_array($all_employees);
?>
<script src="https://niksofteng.github.io/html-table-search-js"></script>
<div class="panel-body">
	<form class="form-horizontal" role="form" method="post"
		name="att_card_formx" id="att_card_formx">
		<div class="form-group">
			<label class="col-sm-1 control-label"> Branch </label>
			<div class="col-sm-5">
				<select id="branch_start" name="branch_start"
					class="form-control search-select" onChange="selectuserbranch();">
					<?php
    if (! empty($allbranches)) {
        ?>
                        <option selected="selected"
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
			<label class="col-sm-1 control-label"> Date Range </label>
			<div class="col-sm-5 date">
				<div class="input-group input-append date" id="date_mincardx">
					<input type="text" id="date_mincardx_actualid" name="date_mincardx"
						class="form-control" required> <span
						class="input-group-addon add-on"><span
						class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5 date">
				<div class="input-group input-append date" id="date_maxncardx">
					<input type="text" class="form-control"
						id="date_maxncardx_actualid" name="date_maxncardx"
						ng-model="date_maxncardx" required> <span
						class="input-group-addon add-on"><span
						class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
		<div class="form-group hidden">
			<label class="col-sm-2 control-label"> From Department </label>
			<div class="col-sm-4">
				<select id="departmentstartx" name="departmentstartx"
					class="form-control search-select" required>
					<option value="">--DEPARTMENT RANGE START --</option>
                    <?php
                    if (! empty($alldepartments)) {
                        ?>
                        <option selected="selected"
						value="<?= $alldepartments[0]['deptcode'] ?>"><?= $alldepartments[0]['deptname'] . ' | ' . $alldepartments[0]['deptcode'] ?></option>
                        <?php
                        array_shift($alldepartments);
                    }
                    foreach ($alldepartments as $value) {
                        ?>
                        <option value="<?= $value['deptcode'] ?>"><?= $value['deptname'] . ' | ' . $value['deptcode'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5">
				<select id="departmentendx" name="departmentendx"
					class="form-control search-select" required>
					<option value="">--DEPARTMENT RANGE END --</option>
                    <?php
                    foreach ($alldepartments as $value) {
                        ?>
                        <option value="<?= $value['deptcode'] ?>"><?= $value['deptname'] . ' | ' . $value['deptcode'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"> From Employee </label>
			<div class="col-sm-4">
				<select id="employeenumberminx" name="employeenumberminx"
					class="form-control search-select" required>
					<!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
				</select>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5">
				<select id="employeenumbermaxx" name="employeenumbermaxx"
					class="form-control search-select">
					<option value="">--EMPLOYEE RANGE END--</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 checkbox-inline"></label> <label
				class="col-sm-2 checkbox-inline"> <input type="checkbox" class="red"
				value="" checked="checked" ng-model="include_ot_1_5"> Include OT @
				1.5
			</label> <label class="col-sm-2 checkbox-inline"> <input
				type="checkbox" class="green" value="" checked="checked"
				ng-model="include_ot_2_0"> Include OT @ 2.0
			</label> <label class="col-sm-2 checkbox-inline"> <input
				type="checkbox" class="teal" value="" checked="checked"
				ng-model="include_publicholiday"> Public Holiday
			</label> <label class="col-sm-1 checkbox-inline"> <input
				type="checkbox" class="orange" value="" ng-model="include_casuals">
				Casuals
			</label>
			<button class="btn btn-azure btn-sm" type="submit">
				Show&nbsp;<i class="fa fa-plus"></i>
			</button>
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn btn-sm btn-green dropdown-toggle">
					Actions <i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu dropdown-light pull-right">
					<li><a href="#" id="exportpdf"
						onclick="printJS({printable: 'employee_attendence_cardtest', type: 'html', header: 'TimeSheet Report Card', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
							Save as PDF </a></li>
					<li><a href="#" onclick="export_damclinet()"> Send Card </a></li>
				</ul>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<span class="input-icon"> <input type="text"
					placeholder="Search  Employee Card" size="41"
					class="input-sm form-control" style="background-color: gold;"
					id="searchtablereport_id"> <i class="fa fa-search"></i>
				</span>
			</div>
		</div>
		<div class="form-group" id="tablerespdivid"></div>
	</form>
</div>
<script>
    var loadcard = "<?php echo base_url("posts/loardcarddata"); ?>";
    function selectuserbranch() {
        var e = document.getElementById("branch_start");
        $('#employeenumberminx').find('option:not(:first)').remove();
        $('#employeenumbermaxx').find('option:not(:first)').remove();
//         $('#employeenumberminx').get(0).selectedIndex = 0;
        
        //To Extraxt
        
        var milearrays_on = new Array();
//         var milearrays_on1 = new Array();
        var milearrays_on2 = new Array();
        var fields = new Array();
        //Seqg
        var mile_stones = new Array();
//         var mile_stones1 = new Array();
        var mile_stones2 = new Array();
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        //var name = fields[0];
        mile_stones = fields[1];
//         mile_stones1=fields[2];
        mile_stones2=fields[2];
        milearrays_on = mile_stones.split('@');
//         milearrays_on1=mile_stones1.split('@');
        milearrays_on2=mile_stones2.split('@');
//         console.log(mile_stones2);
        var $dropdown = $("#employeenumberminx");
        var $dropdown1 = $("#employeenumbermaxx");
        //alert(milearrays_on[0]);
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i]+'|'+milearrays_on2[i]).text(milearrays_on[i]+' ~pin~ '+milearrays_on2[i]));
        }
        for (var i = milearrays_on.length - 1; i >= 0; --i) {
        	 $dropdown1.append($("<option />").val(milearrays_on[i]+'|'+milearrays_on2[i]).text(milearrays_on[i]+' ~pin~ '+milearrays_on2[i]));
            }
    }
    var months = [1, 2, 3, 4,5, 6, 7,
        8, 9, 10,11,12];
    $(document).ready(function () {
    	selectuserbranch();
    	$("#employeenumberminx").val($("#employeenumberminx option:first").val());
    	$("#employeenumbermaxx").val($("#employeenumbermaxx option:first").val());
//     	 $("#employeenumberminx")[1].selectedIndex = 1;
        var date = new Date();
//         console.log(date.getFullYear()+' '+date.getMonth()+' '+' njovu');
        var firstDay = new Date(date.getFullYear(),months[date.getMonth()], 1);
        var lastDay = new Date(date.getFullYear(), months[date.getMonth()] + 1, 0);
        //Format Start
        var dayone = ("0" + firstDay.getDate()).slice(-2);
        var monthone = ("0" + firstDay.getMonth()).slice(-2);
        var yearone = firstDay.getFullYear();
        var firstdate = yearone + '-' + monthone + '-' + dayone;
        //Phase 2
        var daytwo = ("0" + lastDay.getDate()).slice(-2);
        var monthtwo = ("0" + lastDay.getMonth()).slice(-2);
        var yeartwo = lastDay.getFullYear();
        var lastdate = yeartwo + '-' + monthtwo + '-' + getDaysInMonth(months[date.getMonth()], date.getFullYear());
        //Format End
//        console.log(getDaysInMonth(date.getMonth(),date.getFullYear()));
        $('#date_mincardx_actualid').val(firstdate);
        $('#date_maxncardx_actualid').val(lastdate);
        $('#date_mincardx')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#att_card_formx').formValidation('revalidateField', 'date_mincardx');
        });
        $('#date_maxncardx')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#att_card_formx').formValidation('revalidateField', 'date_maxncardx');
        });
    });
    $("#att_card_formx").formValidation({
        framework: 'bootstrap',
        icon: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            departmentstartx: {
                validators: {
                    notEmpty: {
                        message: 'From Department is required'
                    }
                }
            },
            departmentendx: {
                validators: {
                    notEmpty: {
                        message: 'To Department is required'
                    }
                }
            },
            employeenumberminx: {
                validators: {
                    notEmpty: {
                        message: 'From Employee is required'
                    }
                }
            },
//             employeenumbermaxx: {
//                 validators: {
//                     notEmpty: {
//                         message: 'To Employee is required'
//                     }
//                 }
//             },
            date_mincardx: {
                validators: {
                    notEmpty: {
                        message: 'From Date is required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
                }
            },
            date_maxncardx: {
                validators: {
                    notEmpty: {
                        message: 'To Date is required'
                    },
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        $.ajax({
            url: loadcard,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
//                url: url_addemployee,
//                method: 'post',
//                dataType: "JSON",
//                data: $form.serialize()
        }).done(function (response) {
           console.log(response);
//             if (response.status === 1) {
//                 $.notify(response.report, "success");
//                 $("#tablerespdivid").html(response.data);
//                 $(document).ready(function () {
//                     $('#searchtablereport_id').tableSearch();
//                 });
//             } else {
//                 $.notify(response.report, "error");
//                 $("#tablerespdivid").html('');
//             }
        });
    });
    function getDaysInMonth(m, y) {
        return m === 2 ? y & 3 || !(y % 25) && y & 15 ? 28 : 29 : 30 + (m + (m >> 3) & 1);
    }
</script>