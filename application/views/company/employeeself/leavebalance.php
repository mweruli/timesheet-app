<?php
$leaveapply = $controller->gettablecolumns('leaveapply');
$leaveapplyvalues = array();
?>
<div class="row" id="leaveapllyconfig">
    <div class="col-sm-12">
        <div class="panel-heading">
            <h4 class="panel-title">LEAVE <span class="text-bold"> BALANCE</span></h4>
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

            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="filteraddperemployee" name="filteraddperemployee"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentaddperemployee"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#leaveperiod span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var startdate = start.format('YYYY-MM-DD');
            var endate = end.format('YYYY-MM-DD');
            //            $('#startdate').val = startdate;
            $("#startdate").val(startdate);
            $("#enddate").val(endate);
            //            alert(startdate + ' ' + end);
        }
        $('#leaveperiod').daterangepicker({
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
        //        alert(start+' '+end);
    });
    $(document).ready(function () {});
</script>
