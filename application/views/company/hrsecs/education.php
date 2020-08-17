<?php
$educationsf = $controller->gettablecolumns('education');
$educationsvalues = array();
?>
<div class="row" id="educations_config">
         <div class="col-sm-12">
                  <!-- start: TEXT FIELDS PANEL -->
                  <!--<div class="panel panel-white">-->
                  <div class="panel-heading">
                           <h4 class="panel-title"> <span class="text-bold">DOCUMENTS</span></h4>
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
                           <form id="educations_config_form" role="form" method="post" class="form-horizontal" novalidate>
                                    <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="educations">
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'document')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               DOCUMENT
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="" id="document" name="document" class="form-control"  value="<?= printvalues('document', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'selectfile')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               SELECT FILE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="file" id="selectfile" name="selectfile" class="form-control"  value="<?= printvalues('selectfile', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'refno')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               REF NO.
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="REF NO" id="refno" name="refno" class="form-control"  value="<?= printvalues('refno', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'description')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               DESCRIPTION
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="DESCRIPTION" id="description" name="description" class="form-control"  value="<?= printvalues('description', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'issuedby')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               ISSUED BY
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="ISSUED BY" id="issuedby" name="issuedby" class="form-control"  value="<?= printvalues('issuedby', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'issuedate')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               ISSUED DATE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="ISSUED DATE" id="issuedate" name="issuedate" class="form-control"  value="<?= printvalues('issuedate', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'expirydate')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               EXPIRY DATE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="EXPIRY DATE" id="expirydate" name="expirydate" class="form-control"  value="<?= printvalues('expirydate', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'receiveddate')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               RECEIVED DATE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="RECEIVED DATE" id="receiveddate" name="receiveddate" class="form-control"  value="<?= printvalues('receiveddate', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                             <div class="col-sm-4 pull-right">
                                                      <button class="btn btn-green btn-block" type="submit">
                                                               Add Contact<i class="fa fa-arrow-circle-right"></i>
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
                                    <div id="tablecontenteducations"></div>
                                    <!-- Paginator control -->
                                    <div id="paginator"></div>
                           </div>
                  </div>
         </div>
</div>
