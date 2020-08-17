<?php
$tabels = $controller->getmealltables();
?>
<div class="panel-heading">
    <h4 class="panel-title"> <span class="text-bold">Configure Forms</span></h4>
</div>
<div class="panel-body">
    <div class="form-group">
        <label class="col-sm-2 control-label" for="form-field-1">
            Forms
        </label>
        <div class="col-sm-9">
            <select  class="form-control search-select" placeholder="Select Form" name="form_to_n" id="form_to_n"  >
                <option value="">-SELECT FORM-</option>
                <?php
                foreach ($tabels as $value) {
                    ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <br><br>
    <div id="message"></div>
    <div id="wrap">
        <div id="tablecontent" class="col-sm-12"></div>
    </div>
</div>
<?php $this->load->view('viewjs/demo', TRUE); ?>
<script>
    $(document).ready(function () {
        datagrid = new DatabaseGrid();
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
        });
        $("#form_to_n").click(function () {
            var tableid = document.getElementById("form_to_n");
            var tablevalue = tableid.options[tableid.selectedIndex].value;
            datagrid.loadTablesConfig(tablevalue);
        });
    });
</script>
