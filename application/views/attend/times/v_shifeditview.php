<script src="<?= base_url() ?>assets/js/editablejss/jquery.tabledit.js"></script>
<div class="row" id="add_employeediv">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title">Sift <span class="text-bold">Settings</span></h4>
        </div>
        <div class="panel-body">
            <form id="siftloadsettings" method="post" class="form-horizontal" role="form" ng-app="ShiftSettings" ng-controller="ShiftSettingsCtrl" name="siftloadsettings">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        DEFINITION
                    </label>
                    <div class="col-sm-6">
                        <select  id="siftloadsettingsselect" class="form-control search-select" placeholder="Select employmenttype_ids" name="siftloadsettingsselect" ng-model="siftloadsettingsselect" required>
                            <option value="">-SELECT SIFT DEFINITION-</option>
                            <?php
                            foreach ($siftdef as $value) {
                                ?>
                                <option value="<?= $value['id'] ?>"><?= $value['shiftype'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!--<p>-->
                        <button class="btn btn-blue btn-block" type="submit" ng-click="loadshiftdefs()" ng-disabled ="siftloadsettings.$invalid">
                            Load Shift Settings <i class="fa fa-refresh fa-spin"></i>
                        </button>
                        <!--</p>-->
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <table class="table table-striped table-hover" id="shift_tablemakup">
                        <thead>
                            <tr>
                                <td>Day</td>
                                <td>T Be4 Starts</td>
                                <td>Shift Starts</td>
                                <td>T After Starts</td>
                                <td>T Be4 Ends</td>
                                <td>Shift Ends</td>
                                <td>T After Ends</td>
                                <td>Normal Hours</td>
                                <td>Min Hrs</td>
                                <td>Max Min In</td>
                                <td>Max Min Out</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat-start="x in datashiftdefs">
                                <td>{{ x.day_week}}</td>
                                <td>{{ x.tol_beforestart}}</td>
                                <td>{{ x.shiftstarts}}</td>
                                <td>{{ x.tolerence_afterstart}}</td>
                                <td>{{ x.tolerence_beforeend}}</td>
                                <td>{{ x.shift_end}}</td>
                                <td>{{ x.tolerence_afterend}}</td>
                                <td>{{ x.normal_hours}}</td>
                                <td>{{ x.min_hrs}}</td>
                                <td>{{ x.maxmin_in}}</td>
                                <td>{{ x.maxmin_out}}</td>
                            </tr>
                            <tr ng-repeat-end hidden="true">
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <!--</div>-->
        <!-- end: TEXT FIELDS PANEL -->
    </div>
</div>
<script>
    var app = angular.module('ShiftSettings', []);
    app.controller('ShiftSettingsCtrl', function ($scope, $http, $q) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $scope.loadshiftdefs = function () {
//                console.log($scope.employeenumbermin);
            var reportcardtablem = '<?= base_url('posts/shiftsettings/') ?>' + $scope.siftloadsettingsselect;
//            language.current = $scope.siftloadsettingsselect;
//            $window.invoice = $scope.siftloadsettingsselect;
            $http({
                method: 'POST',
                url: reportcardtablem,
                data: {'shift_id': $scope.siftloadsettingsselect}
            }).then(function (response) {
                $scope.datashiftdefs = response.data;
//                console.log(reportcardtablem);
            }, function (response) { // optional
                console.log('failedtoupdateadd angular' + ' @ ' + response);
            });
//                console.log(depw artmentff);
        };
    });
    $('#shift_tablemakup').Tabledit({
        url: '<?= base_url('posts/after_changeshift') ?>',
        deleteButton: false,
        editmethod: 'post',
        deletemethod: 'post',
        rowIdentifier: 'day_week',
        columns: {
            identifier: [0, 'day_week'],
            editable: [[1, 'tol_beforestart'], [2, 'shiftstarts'], [3, 'tolerence_afterstart'], [4, 'tolerence_beforeend'], [5, 'shift_end'], [6, 'tolerence_afterend'], [7, 'normal_hours'], [8, 'min_hrs'], [9, 'maxmin_in'], [10, 'maxmin_out']]
        },
        onSuccess: function (data, textStatus, jqXHR) {
            if (data.status === 0) {
                $.notify(data.report, "success");
            } else {
                $.notify(data.report, "error");
            }
            return;
        }
    });
//    console.log(language.latest);
</script>