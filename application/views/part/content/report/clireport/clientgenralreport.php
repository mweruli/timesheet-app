<link rel="stylesheet"
      href="<?= base_url() ?>assets/edittable/css/style.css" type="text/css"
      media="screen">
<link rel="stylesheet"
      href="<?= base_url() ?>assets/edittable/css/responsive.css"
      type="text/css" media="screen">
<link rel="stylesheet"
      href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet"
      href="<?= base_url() ?>assets/edittable/css/font-awesome-4.7.0/css/font-awesome.min.css"
      type="text/css" media="screen">
<div class="panel-heading">
    <h4 class="panel-title">
        <span class="text-bold">Timesheet</span>
    </h4>
</div>
<div class="panel-body">
    <div id="message"></div>
    <div id="wrap">
        <!-- Feedback message zone -->
        <div id="toolbar">
            <input type="text" id="filter" name="filter"
                   placeholder="Filter :type any text here" /> <a
                   id="showaddformbutton" class="button green"><i class="fa fa-plus"></i>Add
                New</a>
        </div>
        <!-- Grid contents -->
        <div id="tablecontent"></div>

        <!-- Paginator control -->
        <div id="paginator"></div>
    </div>
</div>
<div id="addform">
    <div class="row">
        <div class="col-sm-12">
            <select id="client" class="form-control search-select" name="client"
                    placeholder="Select Client">
                <option value="">&nbsp;</option>
                <?php
                foreach ($all_clients as $value) {
                    ?>
                    <option value="<?= $value['id']; ?>"><?= $value['clientname'] . "  " . $value['client_number'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <select id="user_task" class="form-control search-select"
                    name="user_task" placeholder="Select Task">
                <option value="">&nbsp;</option>
                <?php
                foreach ($task as $value) {
                    ?>
                    <option value="<?= $value['id']; ?>"><?= $value['name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row tright">
        <a id="addbutton" class="button green"><i class="fa fa-save"></i>
            Apply</a> <a id="cancelbutton" class="button delete">Cancel</a>
    </div>
</div>
<?php $this->load->view('viewjs/demo', TRUE); ?>
<script>
    $(document).ready(function () {
        datagrid = new DatabaseGrid();
        // key typed in the filter field
        $("#filter").keyup(function () {
            datagrid.editableGrid.filter($(this).val());
            // To filter on some columns, you can set an array of column index 
            //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
        });
        $("#showaddformbutton").click(function () {
            showAddForm();
        });
        $("#cancelbutton").click(function () {
            showAddForm();
        });
        $("#addbutton").click(function () {
            datagrid.addRow();
        });
    });
</script>


