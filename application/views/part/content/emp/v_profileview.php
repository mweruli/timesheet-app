<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="user-left">
            <div class="center">
                <h4><?= $this->session->userdata('logged_in')['firstname'] . " " . $this->session->userdata('logged_in')['lastname']; ?></h4>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="user-image">
                        <div class="fileupload-new thumbnail">
                            <img
                                src="<?= base_url() ?>upload/<?= $this->session->userdata('logged_in')['user_image_big'] ?>"
                                alt="">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail"></div>
                        <div class="user-image-buttons">
                            <span class="btn btn-azure btn-file btn-sm"><span
                                    class="fileupload-new"><i class="fa fa-pencil"></i></span><span
                                    class="fileupload-exists"><i class="fa fa-pencil"></i></span> <input
                                    type="file"> </span> <a href="#"
                                                    class="btn fileupload-exists btn-red btn-sm"
                                                    data-dismiss="fileupload"> <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th colspan="3">General information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>User ID</td>
                        <td><a href="#">
                                <?= $this->session->userdata('logged_in')['user_id'] ?>
                            </a></td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                    <tr>
                        <td>email:</td>
                        <td><a href="">
                                <?= $this->session->userdata('logged_in')['emailaddress'] ?>
                            </a></td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                    <tr>
                        <td>phone:</td>
                        <td> <?= $this->session->userdata('logged_in')['cellphone'] ?></td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                    <tr>
                        <td>Date Hired</td>
                        <td><a href="#">
                                <?= date("F jS, Y", strtotime($this->session->userdata('logged_in')['dateemployeed'])); ?>
                            </a></td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                    <tr>
                        <td>EMPLOYMENT TYPE</td>
                        <td>
                            <?php
                            echo $utilsetting [0] ['design'];
                            ?>
                        </td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                    <?php
                    if ($this->session->userdata('logged_in') ['category'] != 'suadmin') {
                        ?>
                        <tr>
                            <td>Supervisor</td>
                            <td><a href="#">
                                    <?= $supervisor_array_sub['firstname'] . ' ' . $supervisor_array_sub['lastname'] ?>
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i
                                        class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Created By</td>
                            <td><a href="#">
                                    <?= $supervisor_array['firstname'] . ' ' . $supervisor_array['lastname'] ?>
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i
                                        class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td>Status</td>
                        <td><span class="label label-sm label-info"><?= $this->session->userdata('logged_in')['category'] ?></span></td>
                        <td><a href="#panel_edit_account" class="show-tab"><i
                                    class="fa fa-pencil edit-user-info"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>