<div class="panel-body">
    <form class="form-horizontal" role="form" method="post" name="att_card_formx_ott" id="att_card_formx_ott" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_start_dailyott" name="branch_start_dailyott" class="form-control search-select" onChange="selectuserbranchdott();">
                    <option value="">--SELECT BRANCH --</option>
                    <?php
                    foreach ($allbranches as $value) {
                        ?>
                        <option value="<?= $value['readerserial'] . '$' . $value['names'] . '$' . $value['userpin'] ?>"><?= $value['branchname'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <label class="col-sm-1 control-label"> Payroll Cat </label>
            <div class="col-sm-5">
                <select id="id_payrollcat" name="id_payrollcat" class="form-control search-select">
                    <option value="">--SELECT PAYROLL CAT --</option>
                    <?php
                    foreach ($payroll_categroy as $value) {
                        ?>
                        <option value="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Day Daily </label>
            <input id="serialnumberidott" id="serialnumberidott" type="hidden">
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_mincardx_dott">
                    <input type="text" id="date_mincardxidott" name="date_mincardx_dott" class="form-control" required> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_maxncardx_ot">
                    <input type="text" class="form-control" id="date_maxncardx_otp" name="date_maxncardx_ot" required> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <!--        <div class="form-group">
                    <label class="col-sm-2 control-label"> From Employee </label>
                    <div class="col-sm-4">
                        <select id="employeenumberminx_dott" name="employeenumberminx_dott"
                                class="form-control search-select" required>
                                                                <option value="">--EMPLOYEE RANGE START --</option> 
                        </select>
                    </div>
                    <label class="col-sm-1 control-label"> To </label>
                    <div class="col-sm-5">
                        <select id="employeenumbermaxx_dott" name="employeenumbermaxx_dott"
                                class="form-control search-select">
                            <option value="">--EMPLOYEE RANGE END--</option>
                        </select>
                    </div>
                </div>-->
        <div class="form-group">
            <label class="col-sm-2 checkbox-inline"></label> <label class="col-sm-2 checkbox-inline"> <input type="checkbox" class="red" value="1" id="id_showdetailedot" name="id_showdetailedot"> Show Detailed Report
            </label>
            <button class="btn btn-azure btn-sm" type="submit">
                Show&nbsp;<i class="fa fa-plus"></i>
            </button>
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-sm btn-green dropdown-toggle">
                    Actions <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-light pull-right">
                    <li><a href="#" id="exportpdf" onclick="printJS({printable: 'employee_attendence_cardtestot', type: 'html', maxWidth: '1000', showModal: true, honorMarginPadding: false, targetStyles: ['*']})">
                            Save as PDF </a></li>
                    <li><a href="#" id="exportcsv">
                            Save as Excel </a></li>
                </ul>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <span class="input-icon"> <input type="text" placeholder="Search  Employee Card" size="41" class="input-sm form-control" style="background-color: gold;" id="searchtablereport_id"> <i class="fa fa-search"></i>
                </span>
            </div>
            <div class="col-sm-12" id="lastupdateupdate_d">
            </div>
        </div>
        <div class="form-group" id="tablerespdivid_dottable"></div>
        <style>
            @media print {

                .footer,
                #non-printable {
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
    var loadovertimeport = "<?php echo base_url("daily/loadovertimeport"); ?>";

    function selectuserbranchdott() {
        var e = document.getElementById("branch_start_dailyott");
        $('#employeenumberminx_dott').find('option:not(:first)').remove();
        $('#employeenumbermaxx_dott').find('option:not(:first)').remove();
        //         $('#employeenumberminx_dott').get(0).selectedIndex = 0;

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
        var name = fields[0];
        document.getElementById('serialnumberidott').value = name;
        mile_stones = fields[1];
        //         mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
        //         milearrays_on1=mile_stones1.split('@');
        milearrays_on2 = mile_stones2.split('@');
        //         console.log(mile_stones2);
        var $dropdown = $("#employeenumberminx_dott");
        var $dropdown1 = $("#employeenumbermaxx_dott");
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
            return yyyy + "-" + mm + "-" + dd + "";
        }
        if (sMode == "dd/mm/yyyy") {
            return dd + "/" + mm + "/" + yyyy;
        }
    }
    //End Date Affair
    $(document).ready(function() {
        //     	selectuserbranchdott();
        $("#employeenumberminx_dott").val($("#employeenumberminx_dott option:first").val());
        $("#employeenumbermaxx_dott").val($("#employeenumbermaxx_dott option:first").val());
        var date = new Date(),
            y = date.getFullYear(),
            m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardxidott').val(dateone);
        $('#date_maxncardx_otp').val(datetwo);
        $('#date_maxncardx_ot')
            .datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#att_card_formx_ott').formValidation('revalidateField', 'date_maxncardx_ot');
            });
        $('#date_mincardxidott')
            .datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#att_card_formx_ott').formValidation('revalidateField', 'date_mincardxidott');
            });
        // console.log(date);s
    });
    $("#att_card_formx_ott").formValidation({
        framework: 'bootstrap',
        icon: {
            //            valid: 'glyphicon glyphicon-ok',
            //            invalid: 'glyphicon glyphicon-remove',
            //            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            //            departmentstartx: {
            //                validators: {
            //                    notEmpty: {
            //                        message: 'From Department is required'
            //                    }
            //                }
            //            },
            //            departmentendx: {
            //                validators: {
            //                    notEmpty: {
            //                        message: 'To Department is required'
            //                    }
            //                }
            //            },
            branch_start_dailyott: {
                validators: {
                    notEmpty: {
                        message: 'Branch is required'
                    }
                }
            },
            date_mincardx_dott: {
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
            date_maxncardx_ot: {
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
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        $.ajax({
            url: loadovertimeport,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
            //                url: url_addemployee,
            //                method: 'post',
            //                dataType: "JSON",
            //                data: $form.serialize()
        }).done(function(response) {
            //            console.log(response);
            if (response.status === 1) {
                $.notify(response.report, "success");
                $("#tablerespdivid_dottable").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdivid_dottable").html('');
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
            csv = '"' + $rows.map(function(i, row) {
                var $row = $(row),
                    $cols = $row.find('td,th');

                return $cols.map(function(j, col) {
                    var $col = $(col),
                        text = $col.text();

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
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {
                type: "text/plain;charset=utf-8;"
            }), "csvname.csv")
        } else {
            $(this).attr({
                'download': filename,
                'href': csvData,
                'target': '_blank'
            });
        }
    }
    $("#exportcsv").on('click', function(event) {
        var namebranch = $("#branch_start_dailyott option:selected").text();
        var dateabsent = $('#date_mincardxidott').val();
        exportTableToCSV.apply(this, [$('#employee_attendence_cardtestot'), namebranch + dateabsent + '.csv']);
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
</script>