<?php
$experiencef = $controller->gettablecolumns('experience');
$experiencevalues = array();
?>
<div class="row" id="employementtypes_config">
    <div class="col-sm-12">
        <!-- start: TEXT FIELDS PANEL -->
        <!--<div class="panel panel-white">-->
        <div class="panel-heading">
            <h4 class="panel-title"> EXPE<span class="text-bold">RIENCE</span></h4>
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
            <form id="employementtypes_configform" role="form" method="post" class="form-horizontal" novalidate>
                <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="employementtypes">
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'organization')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                           ORGANIZATION
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="ORGANIZATION" id="organization" name="organization" class="form-control"  value="<?= printvalues('organization', $experiencevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'jobtitle')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            JOB TITLE
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="JOB TITLE" id="jobtitle" name="jobtitle" class="form-control"  value="<?= printvalues('jobtitle', $experiencevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'datefrom')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-from">
                           FROM
                        </label>
                        <div class="col-sm-4">
                            <input type="date" placeholder="DATE  FROM" id="datafrom" name="datafrom" class="form-control"  value="<?= printvalues('datafrom', $experiencevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'dateto')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            TO
                        </label>
                        <div class="col-sm-4">
                            <input type="date" placeholder="DATE TO" id="dateto" name="dateto" class="form-control"  value="<?= printvalues('dateto', $experiencevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'reasonforliving')['status']) ?>>
                        <label class="col-sm-2 control-label" for="form-field-1">
                           REASON FOR LIVING
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder=" REASON FOR LIVING" id="reasonforliving" name="reasonforliving" class="form-control"  value="<?= printvalues('reasonforliving', $experiencevalues) ?>">
                        </div>
                    </div>
                    <div <?= hideorshow(array_keyvaluen($experiencef, 'memo')['status']) ?>>
                        <label class="col-sm-2 control-label">
                            MEMO
                        </label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="MEMO" id="memo" name="memo" class="form-control"  value="<?= printvalues('memo', $experiencevalues) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 pull-right">
                        <button class="btn btn-green btn-block" type="submit">
                            Add EXPERIENCE<i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <div id="wrap">
                <!-- Feedback message zone -->
            
                <!-- Grid contents -->
                <div id="tablecontentemployementtypes"></div>
                <!-- Paginator control -->
                <div id="paginator"></div>
            </div>
        </div>
    </div>
</div>
