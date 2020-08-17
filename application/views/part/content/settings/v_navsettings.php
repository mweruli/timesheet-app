<div class="panel-heading">
    <h4 class="panel-title"> <span class="text-bold">Nav  Section</span></h4>
</div>
<div class="panel-body">
    <form id="navsettingoption" role="form" method="post" class="form-horizontal" novalidate>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="form-field-1">
                Nav Options
            </label>
            <?php
            $id = $this->session->userdata('logged_in')['user_id'];
            $mysetting = $controller->selectafromonewhere("util_navsettings", 'userid', $id);
//            print_array($mysetting);
            ?>
            <div class="col-sm-9">
                <select  class="form-control search-select" placeholder="Select Form" name="form_to_nav" id="form_to_nav">
                    <?php
                    if (empty($mysetting)) {
                        $mysetting['navstate'] = 'none';
                        ?>
                        <option value="" selected="">-SELECT FORM-</option>
                        <?php
                    } else {
                        $mysetting = $mysetting[0];
                    }
                    ?>
                    <option value="sidebar-close" <?php if ($mysetting['navstate'] == 'sidebar-close') echo 'selected'; ?>
                            >CLOSED</option>
                    <option value="sidebar-fixed" <?php if ($mysetting['navstate'] == 'sidebar-fixed') echo 'selected'; ?>
                            >FIXED</option>
                    <option value="" <?php if ($mysetting['navstate'] == '') echo 'selected'; ?>
                            >DYNAMIC</option>
                </select>
            </div>
        </div>
    </form>
</div>
<script>
    var handlenav = "<?php echo base_url("utilcontroller/navsettings"); ?>";
    $(document).ready(function () {
        $('#form_to_nav').on('change', function () {
//            alert(this.value);
            $.ajax({
                url: handlenav, //This is the current doc
                type: "POST",
                dataType: 'json', // add json datatype to get json
                data: ({navstate: this.value}),
                success: function (data) {
                    console.log(data);
                }
            });
        });
    });
</script>