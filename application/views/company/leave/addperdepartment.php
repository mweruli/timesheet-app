<?php
$addperdepartment = $controller->gettablecolumns('addperdepartment');
$addperdepartmentvalues = array();
$leavetypes = $controller->allselectablebytable('leaveconfig');
?>
<div class="row" id="addperdepartmentconfig">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> ADD PER <span class="text-bold">DEPARTMENT</span></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                        <i class="fa fa-cog"></i>
                    </a>
                    <?php echo $this->load->view('part/include/formconfig', '', TRUE); ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="addperdepartmentconfigform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="addperdepartment">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($addperdepartment, 'selectdepartment')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            DEPARTMENT
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="selectdepartment" id="selectdepartment"  >
                                <option value="">-SELECT DEPARTMENT-</option>
                                <option value="0">-ALL DEPARTMENT-</option>
                                <?php
                                foreach ($controller->allselectablebytable('departments') as $departments) {
                                    ?>
                                    <option value="<?= $departments['id'] ?>"><?= $departments['department'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">
                        LEAVE TYPE
                    </label>
                    <div class="col-sm-4">
                        <select  class="form-control search-select" placeholder="Select Form" name="id_leavetype" id="id_leavetypen" onclick="setbalancen()"  >
                            <option value="">-LEAVE TYPE-</option>
                            <?php
                            foreach ($leavetypes as $employee) {
                                ?>
                                <option value="<?= $employee['id'] ?>"><?= $employee['leavetype'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        LEAVE PERIOD
                    </label>
                    <div class="col-sm-4">
                        <div id="leaveperiodn" class="pull-right"
                             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($addperdepartment, 'entitlement')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            DAYS  ENTITLEMENT
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="DAYS ENTITLEMENT" id="entitlement" name="entitlement"  class="form-control" value="<?= printvalues('entitlement', $addperdepartmentvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group hidden">
                    <input type="text" id="startdaten" name="startdaten"> <input
                        type="text" id="enddaten" name="enddaten">
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="leaveperdepartmentfilter" name="leaveperdepartmentfilter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentaddperdepartment"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        //LOAD TABLE
        //END LOAD TABLE
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#leaveperiodn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startdaten = start.format('YYYY-MM-DD');
            var endate = end.format('YYYY-MM-DD');
            //            $('#startdaten').val = startdaten;
            $("#startdaten").val(startdaten);
            $("#enddaten").val(endate);
            //            alert(startdaten + ' ' + end);
        }
        $('#leaveperiodn').daterangepicker({
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
        $('#addperdepartmentconfigform')
                .formValidation({}).on('success.form.fv', function (e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            datagrid.addRow('addperdepartment', $(this).attr("method"), new FormData(this), "tablecontentaddperdepartment");
            $('#addperdepartmentconfigform').formValidation('resetForm', true);
        });
    });
    function setbalancen() {
        var url_balanceleave = '<?= base_url() ?>leave/calculateleave';
        var user_id = '<?= $this->session->userdata('logged_in')['id'] ?>';
//        var leavetypeid = document.getElementById("id_leavetypen").value;
        var e = document.getElementById("id_leavetypen");
        var leavetypeidn = e.options[e.selectedIndex].value;
        var leavetypenamen = e.options[e.selectedIndex].text;
        $.ajax({
            url: url_balanceleave,
            type: 'POST',
            dataType: "json",
            data: {userid: user_id, leavetype: leavetypeidn, leavename: leavetypenamen}
        }).done(function (response) {
//            console.log(response);
            document.getElementById("entitlement").value = response.balance;
        });
    }
</script>

