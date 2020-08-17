<div class="panel-heading">
    <h4 class="panel-title"> <span class="text-bold">Upload XLS, CSV and XLSX</span></h4>
</div>
<div class="panel-body">
    <form id="inportdatasetting" role="form" method="post" class="form-horizontal" novalidate>
        <p class="help-block">
        </p>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="form-field-1">
                File Category
            </label>
            <?php
            $mysetting = $controller->allselectablebytable("util_uploadfile");
            //            print_array($mysetting);
            ?>
            <div class="col-sm-4">
                <select class="form-control search-select" placeholder="Select Form" name="filetype" id="filetype">
                    <option value="">--SELECT DATA TYPE--</option>
                    <?php
                    foreach ($mysetting as $filetype) {
                        ?>
                        <option value="<?= $filetype['id'] ?>"><?= $filetype['filetype'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <label class="col-sm-2 control-label" for="form-field-1">
                Upload File
            </label>

            <div class="col-sm-2">
                <div data-provides="fileupload" class="fileupload fileupload-new">
                    <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
                        <input type="file" id="fileloadern" name="fileloader">
                    </span>
                    <span class="fileupload-preview"></span>
                    <a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">
                        &times;
                    </a>
                </div>

            </div>
            <div class="col-sm-2">
                <input type="submit" name="submit" class="btn btn-sm btn-danger submitBtn" value="Update" />
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#inportdatasetting')
            .formValidation({
                framework: 'bootstrap',
                icon: {},
                fields: {
                    filetype: {
                        enabled: true,
                        validators: {
                            notEmpty: {
                                message: 'Data Type Is Required'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function(e) {
                postformdatajax("#inportdatasetting", 'submit', '<?= base_url('importer/updatepersonbiodata') ?>', '.help-block');
                //            validateinputtype("#file", '.help-block', '<span style="font-size:18px;color:#EA4335">Select a valid file (JPEG/JPG/PNG).</span>', "image/jpeg", "image/png", "image/jpg");
            });
    });

    function postformdatajax(formid, actioncalling, url, message) {
        $(formid).on(actioncalling, function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                dataType: "JSON",
                url: url,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.submitBtn').attr("disabled", "disabled");
                    $(formid).css("opacity", ".5");
                },
                success: function(msg) {
                    //                    console.log(msg);
                    $(message).html('');
                    if (msg.state === 'ok') {
                        $(formid)[0].reset();
                        $(message).html('<span style="font-size:18px;color:#42FF33">' + msg.message + '</span>');
                    } else {
                        $(message).html('<span style="font-size:18px;color:#EA4335">' + msg.message + '</span>');
                    }
                    $(formid).css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        });
    }
</script>