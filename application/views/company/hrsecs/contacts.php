<?php
$contactssf = $controller->gettablecolumns('contacts');
$contactssvalues = array();
?>
<div class="row" id="contactss_config">
         <div class="col-sm-12">
                  <!-- start: TEXT FIELDS PANEL -->
                  <!--<div class="panel panel-white">-->
                  <div class="panel-heading">
                           <h4 class="panel-title"> <span class="text-bold">CONTACTS</span></h4>
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
                           <form id="contactss_config_form" role="form" method="post" class="form-horizontal" novalidate>
                                    <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="contactss">
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'postaladdress')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               POSTAL ADDRESS
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="POSTAL ADDRESS" id="postaladdress" name="postaladdress" class="form-control"  value="<?= printvalues('postaladdress', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'streetaddress')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               STREET ADDRESS
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder=" STREET ADDRESS" id="streetaddress" name="streetaddress" class="form-control"  value="<?= printvalues('streetaddress', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'postalcode')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               POSTAL CODE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="POSTAL CODE" id="postalcode" name="postalcode" class="form-control"  value="<?= printvalues('postalcode', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'town')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               TOWN
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="TOWN" id="town" name="town" class="form-control"  value="<?= printvalues('town', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'country')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               COUNTRY
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="COUNTRY" id="country" name="country" class="form-control"  value="<?= printvalues('country', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'hometelephone')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               HOME TELEPHONE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="HOME TELEPHONE" id="hometelephone" name="hometelephone" class="form-control"  value="<?= printvalues('hometelephone', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'country')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               COUNTRY
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="COUNTRY" id="country" name="country" class="form-control"  value="<?= printvalues('country', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'worktelephone')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               WORK TELEPHONE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="WORK TELEPHONE" id="worktelephone" name="worktelephone" class="form-control"  value="<?= printvalues('worktelephone', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'email')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               EMAIL
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="EMAIL" id="email" name="email" class="form-control"  value="<?= printvalues('email', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'emergencycontactperson')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                              EMERGENCY CONTACT PERSON
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder=" EMERGENCY CONTACT PERSON" id="emergencycontactperson" name="emergencycontactperson" class="form-control"  value="<?= printvalues('emergencycontactperson', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'emergencycontactcellphone')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                              EMERGENCY CONTACT CELLPHONE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="EMERGENCY CONTACT CELLPHONE" id="emergencycontactcellphone" name="emergencycontactcellphone" class="form-control"  value="<?= printvalues('emergencycontactcellphone', $contactssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($contactssf, 'emergencycontactrelationship')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               EMERGENCY CONTACT RELATIONSHIP
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder=" EMERGENCY CONTACT RELATIONSHIP" id="emergencycontactrelationship" name="emergencycontactrelationship" class="form-control"  value="<?= printvalues('emergencycontactrelationship', $contactssvalues) ?>">
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
                                    <div id="tablecontentcontactss"></div>
                                    <!-- Paginator control -->
                                    <div id="paginator"></div>
                           </div>
                  </div>
         </div>
</div>
