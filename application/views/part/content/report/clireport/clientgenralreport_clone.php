<?php
// print_array($array_data['walahdata']);
$array_dataX = $controller->pigi_employee();
// print_array($array_dataX);
// Time Recording
// Step Two
?>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>
<style>
    .theDiv {
        border: 1px solid black;
        /*overflow:hidden;*/
        /*width: 100%;*/
        /*height: 100%;*/
        /*size: landscape;*/
        /*overflow: auto;*/
    }
    /*    @media print {
            .theDiv {overflow:visible;}
        }*/
    /*    table {
                border:solid #000 !important;
                border-width:1px 0 0 1px !important;
            }*/
    /*    th, td {
                border:solid #000 !important;
                border-width:0 1px 1px 0 !important;
            }*/
    /*@media print{@page {size: landscape}}*/
</style>
<div class="panel-body" id="client_onexx">
    <div class="row">
        <label class="col-sm-1 control-label pull-left"> Employee: </label>
        <div class="col-sm-6">
            <select id="which_employee" class="form-control search-select"
                    placeholder="Select Employee" name="which_employee">
                <option value="">&nbsp;</option>
                <?php
                foreach ($array_dataX ['walahdataX'] as $value_employee) {
                    $statusuer = $value_employee ['category'];
                    $statusuer = $value_employee ['category'];
                    if ($statusuer == 'suadmin') {
                        $which = 'Super Admin';
                    }
                    if ($statusuer == 'admin') {
                        $which = 'Admin';
                    }
                    if ($statusuer == 'employee') {
                        $which = 'Employee';
                    }
                    ?>
                    <option value="<?= $value_employee['user_id'] ?>"><?= $value_employee['firstname'] . '  ' . $value_employee['lastname'] . ' | ' . $value_employee['emailaddress'] . ' : ' . $which ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <br> <br> <br>
        <div class="col-md-12 space20">
            <label class="control-label pull-left col-sm-1"> Period: </label>
            <div class="col-sm-6">
                <div id="reportrange_three" class="pull-right"
                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp; <span></span>
                    <b class="caret"> </b>
                </div>
            </div>
            <div class="btn-group pull-right" style="margin-top: -10px;">
                <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                    Export <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-light pull-right">
                    <li><a href="#" id="papapa"> Save as PDF </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="container">
        <div id='datus' class="inner second">
            <font size="3" color="green"><b>SHAH AND ASSOCIATES</b></font>
        </div>
        <div id='datusone' class="inner second">TIMESHEET FOR THE PERIOD :</div>
        <div id='datustwo' class="inner second">APRIL</div>
        <div class="table-responsive">
            <div id="my"></div>
        </div>
    </div>
    <!--    <p>
    <button onclick="$('#log').html('')">Clear</button><br>
<div id='log'></div>
</p>-->
</div>
<script>
    var loadtimesheetnow = "<?php echo base_url('timesheetcore/lestsee'); ?>";
//    var myjson;
    var mytablecontent;
    var table_colums;
    var colHeaders;
    var client_bar;
    var column_typem;
    var column_width;
    var name_employee;
    $(document).ready(function () {
        $("#datustwo").hide();
        var float_div = document.getElementById('my');
        var att = document.createAttribute("style");
        att.value = "overflow-x:auto;overflow-y:auto;";
        float_div.setAttributeNode(att);
//        document.getElementById("reportrange_three").addEventListener("click", function () {
//            alert('Hello Hello');
//        });

    });
//    function export_damclinetxx() {
//        $('#client_onexx').find('.buttons-excel').click();
//        //        document.getElementsByClassName('buttons-excel')[0].click();
//    }
    $(function () {
//        var 
        var start = moment().subtract(29, 'days');
        var end = moment();
//        alert('hello ');
        function cb(start, end) {
            $('#reportrange_three span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#reportrange_three').daterangepicker({
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
        }, function (start, end, label) {
            name_employee = $("#which_employee option:selected").text();
//            alert(name_employee);
            var client = $('#which_client').val();
            var employee = $('#which_employee').val();
//            alert(start.format('YYYY-MM-DD') + ' ' + end.format('YYYY-MM-DD'));
            $.ajax({
                url: loadtimesheetnow,
                dataType: "JSON",
                method: 'POST',
                data: jQuery.param({client_id: client, employee_id: employee, start_date: start.format('YYYY-MM-DD'), end_date: end.format('YYYY-MM-DD'), label: label}),
                "success": function (json) {
                    colHeaders = json.colHeaders;
                    table_colums = json.headertwo;
                    client_bar = json.client_bar;
                    table_columstwo = json.headertwoone;
                    mytablecontent = json.contant_table;
                    column_typem = json.headerone;
                    column_width = json.headerthree;
//                    console.log('table_colums');
//                    console.log(column_typem);
//                    console.log('table_content');
//                    console.log(mytablecontent);
//                    console.log('table_header');
//                    console.log(table_colums);
//                    $('#my').jexcel('destroy');
                }
            }).done(function (response) {
//                console.log(label);
                $("#datustwo").show();
                document.getElementById("datustwo").innerHTML = 'from <h4>' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + '</h4>';
//                $("div.second").replaceWith("<h2>" + label + "</h2>"); 
                var change = function (instance, cell, value) {
                    var cellName = $(instance).jexcel('getColumnNameFromId', $(cell).prop('id'));
                    $('#log').append('New change on cell ' + cellName + ' to: ' + value + '<br>');
                }
                $('#my').jexcel({
                    // The URL from your data file in JSON format.
                    data: mytablecontent,
                    colHeaders: colHeaders,
//                    onchange: change,
                    tableOverflow: true,
                    colWidths: column_width,
                    tableHeight: '500px',
//                    colHeaderClasses:background-color:#f46e42
//                    columns: [{"type": "hidden"}],
                    columns: column_typem
                });
//                var datax = $('#my').jexcel('getColumnData', 0);
//                console.log(datax);
//                $('bossanova-ui').attr('id', 'amamamam');
//                $('#my').jexcel('deleteColumn', 0);
                $('#my').jexcel('insertRow', client_bar, 0);
                $('#my').jexcel('insertRow', table_colums, 0);
                $('#my').jexcel('insertRow', table_columstwo, 0);
                $('#my').jexcel('updateSettings', {
                    table: function (instance, cell, col, row, val, id) {
//                        $(col).css('background-color', '#f46e42');
                        if ($(cell).text() == 'TOTAL') {
                            $('.r' + row).css('font-weight', 'bold');
                            $('.r' + row).css('color', 'black');
                        }
                        if ($(cell).text() == 'NAME OF CLIENT') {
                            $('.r' + row).css('font-weight', 'bold');
                            $('.r' + row).css('color', 'black');
                        }
                    }
                    ,
                    cells: function (cell, col, row) {
                        // If the column is number 4 or 5
                        if (row === 1 || row === 0 || col === 0 || row === 2) {
                            $(cell).addClass('readonly');
                        }
                        if ($(cell).text() == 'TOTAL') {
                            $(cell).addClass('readonly');
                        }
                    }
                });
            });

        });
        $('#papapa').click(function () {
            var x = document.getElementsByClassName("bossanova-ui");
            $(x).attr("id", "jajamma");
            $(x).attr("class", "theDiv");
            $('#my').removeAttr('style');
            $("th,td").css({"border": "solid #000", "border-width": "0 1px 1px 0"});
            printJS({printable: 'container', type: 'html', header: name_employee, maxWidth: '1000', showModal: true, honorMarginPadding: false, targetStyle: ['clear', 'display', 'width', 'min-width', 'height', 'min-height', 'max-height'], targetStyle: ['clear', 'display', 'width', 'min-width', 'height', 'min-height', 'max-height'], targetStyles: ['*']});
            sessionStorage.setItem("papajaja", "true");
        });
    });
</script>