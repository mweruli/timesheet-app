<div class="row">
    <div class="col-md-12">
        <!-- start: BASIC TABLE PANEL -->
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-2 pull-right">
                        <button class="btn btn-azure btn-sm" type="submit">
                            Show&nbsp;<i class="fa fa-plus"></i>
                        </button>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-sm btn-green dropdown-toggle">
                                Actions <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-light pull-right">
                                <li><a href="#" id="exportpdf" onclick="demoFromHTML()">
                                        Save as PDF </a></li>
                                <li><a href="#" id="attendence_excell_export">
                                        Save as Excel </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-hover" id="testexcell_id">
                    <thead>
                        <tr>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                            <th class="center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="center">Working. Dept :</td>
                            <td class="center">UNALLOCATED</td>
                            <td>Branch Name :</td>
                            <td>HQ LUSAKA</td>
                            <td class="center">Shifts Def</td>
                            <td class="center">1</td>
                            <td class="center">08:00 - 17:00</td>
                            <td class="center"></td>
                            <td class="center">
                            </td>
                            <td class="center"></td>
                            <td class="center"></td>
                        </tr>
                        <tr>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                        </tr>
                        <tr>
                            <td class=""><b>EMPCODE : 678</b></td>
                            <td class=""><b>PIN:26561152</b></td>
                            <td><b>SIMON SIMIYU</b></td>
                            <td></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center">
                            </td>
                            <td class="center"></td>
                            <td class="center"></td>
                        </tr>
                        <tr>
                            <td class=""><b>Day</b></td>
                            <td class=""><b>Date</b></td>
                            <td><b>Week</b></td>
                            <td><b>Off</b></td>
                            <td class=""><b>Shift</b></td>
                            <td class=""><b>Login</b></td>
                            <td class=""><b>Logout</b></td>
                            <td class=""><b>Normal</b></td>
                            <td class=""><b>Tot Hrs</b></td>
                            <td class=""><b>Lost T</b></td>
                            <td class=""><b>Mode</b></td>
                        </tr>
                        <?php
                        for ($x = 0; $x <= 30; $x++) {
                            ?>
                            <tr>
                                <td class="">Sat</td>
                                <td class="">9/21/2019</td>
                                <td class="">38</td>
                                <td class="">1</td>
                                <td class="">1</td>
                                <td class="">ABSENT</td>
                                <td class="">17:28</td>
                                <td class="">7:45</td>
                                <td class="">0:00</td>
                                <td class="">8:00</td>
                                <td class="">n</td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""><b>Total Offs</b></td>
                            <td class=""></td>
                            <td class=""><b>Days Worked</b></td>
                            <td class=""><b>Days Absent</b></td>
                            <td class=""><b>Total</b></td>
                            <td class=""><b>Tot Hrs</b></td>
                            <td class=""><b>Lost T</b></td>
                            <td class=""></td>
                        </tr>
                        <tr>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""><b>4</b></td>
                            <td class=""></td>
                            <td class=""><b>11</b></td>
                            <td class=""><b>9</b></td>
                            <td class=""><b>144</b></td>
                            <td class=""><b>83:25</b></td>
                            <td class=""><b>9:46</b></td>
                            <td class=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $("#attendence_excell_export").on('click', function(event) {
        var namebranch = 'One';
        var datemin = "Two";
        var datemax = "Three";
        //        console.log(namebranch);
        exportTableToCSV.apply(this, [$('#testexcell_id'), namebranch + datemin + "TO" + datemax + '.csv']);
    });

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
</script>