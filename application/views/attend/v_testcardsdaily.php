<div class="panel-body">
    <form class="form-horizontal" role="form" method="post" name="att_card_formx_d" id="att_card_formx_d" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_start_daily" name="branch_start_daily" class="form-control search-select" onChange="selectuserbranchd();">
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
            <input id="serialnumberid" id="serialnumberid" type="hidden">
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_mincardx_d">
                    <input type="text" id="date_mincardxid" name="date_mincardx_d" class="form-control" required> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"> From Employee </label>
            <div class="col-sm-4">
                <select id="employeenumberminx_d" name="employeenumberminx_d" class="form-control search-select" required>
                    <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                </select>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5">
                <select id="employeenumbermaxx_d" name="employeenumbermaxx_d" class="form-control search-select">
                    <option value="">--EMPLOYEE RANGE END--</option>
                </select>
            </div>
        </div>
        <div class="form-group ">
            <button class="btn btn-azure btn-sm pull-right" type="submit">
                Show&nbsp;<i class="fa fa-plus"></i>
            </button>
            <div style="float: right;">&nbsp;</div>
            <div class="btn-group pull-right">
                <button data-toggle="dropdown" class="btn btn-sm btn-green dropdown-toggle">
                    Actions <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-light pull-right">
                    <li><a href="#" id="exportpdf" onclick="printJS({printable: 'employee_attendence_cardtest_d', type: 'html', maxWidth: '1000', showModal: true, honorMarginPadding: false, targetStyles: ['*']})">
                            Save as PDF </a></li>
                    <li><a href="#" id="exportcsvdaily">
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
        <div class="form-group" id="tablerespdivid_d"></div>
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
    var loadcard_d = "<?php echo base_url("posts/loardcarddaily"); ?>";
    var checklastupdateddaily = "<?php echo base_url("aot/reportdailysum"); ?>";

    function selectuserbranchd() {
        var e = document.getElementById("branch_start_daily");
        $('#employeenumberminx_d').find('option:not(:first)').remove();
        $('#employeenumbermaxx_d').find('option:not(:first)').remove();
        //         $('#employeenumberminx_d').get(0).selectedIndex = 0;

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
        document.getElementById('serialnumberid').value = name;
        mile_stones = fields[1];
        //         mile_stones1=fields[2];
        mile_stones2 = fields[2];
        milearrays_on = mile_stones.split('@');
        //         milearrays_on1=mile_stones1.split('@');
        milearrays_on2 = mile_stones2.split('@');
        //         console.log(mile_stones2);
        var $dropdown = $("#employeenumberminx_d");
        var $dropdown1 = $("#employeenumbermaxx_d");
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
        //     	selectuserbranchd();
        $("#employeenumberminx_d").val($("#employeenumberminx_d option:first").val());
        $("#employeenumbermaxx_d").val($("#employeenumbermaxx_d option:first").val());
        var date = new Date(),
            y = date.getFullYear(),
            m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardxid').val(dateone);
        $('#date_maxncardx_actualid').val(datetwo);
        // console.log(date);
        $('#date_mincardx_d')
            .datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                //Some Ajax Reporting
                $.ajax({
                    url: checklastupdateddaily,
                    type: 'POST',
                    dataType: "JSON",
                    data: jQuery.param({
                        serialnumber: $('#serialnumberid').val(),
                        datedaily: $('#date_mincardxid').val()
                    })
                    //            processData: false,
                    //            contentType: false
                }).done(function(response) {
                    //                console.log(response);
                    document.getElementById('lastupdateupdate_d').innerHTML = "<p>" + "<font size='1' color='red'>" + response.messegeintor + "</font>" + " " + "<font size='1'>" + " TOTAL NO OF EMPLOYEES PRESENT " + "</font>" + "<font size='1' color='green'>" + response.presenttotal + "</font>" + "<font size='1' color='blue'>" + ' TOTAL NO OF EMPLOYEES ABSENT ' + "</font>" + "<font size='1' color='green'>" + response.absenttotal + "</font>" + "</p>";
                });
                $('#att_card_formx_d').formValidation('revalidateField', 'date_mincardx_d');
            });
    });
    $("#att_card_formx_d").formValidation({
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
            employeenumberminx_d: {
                validators: {
                    notEmpty: {
                        message: 'From Employee is required'
                    }
                }
            },
            //             employeenumbermaxx_d: {
            //                 validators: {
            //                     notEmpty: {
            //                         message: 'To Employee is required'
            //                     }
            //                 }
            //             },
            date_mincardx_d: {
                validators: {
                    notEmpty: {
                        message: 'From Date is required'
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
            url: loadcard_d,
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
                $("#tablerespdivid_d").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdivid_d").html('');
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
    $("#exportcsvdaily").on('click', function(event) {
        var namebranch = $("#branch_start_daily option:selected").text();
        var dateabsent = $('#date_mincardxid').val();
        //        console.log(namebranch);
        exportTableToCSV.apply(this, [$('#employee_attendence_cardtest_d'), namebranch + dateabsent + '.csv']);
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
</script>