<div class="panel-body">
	<form class="form-horizontal" role="form" method="post"
		name="att_card_formx" id="att_card_formx" novalidate>
		<div class="form-group">
			<label class="col-sm-1 control-label"> Branch </label>
			<div class="col-sm-5">
				<select id="branch_start" name="branch_start"
					class="form-control search-select" onChange="selectuserbranch();">
					<option value="">--SELECT BRANCH --</option>
					<?php
					foreach ( $allbranches as $value ) {
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
																				if (! empty ( $alldepartments )) {
																					?>
                        <option selected="selected"
						value="<?= $alldepartments[0]['deptcode'] ?>"><?= $alldepartments[0]['deptname'] . ' | ' . $alldepartments[0]['deptcode'] ?></option>
                        <?php
																					array_shift ( $alldepartments );
																				}
																				foreach ( $alldepartments as $value ) {
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
																				foreach ( $alldepartments as $value ) {
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
						onclick="printJS({printable: 'employee_attendence_cardtest', type: 'html', header:'MATHAI SUPERMAKETS LIMITED TIME REPORT', maxWidth: '1000',showModal:true, honorMarginPadding: false, targetStyles: ['*']})">
							Save as PDF </a></li>
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
		<style>
@media print {
	.footer, #non-printable {
		display: none !important;
	}
	#printable {
		display: block;
	}
}
</style>
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
        console.log(strUser);
    }
    //Date Affair
    function formatDate(dDate,sMode){   
    var today = dDate;
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10) {
        dd = '0'+dd
    } 
    if(mm<10) {
        mm = '0'+mm
    } 
    if (sMode+""==""){
        sMode = "dd/mm/yyyy";
    }
    if (sMode == "yyyy-mm-dd"){
        return  yyyy + "-" + mm + "-" + dd + "";
    }
    if (sMode == "dd/mm/yyyy"){
        return  dd + "/" + mm + "/" + yyyy;
    }
}
    //End Date Affair
    $(document).ready(function () {
//     	selectuserbranch();
    	$("#employeenumberminx").val($("#employeenumberminx option:first").val());
    	$("#employeenumbermaxx").val($("#employeenumbermaxx option:first").val());
var date = new Date(), y = date.getFullYear(), m = date.getMonth();
var firstDay = new Date(y, m, 1);
var lastDay = new Date(y, m + 1, 0);
var dateone=formatDate(firstDay,'yyyy-mm-dd');
var datetwo=formatDate(lastDay,'yyyy-mm-dd');
$('#date_mincardx_actualid').val(dateone);
$('#date_maxncardx_actualid').val(datetwo);
// console.log(date);
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
//            console.log(response);
            if (response.status === 1) {
//             	 console.log(response);
                $.notify(response.report, "success");
                $("#tablerespdivid").html(response.data);
//                 $('#employee_attendence_cardtest').DataTable();
//                 $(document).ready(function () {
//                 	$('#employee_attendence_cardtest').DataTable();
// //                     $('#searchtablereport_id').tableSearch();
//                 });
            } else {
                $.notify(response.report, "error");
                $("#tablerespdivid").html('');
            }
        });
    });
    function getDaysInMonth(m, y) {
        return m === 2 ? y & 3 || !(y % 25) && y & 15 ? 28 : 29 : 30 + (m + (m >> 3) & 1);
    }
    function printTrials(){
    	$('#employee_attendence_cardtest').prepend('Print this page'); $('a.print-preview').printPreview();
//     	$("#employee_attendence_cardtest").print({
//     	    addGlobalStyles : true,
//     	    stylesheet : null,
//     	    rejectWindow : true,
//     	    noPrintSelector : ".no-print",
//     	    iframe : true,
//     	    append : null,
//     	    prepend : null
//     	});
        }
</script>