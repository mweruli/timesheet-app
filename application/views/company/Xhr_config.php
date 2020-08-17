<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#myTab2_gender" data-toggle="tab"
                                      id="id_gender"> <i class="green fa fa-home">&nbsp;Gender</i>
                    </a>
                </li>
                <li><a href="#myTab2_emptype" data-toggle="tab"
                       id="emptype"> <i class="fa fa-code-fork"></i>&nbsp;Employment Types
                    </a>
                </li>
                <li><a href="#myTab2_empstatus" data-toggle="tab"
                       id="empstatus"> <i class="fa fa-share-alt"></i>&nbsp;Employment Status
                    </a>
                </li>
                <li><a href="#myTab2_jobgrades" data-toggle="tab"
                       id="jobgrades"> <i class="fa fa-building"></i>&nbsp;Job Grades
                    </a>
                </li>
                <li><a href="#myTab2_jobgroup" data-toggle="tab"
                       id="jobgroup"> <i class="fa fa-building-o"></i>&nbsp;Job Group
                    </a>
                </li>
                <li><a href="#myTab2_jobtitle" data-toggle="tab"
                       id="jobtitle"> <i class="fa  fa-bars"></i>&nbsp;Job Title
                    </a>
                </li>
                <li><a href="#myTab2_salutation" data-toggle="tab"
                       id="salutation"> <i class="fa  fa-bars"></i>&nbsp;Salutation
                    </a>
                </li>
                <li><a href="#myTab2_nationality" data-toggle="tab"
                       id="nationality"> <i class="fa  fa-bars"></i>&nbsp;Nationality
                    </a>
                </li>
                <li>
                    <a href="#myTab2_designation" data-toggle="tab"
                       id="designation"> <i class="fa  fa-bars"></i>&nbsp;Designation
                    </a>
                </li>
                <li><a href="#myTab2_mariatalstatus" data-toggle="tab"
                       id="mariatalstatus"> <i class="fa  fa-bars"></i>&nbsp;Marital Status
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_gender">
                    <?php echo $this->load->view('company/hrsecs/gender', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_emptype">
                    <?php echo $this->load->view('company/hrsecs/emptype', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_empstatus">
                    <?php echo $this->load->view('company/hrsecs/empstate', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_jobgrades">
                    <?php echo $this->load->view('company/hrsecs/jobgrades', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_jobgroup">
                    <?php echo $this->load->view('company/hrsecs/jobgroup', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_jobtitle">
                    <?php echo $this->load->view('company/hrsecs/jobtitle', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_salutation">
                    <?php echo $this->load->view('company/hrsecs/salutation', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_nationality">
                    <?php echo $this->load->view('company/hrsecs/nationality', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_designation">
                    <?php echo $this->load->view('company/hrsecs/designation', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_mariatalstatus">
                    <?php echo $this->load->view('company/hrsecs/maritalstatus', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('viewjs/hrconfig', TRUE); ?>
<script>
//    $('#id_gender').click(function () {
//        datagrid = new DatabaseGrid('genders', "tablecontentgenders");
//        $("#filter").keyup(function () {
//            datagrid.editableGrid.filter($(this).val());
//            // To filter on some columns, you can set an array of column index 
//            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
//        });
//    });
    $('#jobgrades').click(function () {
        datagrid = new DatabaseGrid('jobgrades', "tablecontentjobgrades");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#jobgroup').click(function () {
        datagrid = new DatabaseGrid('jobgroups', "tablecontentjobgroups");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#mariatalstatus').click(function () {
        datagrid = new DatabaseGrid('maritalstatus', "tablecontentmaritalstatus");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#emptype').click(function () {
        datagrid = new DatabaseGrid('employementtypes', "tablecontentemployementtypes");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#empstatus').click(function () {
        datagrid = new DatabaseGrid('employementstatus', "tablecontentemployementstatus");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#jobtitle').click(function () {
        datagrid = new DatabaseGrid('jobtitles', "tablecontentjobtitles");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#salutation').click(function () {
        datagrid = new DatabaseGrid('salutations', "tablecontentsalutations");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#nationality').click(function () {
        datagrid = new DatabaseGrid('nationalities', "tablecontentnationalities");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
    $('#designation').click(function () {
        datagrid = new DatabaseGrid('designations', " tablecontentdesignation");
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
        });
    });
</script>
