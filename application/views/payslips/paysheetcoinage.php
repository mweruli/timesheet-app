<div class="panel-body">
    <form class="form-horizontal" role="form" method="post"
          name="payscoinage_form" id="payscoinage_form" novalidate>
        <div class="form-group">
            <label class="col-sm-1 control-label"> Branch </label>
            <div class="col-sm-5">
                <select id="branch_startpaycoinage" name="branch_startpaycoinage"
                        class="form-control search-select" onChange="selectuserbranchpaycoinage();">
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
                <div class="input-group input-append date" id="date_mincardxpaycoinage">
                    <input type="text" id="date_mincardxpaycoinagep" name="date_mincardxpaycoinage"
                           class="form-control" required> <span
                           class="input-group-addon add-on"><span
                            class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5 date">
                <div class="input-group input-append date" id="date_maxncardxpaycoinage">
                    <input type="text" class="form-control"
                           id="date_maxncardxpaycoinagep" name="date_maxncardxpaycoinage"> <span
                           class="input-group-addon add-on"><span
                            class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"> From Employee </label>
            <div class="col-sm-4">
                <select id="employeenumberminxpaycoinage" name="employeenumberminxpaycoinage"
                        class="form-control search-select" required>
                    <!-- 					<option value="">--EMPLOYEE RANGE START --</option> -->
                </select>
            </div>
            <label class="col-sm-1 control-label"> To </label>
            <div class="col-sm-5">
                <select id="employeenumbermaxxpaycoinage" name="employeenumbermaxxpaycoinage"
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
                               onclick="printJS({printable: 'coinagefortnight_card', type: 'html', maxWidth: '1000', showModal: true, repeatTableHeader: true, honorMarginPadding: false, targetStyles: ['*']})">
                                Save as PDF </a></li>
                    </ul>
                </div>
                <button class="btn btn-azure btn-sm" type="submit">
                    Show&nbsp;<i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <span class="input-icon"><input type="text"
                                                placeholder="Search  Pay Slip" size="41"
                                                class="input-sm form-control" style="background-color: gold;"
                                                id="searchtablereport_idpay"> <i class="fa fa-search"></i>
                </span>
            </div>
        </div>
        <div class="form-group" id="tablerespdividcoinage"></div>
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
    var loadpaycoinage = "<?php echo base_url("rfortnight/coinagereport"); ?>";
    function selectuserbranchpaycoinage() {
        var e = document.getElementById("branch_startpaycoinage");
        $('#employeenumberminxpaycoinage').find('option:not(:first)').remove();
        $('#employeenumbermaxxpaycoinage').find('option:not(:first)').remove();
//         $('#employeenumberminxpaycoinage').get(0).selectedIndex = 0;
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
        var $dropdown = $("#employeenumberminxpaycoinage");
        var $dropdown1 = $("#employeenumbermaxxpaycoinage");
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
//     	selectuserbranchpaycoinage();
        $("#employeenumberminxpaycoinage").val($("#employeenumberminxpaycoinage option:first").val());
        $("#employeenumbermaxxpaycoinage").val($("#employeenumbermaxxpaycoinage option:first").val());
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        var dateone = formatDate(firstDay, 'yyyy-mm-dd');
        var datetwo = formatDate(lastDay, 'yyyy-mm-dd');
        $('#date_mincardxpaycoinagep').val(dateone);
        $('#date_maxncardxpaycoinagep').val(datetwo);
// console.log(date);
        $('#date_mincardxpaycoinage')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#payscoinage_form').formValidation('revalidateField', 'date_mincardxpaycoinage');
        });
        $('#date_maxncardxpaycoinage')
                .datepicker({
                    format: 'yyyy-mm-dd'
                }).on('changeDate', function (e) {
            // Revalidate the date field
            $('#payscoinage_form').formValidation('revalidateField', 'date_maxncardxpaycoinage');
        });
    });
    $("#payscoinage_form").formValidation({
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
            employeenumberminxpaycoinage: {
                validators: {
                    notEmpty: {
                        message: 'From Employee is required'
                    }
                }
            },
            employmenttype_id: {
                validators: {
                    notEmpty: {
                        message: 'To Employee Type is required'
                    }
                }
            },
            date_mincardxpaycoinage: {
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
            date_maxncardxpaycoinage: {
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
            url: loadpaycoinage,
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
                $("#tablerespdividcoinage").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#tablerespdividcoinage").html('');
            }
        });
    });
    function getDaysInMonth(m, y) {
        return m === 2 ? y & 3 || !(y % 25) && y & 15 ? 28 : 29 : 30 + (m + (m >> 3) & 1);
    }
</script>