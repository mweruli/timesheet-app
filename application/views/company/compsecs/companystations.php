<?php
$stationsf = $controller->gettablecolumns('stations');
//print_array($regions);
$stationvalues = array();
?>
<div class="row" id="company_stations">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="text-bold">STATIONS</span></h4>
            <div class="panel-tools">
                <div class="dropdown">
                    <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
                        <i class="fa fa-cog"></i>
                    </a>
                    <?php echo $this->load->view('part/include/formconfig', '', TRUE); ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="company_stations_form" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="stations">
                <div class="form-group" >
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'id_company')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            COMPANY
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_company" id="id_company"  >
                                <option value="">-SELECT COMPANY-</option>
                                <option selected="selected" value="<?= printvalues('id', $fieldsdata) ?>"><?= printvalues('name', $fieldsdata) ?></option>
                            </select>
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'station')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            REGION
                        </label>
                        <div class="col-sm-4">
                            <select  class="form-control search-select" placeholder="Select Form" name="id_region" id="id_region"  >
                                <option value="">-SELECT REGION-</option>
                                <?php
                                foreach ($regions as $region) {
                                    ?>
                                    <option value="<?= $region['id'] ?>"><?= $region['region'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'telephone')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                            TELEPHONE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="TELEPHONE" id="telephone" name="telephone" class="form-control"  value="<?= printvalues('telephone', $stationvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'station')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            STATION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="STATION NAME" id="station" name="station"  class="form-control" value="<?= printvalues('station', $stationvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'email')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            EMAIL
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $stationvalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($stationsf, 'contactperson')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            CONTACT PERSON
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="CONTACT Person" id="contactperson" name="contactperson"  class="form-control" value="<?= printvalues('contactperson', $stationvalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add Station&nbsp;<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
                <div id="toolbar">
                    <input type="text" id="filter" name="filter"
                           placeholder="Filter :type any text here" class="form-control" />
                </div>
                <!-- Grid contents -->
                <div id="tablecontentstation"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
<script>
    var addstation = "<?php echo base_url("company/add"); ?>";
    $(document).ready(function() {
        datagrid = new DatabaseGrid('stations', "tablecontentstation");
        $("#filter").keyup(function() {
            datagrid.editableGrid.filter($(this).val());
        });
        $('#company_stations_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                    },
                    fields: {
                        id_company: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($stationsf, 'id_company')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Company Name is required'
                                }
                            }
                        }
                        ,
                        email: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($stationsf, 'email')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Email  is required'
                                },
                                emailAddress: {
                                    message: 'The email address is not valid'
                                }
                            }
                        }
                        ,
                        station: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($stationsf, 'station')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Station Name   is required'
                                }
                            }
                        }
                        ,
                        id_region: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($stationsf, 'id_region')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Region Name  is required'
                                }
                            }
                        },
                        contactperson: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($stationsf, 'contactperson')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'Contact Person Required'
                                }
                            }
                        },
                        telephone: {
                            enabled: Boolean(Number(<?= trueorfalse(array_keyvaluen($fields, 'telephone')['mandatory']) ?>)),
                            validators: {
                                notEmpty: {
                                    message: 'The Telephone Number is required'
                                },
                                regexp: {
                                    regexp: /^[0-9,+]{13}$/,
                                    message: 'Enter Valid Contact Number format +254735973206'
                                }
                            }
                        }
                    }
                }).on('success.form.fv', function(e) {
            // Save the form data via an Ajax request
            e.preventDefault();
            $.ajax({
                url: addstation,
                type: $(this).attr("method"),
                dataType: "json",
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function(response) {
                datagrid.fetchGrid('stations');
                $('#company_stations_form').formValidation('resetForm', true);
                console.log(JSON.stringify(response));
            });
        });
    });
</script>
