<div class="panel-body">
    <form class="form-horizontal" role="form" method="post"
          name="employeereport_form" id="employeereport_form" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_startpayemreport" name="branch_startpayemreport"
                        class="form-control search-select" onChange="selectuserbranchpayemreport();">
                    <option value="">--SELECT BRANCH --</option>
                    <?php
                    foreach ($allbranches as $value) {
                        ?>
                        <option
                            value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                            <?php
                        }
                        ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"> From Employee </label>
            <div class="col-sm-4">
                <select id="employeenumberminxpayemreport" name="employeenumberminxpayemreport"
                        class="form-control search-select" required>
                    <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                </select>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5">
                <select id="employeenumbermaxxpayemreport" name="employeenumbermaxxpayemreport"
                        class="form-control search-select">
                    <option value="">--EMPLOYEE RANGE END--</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                Employment Type
            </label>
            <div class="col-sm-4">
                <select  class="form-control search-select" placeholder="Select Form" name="employmenttype_id" id="employmenttype_id"  >
                    <option value="">-SELECT Employment Type-</option>
                    <?php
                    foreach ($controller->allselectablebytable('employementtypes') as $emptyp) {
                        ?>
                        <option  value="<?= $emptyp['id'] ?>" <?php
                        if ($emptyp['employementtype'] == "CASUALS") {
                            echo 'selected';
                        }
                        ?>><?= $emptyp['employementtype'] ?></option>
                                 <?php
                             }
                             ?>
                </select>
            </div>
            <label class="col-sm-2 control-label">
                Employee Status
            </label>
            <div class="col-sm-4">
                <select  class="form-control search-select" placeholder="Select Form" name="employementstatus_id" id="employementstatus_id"  >
                    <option value="">-SELECT Employee Status-</option>
                    <?php
                    foreach ($controller->allselectablebytable('employementstatus') as $emptyp) {
                        ?>
                        <option  value="<?= $emptyp['id'] ?>" <?php
                        if ($emptyp['status'] == "ACTIVE") {
                            echo 'selected';
                        }
                        ?>><?= $emptyp['status'] ?></option>
                                 <?php
                             }
                             ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 pull-right">
                <div class="btn-group">
                    <button data-toggle="dropdown"
                            class="btn btn-sm btn-green dropdown-toggle">
                        Actions <i class="fa fa-angle-down"></i>
                    </button>&nbsp;
                    <ul class="dropdown-menu dropdown-light">
                        <li><a href="#" id="exportpdf"
                               onclick="printJS({printable: 'emreportfortnight_card', type: 'html', maxWidth: '1000', showModal: true, repeatTableHeader: true, honorMarginPadding: false, targetStyles: ['*']})">
                                Save as PDF </a></li>
                        <li><a href="#" id="employeelist_excell_export">
                                Save as Excel </a></li>
                    </ul>
                </div>
                <button class="btn btn-azure btn-sm" type="submit">
                    Show&nbsp;<i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group" id="tablerespdividemreport"></div>
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
    var loadpayemreport = "<?php echo base_url("humanr/emreportreport"); ?>";
    function selectuserbranchpayemreport() {
        var e = document.getElementById("branch_startpayemreport");
        $('#employeenumberminxpayemreport').find('option:not(:first)').remove();
        $('#employeenumbermaxxpayemreport').find('option:not(:first)').remove();
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
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
//         milearrays_on1=mile_stones1.split('@');
        milearrays_on2 = mile_stones2.split('@');
//         console.log(mile_stones2);
        var $dropdown = $("#employeenumberminxpayemreport");
        var $dropdown1 = $("#employeenumbermaxxpayemreport");
        //alert(milearrays_on[0]);
        for (var i = 0; i < milearrays_on.length; i++) {
            $dropdown.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
            if (i === 0) {
                $dropdown.val(milearrays_on[i] + '|' + milearrays_on2[i]).change();
//                console.log('joash njovu');
            }
        }
        var startmax = milearrays_on.length - 1;
        for (var i = milearrays_on.length - 1; i >= 0; --i) {
            $dropdown1.append($("<option />").val(milearrays_on[i] + '|' + milearrays_on2[i]).text(milearrays_on[i] + ' ~pin~ ' + milearrays_on2[i]));
            if (i === startmax) {
                $dropdown1.val(milearrays_on[i] + '|' + milearrays_on2[i]).change();
//                console.log('joash njovu');
            }
        }
//        console.log(strUser);
    }
    //Date Affair
    function formatDate(dDate, sMode) {
        var today = dDate;
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        if (sMode + "" == "") {
            sMode = "dd/mm/yyyy";
        }
        if (sMode == "yyyy-mm-dd") {
            return  yyyy + "-" + mm + "-" + dd + "";
        }
        if (sMode == "dd/mm/yyyy") {
            return  dd + "/" + mm + "/" + yyyy;
        }
    }
    //End Date Affair
    $(document).ready(function () {
//     	selectuserbranchpayemreport();
        $("#employeenumberminxpayemreport").val($("#employeenumberminxpayemreport option:first").val());
        $("#employeenumbermaxxpayemreport").val($("#employeenumbermaxxpayemreport option:first").val());
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardxpayemreportp').val(dateone);
        $('#date_maxncardxpayemreportp').val(datetwo);
// console.log(date);
    });
    $("#employeereport_form").formValidation({
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
            employeenumberminxpayemreport: {
                validators: {
                    notEmpty: {
                        message: 'From Employee is required'
                    }
                }
            }
            ,
            employmenttype_id: {
                validators: {
                    notEmpty: {
                        message: 'To Employee Type is required'
                    }
                }
            }
            ,
            employementstatus_id: {
                validators: {
                    notEmpty: {
                        message: 'To Employee Status is required'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {
        e.preventDefault();
        $.ajax({
            url: loadpayemreport,
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
                $.notify(response.report, "success");
                $("#tablerespdividemreport").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdividemreport").html('');
            }
        });
    });
    function getDaysInMonth(m, y) {
        return m === 2 ? y & 3 || !(y % 25) && y & 15 ? 28 : 29 : 30 + (m + (m >> 3) & 1);
    }
    function exportTableToCSV($table, filename) {
        var $rows = $table.find('tr:has(td),tr:has(th)'),
                // Temporary delimiter characters unlikely to be typed by keyboard
                // This is to avoid accidentally splitting the actual contents
                tmpColDelim = String.fromCharCode(11), // vertical tab character
                tmpRowDelim = String.fromCharCode(0), // null character

                // actual delimiter characters for CSV format
                colDelim = '","',
                rowDelim = '"\r\n"',
                // Grab text from table into CSV formatted string
                csv = '"' + $rows.map(function (i, row) {
                    var $row = $(row), $cols = $row.find('td,th');

                    return $cols.map(function (j, col) {
                        var $col = $(col), text = $col.text();

                        return text.replace(/"/g, '""'); // escape double quotes

                    }).get().join(tmpColDelim);

                }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',
                // Data URI
                csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
//        console.log(csv);
        if (window.navigator.msSaveBlob) { // IE 10+
            //alert('IE' + csv);
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
        } else {
            $(this).attr({'download': filename, 'href': csvData, 'target': '_blank'});
        }
    }
    $("#employeelist_excell_export").on('click', function (event) {
        var namebranch = $("#branch_startpayemreport option:selected").text();
//        var datemin = $('#employeenumberminxpayemreport').val();
//        var datemax = $('#employeenumbermaxxpayemreport').val();
//        console.log(namebranch);
        exportTableToCSV.apply(this, [$('#emreportfortnight_card'), namebranch + " EMPLOYEE LIST" + '.csv']);
    });
</script>