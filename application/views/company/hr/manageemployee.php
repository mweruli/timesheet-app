<div class="panel-body ">
    <div id="wrap panel-white col-sm-12">
        <form id="useridform" method="POST" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label class="col-sm-1 control-label"> Branch </label>
                <div class="col-sm-5">
                    <select id="branchuser" name="branchuser"
                            class="form-control search-select" >
                        <option value="">--SELECT BRANCH --</option>
                        <?php
                        foreach ($controller->allselectablebytable('util_branch_reader') as $value) {
                            ?>
                            <option
                                value="<?= $value['id'] ?>"><?= $value['branchname'] ?></option>
                                <?php
                            }
                            ?>
                    </select>
                </div>
                <label class="col-sm-1 control-label"> </label>
                <div id="toolbar" class="col-sm-5 pull-right">
                    <input type="text" id="filter" name="filter" placeholder="Filter :type any text here" class="form-control" />
                </div>
            </div>
            <input id="userprofiled" type="hidden" name="userprofiled">
        </form>
        <!-- Feedback message zone -->
        <!-- Grid contents -->
        <div id="tablecontentemployee">
        </div>
        <!-- Paginator control -->
        <div id="paginatoremployeemanage" class="paginator"></div>
    </div>
</div>
<style>
    #peruser{ 
        display:none;
    }
</style>
<script>
    $(document).ready(function () {
        $("#branchuser").click(function () {
//            sessionStorage.removeItem("branch_idemployeeprofile");
            var tableid = document.getElementById("branchuser");
            var tablevalue = tableid.options[tableid.selectedIndex].text;
            var id = tableid.options[tableid.selectedIndex].value;
//            console.log(tablevalue + ' hello');
            datagrid = new DatabaseGrid(id, "tablecontentemployee", 'paginatoremployeemanage');
            $("#filter").keyup(function () {
                datagrid.editableGrid.filter($(this).val());
                // To filter on some columns, you can set an array of column index 
                //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);        
            });
//            sessionStorage.setItem("branch_idemployeeprofile", id);
        });
    });
//    var branch_idemployeeprofile = sessionStorage.getItem("branch_idemployeeprofile");
//    if (branch_idemployeeprofile) {
//        $("#branchuser").val(branch_idemployeeprofile);
//        var tableid = document.getElementById("branchuser");
//        var tablevalue = tableid.options[tableid.selectedIndex].text;
//    }

</script>

