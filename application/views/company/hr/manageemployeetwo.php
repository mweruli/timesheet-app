<div class="panel-body ">
    <div id="wrap panel-white col-sm-12">
        <form id="useridform" method="POST" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label class="col-sm-1 control-label"> Branch </label>
                <div class="col-sm-5">
                    <select id="branchusertwo" name="branchusertwo"
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
                    <input type="text" id="filtertwo" name="filtertwo" placeholder="Filter :type any text here" class="form-control" />
                </div>
            </div>
            <input id="userprofiledtwo" type="hidden" name="userprofiledtwo">
        </form>
        <!-- Feedback message zone -->
        <!-- Grid contents -->
        <div id="tablecontentemployeetwo">
        </div>
        <!-- Paginator control -->
        <div id="paginatoremployeemanagetwo" class="paginator"></div>
    </div>
</div>
<style>
    #peruser{ 
        display:none;
    }
</style>
<script>
    $(document).ready(function () {
        $("#branchusertwo").click(function () {
//            sessionStorage.removeItem("branch_idemployeeprofile");
            var tableid = document.getElementById("branchusertwo");
            var tablevalue = tableid.options[tableid.selectedIndex].text;
            var id = tableid.options[tableid.selectedIndex].value;
//            console.log(tablevalue + ' hello');
            datagrid = new DatabaseGrid(id, "tablecontentemployeetwo", 'paginatoremployeemanagetwo');
            $("#filtertwo").keyup(function () {
                datagrid.editableGrid.filter($(this).val());
            });
        });
    });

</script>

