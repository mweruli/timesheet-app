<div class="panel-body">
    <form class="form-horizontal" role="form" method="post" name="att_card_absent_d" id="att_card_absent_d" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_absent_daily" name="branch_absent_daily" class="form-control search-select" onChange="selectuserbranchdabsent();">
                    <option value="">--SELECT BRANCH--</option>
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
            <label class="col-sm-1 control-label"> Date Range </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_mincardx_absent">
                    <input type="text" id="date_mincardx_absentp" name="date_mincardx_absent" class="form-control" required> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_maxncardx_absent">
                    <input type="text" class="form-control" id="date_maxncardx_absentp" name="date_maxncardx_absent" required> <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 checkbox-inline"></label> <label class="col-sm-2 checkbox-inline"> <input type="checkbox" class="red" value="1" id="id_showdetailed" name="id_showdetailed"> Show Detailed Report
            </label>
            <button class="btn btn-azure btn-sm" type="submit">
                Show&nbsp;<i class="fa fa-plus"></i>
            </button>
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-sm btn-green dropdown-toggle">
                    Actions <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-light pull-right">
                    <li><a href="#" id="exportpdf" onclick="printJS({printable: 'employee_absence_cardtest_d', type: 'html', maxWidth: '1000', showModal: true, honorMarginPadding: false, targetStyles: ['*']})">
                            Save as PDF </a></li>
                    <li><a href="#" id="exportcsvabsence">
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
        <div class="form-group" id="tablerespdivid_dabsent"></div>
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
    var loadabsentreport = "<?php echo base_url("daily/loadabsentreport"); ?>";

    function selectuserbranchdabsent() {
        var e = document.getElementById("branch_absent_daily");
        var strUser = "";
        strUser = e.options[e.selectedIndex].value;
        //alert(strUser);
        fields = strUser.split('$');
        var name = fields[0];
        document.getElementById('serialnumberid').value = name;
        //         console.log(mile_stones2);
        //alert(milearrays_on[0]);

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
        var date = new Date(),
            y = date.getFullYear(),
            m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardx_absentp').val(dateone);
        $('#date_maxncardx_absentp').val(datetwo);
        // console.log(date);
        $('#date_mincardx_absent')
            .datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#att_card_absent_d').formValidation('revalidateField', 'date_mincardx_absent');
            });
        $('#date_maxncardx_absent')
            .datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function(e) {
                // Revalidate the date field
                $('#att_card_absent_d').formValidation('revalidateField', 'date_maxncardx_absent');
            });
    });
    $("#att_card_absent_d").formValidation({
        framework: 'bootstrap',
        icon: {
            //            valid: 'glyphicon glyphicon-ok',
            //            invalid: 'glyphicon glyphicon-remove',
            //            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            branch_absent_daily: {
                validators: {
                    notEmpty: {
                        message: 'Branch is required'
                    }
                }
            },
            date_mincardx_absent: {
                validators: {
                    notEmpty: {
                        message: 'Min Date is required'
                    }
                }
            },
            date_maxncardx_absent: {
                validators: {
                    notEmpty: {
                        message: 'Max Date is required'
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
            url: loadabsentreport,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false
        }).done(function(response) {
            // console.log(response);
            if (response.status === 1) {
                $.notify(response.report, "success");
                $("#tablerespdivid_dabsent").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdivid_dabsent").html('');
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
    $("#exportcsvabsence").on('click', function(event) {
        var namebranch = $("#branch_absent_daily option:selected").text();
        var dateabsent = $('#date_mincardx_absent').val();
        exportTableToCSV.apply(this, [$('#employee_absence_cardtest_d'), namebranch + dateabsent + '.csv']);
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
</script>