<div id="newContributor">
    <div class="noteWrap col-md-8 col-md-offset-2">
        <h3>Add new contributor</h3>
        <form class="form-contributor">
            <div class="row">
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                    </div>
                    <div class="successHandler alert alert-success no-display">
                        <i class="fa fa-ok"></i> Your form validation is successful!
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="contributor-id hide" type="text">
                        <label class="control-label">
                            First Name <span class="symbol required"></span>
                        </label>
                        <input type="text" placeholder="Insert your First Name" class="form-control contributor-firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Last Name <span class="symbol required"></span>
                        </label>
                        <input type="text" placeholder="Insert your Last Name" class="form-control contributor-lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Email Address <span class="symbol required"></span>
                        </label>
                        <input type="email" placeholder="Text Field" class="form-control contributor-email" name="email">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Password <span class="symbol required"></span>
                        </label>
                        <input type="password" class="form-control contributor-password" name="password">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Confirm Password <span class="symbol required"></span>
                        </label>
                        <input type="password" class="form-control contributor-password-again" name="password_again">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Gender <span class="symbol required"></span>
                        </label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" class="grey contributor-id_gender" value="F" name="id_gender">
                                Female
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="grey contributor-id_gender" value="M" name="id_gender">
                                Male
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Permits <span class="symbol required"></span>
                        </label>
                        <select name="permits" class="form-control contributor-permits" >
                            <option value="View and Edit">View and Edit</option>
                            <option value="View Only">View Only</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="fileupload fileupload-new contributor-avatar" data-provides="fileupload">
                            <div class="fileupload-new thumbnail"><img src="assets/images/anonymous.jpg" alt="" width="50" height="50"/>
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail"></div>
                            <div class="contributor-avatar-options">
                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
                                    <input type="file">
                                </span>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i> Remove
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            SEND MESSAGE (Optional)
                        </label>
                        <textarea class="form-control contributor-message"></textarea>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <div class="btn-group">
                    <a href="#" class="btn btn-info close-subview-button">
                        Close
                    </a>
                </div>
                <div class="btn-group">
                    <button class="btn btn-info save-contributor" type="submit">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>