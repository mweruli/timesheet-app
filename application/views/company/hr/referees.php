<?php
$refereessf = $controller->gettablecolumns('referees');
$refereessvalues = array();
?>
<div class="row" id="refereess_config">
         <div class="col-sm-12">
                  <!-- start: TEXT FIELDS PANEL -->
                  <!--<div class="panel panel-white">-->
                  <div class="panel-heading">
                           <h4 class="panel-title"> <span class="text-bold">REFEREES</span></h4>
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
                           <form id="refereess_config_form" role="form" method="post" class="form-horizontal" novalidate>
                                    <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="refereess">
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'name')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               NAME
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="NAME" id="name" name="name" class="form-control"  value="<?= printvalues('name', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'organization')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               ORGANIZATION
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="ORGANIZATION" id="organization" name="organization" class="form-control"  value="<?= printvalues('organization', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'jobtitle')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               JOB TITLE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="JOB TITLE" id="jobtitle" name="jobtitle" class="form-control"  value="<?= printvalues('jobtitle', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'profession')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               PROFESSION
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="PROFESSION" id="profession" name="profession" class="form-control"  value="<?= printvalues('profession', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'email')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               EMAIL
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'cellphone')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               CELL PHONE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="CELL PHONE" id="cellphone" name="cellphone" class="form-control"  value="<?= printvalues('cellphone', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'postaladdress')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               POSTAL ADDRESS
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="POSTAL ADDRESS" id="postaladdress" name="postaladdress" class="form-control"  value="<?= printvalues('postaladdress', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'physicaladdress')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               PHYSICAL ADDRESS
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="PHYSICAL ADDRESS" id="physicaladdress" name="physicaladdress" class="form-control"  value="<?= printvalues('physicaladdress', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'notes')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               NAME
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="NOTES" id="notes" name="notes" class="form-control"  value="<?= printvalues('notes', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($refereessf, 'memo')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               MEMO
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="MEMO" id="organization" name="memo" class="form-control"  value="<?= printvalues('memo', $refereessvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div class="col-sm-4 pull-right">
                                                      <button class="btn btn-green btn-block" type="submit">
                                                               Add Referee<i class="fa fa-arrow-circle-right"></i>
                                                      </button>
                                             </div>
                                    </div>
                           </form>
                           <div id="message"></div>
                           <div id="wrap">
                                    <!-- Feedback message zone -->
                                    <div id="toolbar">
                                       
                                    </div>
                                    <!-- Grid contents -->
                                    <div id="tablecontentrefereess"></div>
                                    <!-- Paginator control -->
                                    <div id="paginator"></div>
                           </div>
                  </div>
         </div>
</div>
