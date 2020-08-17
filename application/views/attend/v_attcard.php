<?php
// print_array($all_employees);
?>
<div class="panel-body">
	<form class="form-horizontal" role="form" ng-app="ReportCard"
		ng-controller="ReportCardCtrl" name="att_card_form">
		<div class="form-group">
			<label class="col-sm-1 control-label"> Date Range </label>
			<div class="col-sm-5 date">
				<div class="input-group input-append date" id="date_mincard">
					<input type="text" name="date_mincard" class="form-control"
						ng-model="date_mincard" required> <span
						class="input-group-addon add-on"><span
						class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5 date">
				<div class="input-group input-append date" id="date_maxncard">
					<input type="text" class="form-control" name="date_maxncard"
						ng-model="date_maxncard" required> <span
						class="input-group-addon add-on"><span
						class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"> From Department </label>
			<div class="col-sm-4">
				<select id="departmentstart" name="departmentstart"
					class="form-control search-select" ng-model="departmentstart"
					required>
					<option value="">--DEPARTMENT RANGE START --</option>
                    <?php
                    foreach ($alldepartments as $value) {
                        ?>
                        <option value="<?= $value['id'] ?>"><?= $value['deptname'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5">
				<select id="departmentend" name="departmentend"
					class="form-control search-select" ng-model="departmentend"
					required>
					<option value="">--DEPARTMENT RANGE END --</option>
                    <?php
                    foreach ($alldepartments as $value) {
                        ?>
                        <option value="<?= $value['id'] ?>"><?= $value['deptname'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"> From Employee </label>
			<div class="col-sm-4">
				<select id="employeenumbermin" name="employeenumbermin"
					class="form-control search-select" ng-model="employeenumbermin"
					required>
					<option value="">--EMPLOYEE RANGE START --</option>
                    <?php
                    foreach ($all_employees as $value) {
                        ?>
                        <option value="<?= $value['employee_code'] ?>"><?= $value['employee_code'] . ' | ' . $value['firstname'] . ' ' . $value['lastname'] ?></option>
                        <?php
                    }
                    ?>
                </select>
			</div>
			<label class="col-sm-1 control-label"> To </label>
			<div class="col-sm-5">
				<select id="employeenumbermax" name="employeenumbermax"
					class="form-control search-select" ng-model="employeenumbermax"
					required>
					<option value="">--EMPLOYEE RANGE END--</option>
                    <?php
                    foreach ($all_employees as $value) {
                        ?>
                        <option value="<?= $value['employee_code'] ?>"><?= $value['employee_code'] . ' | ' . $value['firstname'] . ' ' . $value['firstname'] ?></option>
                        <?php
                    }
                    ?>
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
			<button type="button" class="btn btn-azure btn-sm" type="submit"
				ng-model="showtable_but" name="showtable_but" id="showtable_but"
				ng-disabled="att_card_form.$invalid" ng-click="loadtable()">Show</button>
			<div class="btn-group">
				<button data-toggle="dropdown"
					class="btn btn-sm btn-green dropdown-toggle">
					Actions <i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu dropdown-light pull-right">
					<li><a href="#" id="exportpdf"
						onclick="printJS({printable: 'employee_attendence_card', type: 'html', header: 'All Clients', maxWidth: '1000', honorMarginPadding: true, targetStyles: ['*'],showModal:true,repeatTableHeader:false})">
							Save as PDF </a></li>
					<li><a href="#" onclick="export_damclinet()"> Send Card </a></li>
				</ul>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<span class="input-icon"> <input type="text"
					placeholder="Search  Employee Card" size="41"
					class="input-sm form-control" data-ng-model="employee_cardtable"
					style="background-color: gold;"> <i class="fa fa-search"></i>
				</span>
			</div>
		</div>
		<div class="form-group">
			<table class="table table-striped table-hover"
				id="employee_attendence_card">
				<!-- 				<style> -->
				/* @media print { */ /* .footer, #non-printable { */ /* display:
				none !important; */ /* } */ /* #printable { */ /* display: block; */
				/* } */ /* } */
				<!-- </style> -->
				<!--<tbody>-->
				<tr
					ng-repeat-start="x in employee_code_datain| filter:employee_cardtable">
				
				
				<tr>
					<td style="font-size: large; color: black;">TimeSheet Report</td>
					<td>For</td>
					<td style="font-size: large; color: black;">SERENITY INVESTMENTS
						LIMITED</td>
					<td>From</td>
					<td><b style="color: black;">{{date_mincard}}</b></td>
					<td>To</td>
					<td><b style="color: black;">{{date_maxncard}}</b></td>
				</tr>
				<tr>
					<td style="color: black;">Alloc. Dept</td>
					<td style="color: black;">{{x.allocated_department}}</td>
				</tr>
				<tr>
					<td style="color: black;">Working. Dept</td>
					<td style="color: black;">{{ x.working_department}}</td>
				</tr>
				<tr>
					<td style="color: black;"><b>Shift Definitions</b></td>
					<td style="color: black;">{{x.shiftdefs}}</td>
					<td></td>
					<td></td>
					<td style="color: black;">Run :</td>
					<td style="color: black;"><?= date('Y-m-d'); ?></td>
					<td></td>
					<td style="color: black;">At: <?= date('H:i:s'); ?></td>
				</tr>
				<tr>
					<td style="font-size: 15px; color: black;">Employee</td>
					<td style="font-size: 15px; color: black;">{{x.empno_rode}}</td>
					<td style="font-size: 15px; color: black;">{{x.empno_names}}</td>
				</tr>
				<tr>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">Total
						Days Worked {{x.totaldaysworked}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">Total
						Days Absent {{x.totaldaysabsent}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">Total
						Normal Time {{x.totalnormaltime}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">Tot
						Hours {{x.tohrs}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">M
						1.5 {{x.m1_5}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">O.T
						1.5 {{x.ot1_5}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">OT
						2.0 {{x.ot2_0}}</td>
					<td
						style="font-size: 15px; color: black; background-color: burlywood;">Short
						T {{x.short_t}}</td>
				</tr>
				<tr>
					<th>Day</th>
					<th>Date</th>
					<th>Shift</th>
					<th>Login</th>
					<th>Lunch O/I</th>
					<th>Logout</th>
					<th>ot15</th>
					<th>ot20</th>
				</tr>
				</tr>
				<tr ng-repeat-end ng-repeat="subitem in x.all_range_data">
					<td>{{setdateday('dayfromdate', subitem.date)}} {{ dayfromdate |
						date:'EEE'}}</td>
					<td>{{subitem.date}}</td>
					<td>{{subitem.shift}}</td>
					<td>{{subitem.login}}</td>
					<td>{{subitem.logout}}</td>
					<td>{{subitem.ot15}}</td>
					<td>{{subitem.ot20}}</td>
				</tr>
			</table>
		</div>
	</form>
</div>
<script>
    $(document).ready(function () {
        $('#date_mincard')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#att_card_form').formValidation('revalidateField', 'date_mincard');
                });
        $('#date_maxncard')
                .datepicker({
                    format: 'dd-mm-yyyy'
                })
                .on('changeDate', function (e) {
                    // Revalidate the date field
                    $('#att_card_form').formValidation('revalidateField', 'date_maxncard');
                });
    });
    var app = angular.module('ReportCard', []);
    app.controller('ReportCardCtrl', ['$scope', '$http', function ($scope, $http) {
            // default post header
            $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
            // send login data
            $scope.loadtable = function () {
//                console.log($scope.employeenumbermin);

//testm
                var reportcardtable = '<?= base_url('posts/reportcard') ?>';
                $http({
                    method: 'POST',
                    url: reportcardtable,
                    data: {'message': 'Hello world'}
                }).then(function (response) {
                    $scope.employee_code_datain = response.data;
//                    console.log(response.data);
                }, function (response) { // optional
                    console.log('failedtoupdateadd angular' + ' @ ' + response);
                });
//                console.log(departmentff);
            }
            $scope.setdateday = function (variable, value) {
                $scope[variable] = new Date(value);
            };
            $scope.setScopeVariable = function (variable, value) {
                $scope[variable] = value;
            };
        }]);
</script>