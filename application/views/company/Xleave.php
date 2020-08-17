<div class="row" >
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_leavetype" data-toggle="tab"
                                      id="id_leavetypes"> <i class="green fa fa-home">&nbsp;Leave Types</i>
                    </a>
                </li>
                <li><a href="#myTab2_holiday" data-toggle="tab" id="id_leaveholiday"
                       > <i class="fa fa-code-fork"></i>&nbsp;Holidays
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#empleaveinput"
                       id="id_employeeleaveapp">
                        <i class="fa fa-fire">&nbsp;Employee Leave Input </i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_leavetype">
                    <?php echo $this->load->view('company/leave/leavetypeadd', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_holiday">
                    <?php echo $this->load->view('company/leave/holiday', '', TRUE); ?>
                </div>
                <div id="empleaveinput" class="tab-pane padding-bottom-5 ">
                    <?php echo $this->load->view('company/leave/v_employeeleaveinput', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('viewjs/leavetype', TRUE); ?>
<script>
    $('#id_leavetypes').click(function () {
        datagrid = new DatabaseGrid('leaveconfig', "tablecontentleaveconfig");
        // key typed in the filter field
        $("#filterleaveconfig").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
        });
    });
    $('#id_leaveholiday').click(function () {
        datagrid = new DatabaseGrid('holidayconfig', "tablecontentholidayconfig");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
        $("#filterholidayconfig").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
        });
    });
    $('#id_perdepartment').click(function () {
        datagrid = new DatabaseGrid('addperdepartment', "tablecontentaddperdepartment");
        $("#tablecontentleaveapplicationsfilter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
        });
    });
</script>