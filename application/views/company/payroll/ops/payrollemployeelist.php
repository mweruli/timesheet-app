<div class="panel-body ">
    <div id="wrap panel-white col-sm-12">
        <form id="payrollform" method="POST" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label class="col-sm-1 control-label"> Branch </label>
                <div class="col-sm-5">
                    <select id="branchuserpayroll" name="branchuserpayroll"
                            class="form-control search-select" >
                        <option value="">--SELECT BRANCH --</option>
                        <?php
                        foreach ($controller->allselectablebytable('util_branch_reader') as $value) {
                            ?>
                            <option
                                value="<?= $value['readerserial'] ?>"><?= $value['branchname'] ?></option>
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
        <div id="tablecontentemployeepayroll">
        </div>
        <!-- Paginator control -->
        <div id="paginatoremployeepayroll" class="paginator"></div>
    </div>
</div>
<style>
    #peruser{ 
        display:none;
    }
</style>
<script>
    $(document).ready(function () {
        $("#branchuserpayroll").click(function () {
            var tableid = document.getElementById("branchuserpayroll");
            var tablevalue = tableid.options[tableid.selectedIndex].value;
            datagrid = new DatabaseGrid(tablevalue, "tablecontentemployeepayroll", 'paginatoremployeepayroll');
            $("#filter").keyup(function () {
                datagrid.editableGrid.filter($(this).val());
            });
        });
    });
</script>

