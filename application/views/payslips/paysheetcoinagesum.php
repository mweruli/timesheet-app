<style>
    /*    table { 
            color: #333;
            font-family: Helvetica, Arial, sans-serif;
            width: 640px; 
            border-collapse: collapse; 
            border-spacing: 0; 
        }*/
    /* Cells in even rows (2,4,6...) are one color */ 
    tr:nth-child(even) td { background: #F1F1F1; }
    /* Cells in odd rows (1,3,5...) are another (excludes header cells)  */ 
    tr:nth-child(odd) td { background: #FEFEFE; }
    table, tr, td, th, tbody, thead, tfoot {
        page-break-inside: avoid !important;
    }
</style>
<div class="panel-body">
    <form class="form-horizontal" role="form" method="post"
          name="payslip_formsumcoinage" id="payslip_formsumcoinage" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_startpaysumcoinage" name="branch_startpaysumcoinage"
                        class="form-control search-select" onChange="selectuserbranchpaysumcoinage();">
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
            <label class="col-sm-1 control-label"> Date Range </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_mincardxpaysumcoinage">
                    <input type="text" id="date_mincardx_actualidsumcoinage" name="date_mincardxpaysumcoinage"
                           class="form-control" required> <span
                           class="input-group-addon add-on"><span
                            class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_maxncardxpaysumcoinage">
                    <input type="text" class="form-control"
                           id="date_maxncardxpaysum_actualidpaycoinage" name="date_maxncardxpaysumcoinage"> <span
                           class="input-group-addon add-on"><span
                            class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"> From Employee </label>
            <div class="col-sm-4">
                <select id="employeenumberminxpaysumcoinage" name="employeenumberminxpaysumcoinage"
                        class="form-control search-select" required>
                    <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                </select>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5">
                <select id="employeenumbermaxxpaysumcoinage" name="employeenumbermaxxpaysumcoinage"
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
                <select  class="form-control search-select"style="pull" placeholder="Select Form" name="employmenttype_idsumcoinage" id="employmenttype_idsumcoinage"  >
                    <option value="">-SELECT Employment Type-</option>
                    <?php
                    foreach ($controller->allselectablebytable('employementtypes') as $emptyp) {
                        ?>
                        <option  value="<?= $emptyp['id'] ?>"><?= $emptyp['employementtype'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <label class="col-sm-2 control-label">
            </label>
            <div class="col-sm-4 pull-right">
                <div class="btn-group">
                    <button data-toggle="dropdown"
                            class="btn btn-sm btn-green dropdown-toggle">
                        Actions <i class="fa fa-angle-down"></i>
                    </button>&nbsp;
                    <ul class="dropdown-menu dropdown-light">
                        <li><a href="#" id="exportpdf"
                               onclick="printJS({printable: 'payslipcardnssf', type: 'html', maxWidth: '1000', showModal: true, repeatTableHeader: true, honorMarginPadding: false, targetStyles: ['*']})">
                                Save as PDF 
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="btn btn-azure btn-sm" type="submit">
                    Show&nbsp;<i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group" id="tablerespdividpayslipsumnssf"></div>
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
    var loadpaysliptsumcoinage = "<?php echo base_url("rfortnight/coinagereportsum"); ?>";
    function selectuserbranchpaysumcoinage() {
        var e = document.getElementById("branch_startpaysumcoinage");
        $('#employeenumberminxpaysumcoinage').find('option:not(:first)').remove();
        $('#employeenumbermaxxpaysumcoinage').find('option:not(:first)').remove();
//         $('#employeenumberminxpaysumcoinage').get(0).selectedIndex = 0;
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
        var $dropdown = $("#employeenumberminxpaysumcoinage");
        var $dropdown1 = $("#employeenumbermaxxpaysumcoinage");
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
//     	selectuserbranchpaysumcoinage();
        $("#employeenumberminxpaysumcoinage").val($("#employeenumberminxpaysumcoinage option:first").val());
        $("#employeenumbermaxxpaysumcoinage").val($("#employeenumbermaxxpaysumcoinage option:first").val());
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardx_actualidsumcoinage').val(dateone);
        $('#date_maxncardxpaysum_actualidpaycoinage').val(datetwo);
// console.log(date);
        $('#date_mincardxpaysumcoinage')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#payslip_formsumcoinage').formValidation('revalidateField', 'date_mincardxpaysumcoinage');
        });
        $('#date_maxncardxpaysumcoinage')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#payslip_formsumcoinage').formValidation('revalidateField', 'date_maxncardxpaysumcoinage');
        });
    });
    $("#payslip_formsumcoinage").formValidation({
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
            employeenumberminxpaysumcoinage: {
                validators: {
                    notEmpty: {
                        message: 'From Employee is required'
                    }
                }
            },
            employmenttype_idsumcoinage: {
                validators: {
                    notEmpty: {
                        message: 'To Employee Type is required'
                    }
                }
            },
            date_mincardxpaysumcoinage: {
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
            date_maxncardxpaysumcoinage: {
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
            url: loadpaysliptsumcoinage,
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
            if (response.status === 1) {
                $.notify(response.report, "success");
                $("#tablerespdividpayslipsumnssf").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdividpayslipsumnssf").html('');
            }
        });
    });
    function getDaysInMonth(m, y) {
        return m === 2 ? y & 3 || !(y % 25) && y & 15 ? 28 : 29 : 30 + (m + (m >> 3) & 1);
    }
</script>