<div class="panel-body" id="client_one">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-6">
                    <select id="client_id" class="form-control search-select"
                            onChange="checkselectedclientTime();" placeholder="Select Client">
                        <option value="">--Select Client--</option>
                        <?php
                        foreach ($all_clients as $value) {
                            ?>
                            <option value="<?= $value['id']; ?>"><?= $value['clientname'] . "  " . $value['client_number'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <div class="btn-group pull-right">
                        <button data-toggle="dropdown"
                                class="btn btn-green dropdown-toggle">
                            Export <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-light pull-right">
                            <li><a href="#" id="exportpdf"
                                   onclick="printJS({printable: 'timecostbyclient', type: 'html', header: 'Time Per Client', maxWidth: '1000', honorMarginPadding: false, targetStyles: ['*']})">
                                    Save as PDF </a></li>
                            <li><a href="#" onclick="export_damclinet()"> Export to Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div id="contentcostbyclient"></div>
</div>
<script>
    var getmereportclientcost = "<?php echo base_url('ts/getreportbyclient'); ?>";
    $(document).ready(function() {
//        Main.init();
//        $('#tatamamaid').DataTable();
        var tabletwo = $('#tatamamaid').DataTable({
//            "paging": false,
//            "info": false,
            dom: 'Bfrtip',
            buttons: [
//                'copyHtml5',
                'excelHtml5',
//                'csvHtml5',
//                'pdfHtml5'
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 7
        });
        $('#client_one').append(tabletwo);
    });
    function export_damclinet() {
        $('#client_one').find('.buttons-excel').click();
//        document.getElementsByClassName('buttons-excel')[0].click();
    }
    function checkselectedclientTime() {
        var projectid = document.getElementById("client_id");
        var projectidvalue = projectid.options[projectid.selectedIndex].value;
        var projectidtext = projectid.options[projectid.selectedIndex].text;
        $.ajax({
            method: "POST",
            url: getmereportclientcost,
            dataType: "JSON",
            data: {'selectclientid': projectidvalue, 'selectclientname': projectidtext}
        }).done(function(response) {
            console.log(response);
            if (response.status === 1) {
                $.notify(response.report, "success");
                $("#contentcostbyclient").html(response.data);
            } else {
                $.notify(response.report, "error");
                $("#contentcostbyclient").html('');
            }
        });
    }
</script>