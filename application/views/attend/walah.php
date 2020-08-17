
<style>
.cleaner {
	clear: both;
}

.h20 {
	height: 40px;
}

* {
	box-sizing: border-box;
}

html, body {
	margin: 0;
	padding: 0;
}

.addItems {
	height: 10vh;
	margin-bottom: 5vh;
}

.box {
	float: left;
	display: inline-block;
	margin: 0;
	padding: 10px;
	height: 75vh;
	/*border: #ccccff outset 1px;*/
	overflow: auto;
	/*color: #ff0066;*/
	font-size: small;
	font-family: fantasy;
}
/*            .box > div{
                    border: #ffffff ridge 2px;
                    border-bottom: none;
                    border-radius: 0px;
                }*/
.jajaborder {
	border: #ffffff ridge 2px;
	border-bottom: none;
	border-radius: 0px;
}

.box>div>div {
	padding: 7px;
	border-bottom: #ffffff ridge 2px;
}

.box>div>div:hover {
	background-color: rgba(100, 150, 220, .5);
	/*transition: background-color .4s ease;*/
}

.box>button {
	display: inline-block;
	width: 70%;
	margin: 5% 15%;
}

.button {
	padding: 10px 24px;
	border-radius: 3px;
	border: none;
	box-shadow: 2px 5px 10px rgba(22, 22, 22, .1);
}

.button:hover {
	transition: all 60ms ease;
	opacity: .95;
	box-shadow: #444 0 3px 3px 0;
}

.leftBox {
	width: 35%;
}

.button_holder {
	width: 30%;
}

.rightBox {
	width: 35%;
}
/*input[type="text"],*/
select {
	/*padding:1px;*/
	
}

.activeselect {
	transition: all .1s ease;
	background-color: #99ff99;
	color: #000;
	/*border: dotted 1px black;*/
	box-shadow: 0 2px 2px 0 rgba(97, 97, 97, .5);
	margin-bottom: 1px;
}

.button-deactive {
	opacity: .5;
	box-shadow: none;
}

.button-deactive:hover {
	opacity: .5;
	box-shadow: none;
}
</style>

</div>
<div class="row panel panel-white">
	<div class="col-md-12">
		<form class="container" ng-app="Add_Remove_Box" ng-controller="Ctrl"
			name="assingshift">
			<br>
            <?php
            // print_array($alldepartments);
            ?>
            <div class="form-group">
				<div class="col-sm-6">
					<select id="id_select_shift" name="id_select_shift"
						class="form-control search-select" ng-model="id_select_shift"
						ng-click="loadusersShift()" required>
						<option value="">--SELECT SHIFT GROUP--</option>
                        <?php
                        foreach ($shift_def as $value) {
                            ?>
                            <option value="<?= $value['id'] ?>"><?= $value['shiftype'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
				</div>
				<div class="col-sm-6">
					<select id="id_department" name="id_department"
						class="form-control search-select" ng-model="id_department"
						ng-disabled="!assingshift.id_select_shift.$valid"
						ng-click="loadusersAlUn()" required>
						<option value="">-SELECT DEPARTMENT-</option>
                        <?php
                        foreach ($alldepartments as $value) {
                            ?>
                            <option value="<?= $value['id'] ?>"><?= $value['deptname'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
					<!--<input type="text" placeholder="Text Field" id="form-field-11" class="form-control">-->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"> <font size="4" color="red"><b>Not
							Assigned</b></font>
				</label>
				<div class="col-sm-4" style="width: 30%; float: left;"></div>
				<label class="col-sm-4 control-label"> <font size="4" color="blue"><b>Assigned</b></font>
				</label>
			</div>
			<div class="form-group cleaner h20">
				<div class="col-sm-4">
					<span class="input-icon"> <input type="text"
						placeholder="Search Un Allocated" class="input-sm form-control"
						data-ng-model="searchTermleft"> <i class="fa fa-search"></i>
					</span>
				</div>
				<div class="col-sm-4" style="width: 30%; float: left;"></div>
				<div class="col-sm-4">
					<span class="input-icon"> <input type="text"
						placeholder="Search  Assigned" size="41"
						class="input-sm form-control" data-ng-model="searchTermRight"> <i
						class="fa fa-search"></i>
					</span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div class="box leftBox">
						<div class="jajaborder" id="left_id_div">
							<div id="{{left.id}}" ng-click="clicked($event, 0)"
								data-ng-repeat="left in lefts| filter:searchTermleft">{{left.user_id}}
								* {{left.firstname}} {{left.lastname}}</div>
						</div>
					</div>
					<div class="box button_holder">
						<button ng-click="add()" class="btn btn-green"
							ng-disabled="assingshift.$invalid">
							<i class="fa fa-arrow-right"></i>
						</button>
						<button ng-click="remove()" class="btn btn-red"
							ng-disabled="assingshift.$invalid">
							<i class="fa fa-arrow-left"></i>
						</button>
						<button ng-click="addAll()" class="btn btn-green"
							ng-disabled="assingshift.$invalid">
							<i class="fa fa-forward"></i>
						</button>
						<button ng-click="removeAll()" class="btn btn-red"
							ng-disabled="assingshift.$invalid">
							<i class="fa fa-backward"></i>
						</button>
					</div>
					<div class="box rightBox">
						<div class="jajaborder" id="right_id_div">
							<div id="{{right.id}}" ng-click="clicked($event, 1)"
								data-ng-repeat="right in rights| filter:searchTermRight">{{right.user_id}}
								* {{right.firstname}} {{right.lastname}}</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script>
        var app = angular.module('Add_Remove_Box', []);
        app.controller('Ctrl', function ($scope, $http, $q) {
            var i;
            var isRepeated = false;
            var actionLicense = true;
            var prevElement = null;
            var currentElement = null;
            var positionSide = null;
            var shift_id = '';
            var department = '';
            removeclassma('left_id_div');
            removeclassma('right_id_div');
            Object.toparams = function ObjecttoParams(obj) {
                var p = [];
                for (var key in obj) {
                    p.push(key + '=' + encodeURIComponent(obj[key]));
                }
                return p.join('&');
            };
            $scope.loadusersShift = function () {
                if (!$scope.assingshift.id_department.$valid) {
                    console.log('papa tata');
                    //  loadusersAlUn();
                } else {
                    $scope.loadusersAlUn();
                }
            }
            $scope.loadusersAlUn = function () {
                addclassma('left_id_div');
                addclassma('right_id_div');
                shift_id = $scope.id_select_shift;
                department = $scope.id_department;
                var url_left = '<?= base_url('posts/get_lefttallocated/') ?>' + shift_id + '/' + department;
                var url_right = '<?= base_url('posts/get_rightallocated/') ?>' + shift_id + '/' + department;
                $scope.product_list_1 = $http.get(url_left, {cache: false});
                $scope.product_list_2 = $http.get(url_right, {cache: false});
                $q.all([$scope.product_list_1, $scope.product_list_2]).then(function (values) {
                    $scope.lefts = values[0].data;
                    $scope.rights = values[1].data;
                    if ($scope.lefts.length <= 0) {
                        removeclassma('left_id_div');
                    }
                    if ($scope.rights.length <= 0) {
                        removeclassma('right_id_div');
                    }
//                console.log($scope.lefts.$$state.value);
                    $scope.add = function () {
//                    console.log(leftItemNo);
                        if (actionLicense && positionSide === 0) {
                            actionLicense = false;
                            var leftItemNo = -1;
                            //Search and Assgin index of value
                            var alltext = currentElement.textContent;
                            var useridtext = alltext.split('*')[0].trim();
                            $scope.lefts.some(function (obj, j) {
                                return obj.user_id === useridtext ? leftItemNo = j : false;
                            });
//                            console.log($scope.id_select_shift + ' ' + $scope.id_department);
//                            console.log($scope.lefts[leftItemNo]);
                            var msms = $scope.lefts[leftItemNo];
                            $scope.rights.push($scope.lefts[leftItemNo]);
                            $scope.lefts.splice(leftItemNo, 1);
                            if ($scope.lefts.length <= 0) {
                                removeclassma('left_id_div');
                            }
                            var urlsingleupdate = '<?= base_url('posts/addsingleuser/') ?>' + shift_id + '/' + department;
                            $http({
                                method: 'POST',
                                url: urlsingleupdate,
                                data: Object.toparams(msms),
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).then(function (response) {
                                console.log(response.data);
                            }, function (response) { // optional
                                console.log('failedtoupdateadd angular' + ' @ ' + response);
                            });
                        }
                        var element = document.getElementById('right_id_div');
                        if (!element.classList.contains('jajaborder')) {
                            element.classList.add("jajaborder");
                        }
//                        console.log($scope.rights);
                    };
                    $scope.remove = function () {
                        if (actionLicense && positionSide === 1) {
                            actionLicense = false;
                            var rightItemNo = -1;
                            var alltext = currentElement.textContent;
                            var useridtext = alltext.split('*')[0].trim();
//                            console.log(useridtext);
                            $scope.rights.some(function (obj, j) {
                                return obj.user_id === useridtext ? rightItemNo = j : false;
                            });
//                            console.log($scope.rights[rightItemNo]);
                            var msms = $scope.rights[rightItemNo];
                            $scope.lefts.push($scope.rights[rightItemNo]);
                            $scope.rights.splice(rightItemNo, 1);
                            if ($scope.rights.length <= 0) {
                                removeclassma('right_id_div');
                            }

                            shift_id = $scope.id_select_shift;
                            department = $scope.id_department;
                            var urlsingleupdate = '<?= base_url('posts/removesingleuser/') ?>' + shift_id + '/' + department;
                            $http({
                                method: 'POST',
                                url: urlsingleupdate,
                                data: Object.toparams(msms),
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).then(function (response) {
                                console.log(response.data);
                            }, function (response) { // optional
                                console.log('failedtoupdateadd angular' + ' @ ' + response);
                            });
                            ;
                        }
                        var element = document.getElementById('left_id_div');
                        if (!element.classList.contains('jajaborder')) {
                            element.classList.add("jajaborder");
                        }
                    };
                    $scope.addAll = function () {
                        var urlsallupdate = '<?= base_url('posts/addall/') ?>' + shift_id + '/' + department;
                        $scope.rights = $scope.rights.concat($scope.lefts);
                        $scope.lefts.splice(0, $scope.lefts.length);
                        removeclassma('left_id_div');
                        addclassma('right_id_div');
                        var msms = {id_dum: 'add_dum'};
                        $http({
                            method: 'POST',
                            url: urlsallupdate,
                            data: Object.toparams(msms),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (response) {
                            console.log(response.data);
                        }, function (response) { // optional
                            console.log('failedtoupdateadd angular' + ' @ ' + response);
                        });
                    };
                    $scope.removeAll = function () {
                        var urlsallupdate = '<?= base_url('posts/removeall/') ?>' + shift_id + '/' + department;
                        $scope.lefts = $scope.lefts.concat($scope.rights);
                        $scope.rights.splice(0, $scope.rights.length);
                        addclassma('left_id_div');
                        removeclassma('right_id_div');
                        var msms = {id_dum: 'add_dum'};
                        $http({
                            method: 'POST',
                            url: urlsallupdate,
                            data: Object.toparams(msms),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).then(function (response) {
                            console.log(response.data);
                        }, function (response) { // optional
                            console.log('failedtoupdateadd angular' + ' @ ' + response);
                        });
                    };
                    $scope.clicked = function ($event, pos) {
                        actionLicense = true;
                        positionSide = pos;
                        currentElement = $event.currentTarget;
//                    var deleteButton = document.getElementsByClassName("delete")[0];
                        if (pos === 1) {
//                        if (deleteButton.className.indexOf("button-deactive") === -1) {
//                            deleteButton.className += " button-deactive";
//                        }
                        } else {
//                        deleteButton.className = deleteButton.className.replace(" button-deactive", "");
                        }

                        if (prevElement === null) {
                            prevElement = currentElement;
                        } else {
                            if (prevElement === currentElement) {
                                isRepeated = !isRepeated;
                            } else {
                                if (isRepeated) {
                                    isRepeated = false;
                                }
                            }
                        }
                        if (prevElement.className.indexOf("activeselect") !== -1) {
//                             console.log('papa');
                            prevElement.className = prevElement.className.replace("activeselect", "");
                        }
                        if (!isRepeated && currentElement.className.indexOf("activeselect") === -1) {
                            currentElement.className += " activeselect";
                        }
                        prevElement = currentElement;
                    };
                });
            };
        });
        function removeclassma(id_div) {
            var element = document.getElementById(id_div);
            element.classList.remove("jajaborder");
//                if (nga.length <= 0) {
//                    var element = document.getElementById("left_id_div");
//                    element.classList.remove("jajaborder");
//                }
        }
        function addclassma(id_div) {
            var element = document.getElementById(id_div);
            element.classList.add("jajaborder");
//                if (nga.length <= 0) {
//                    var element = document.getElementById("left_id_div");
//                    element.classList.remove("jajaborder");
//                }
        }
    </script>