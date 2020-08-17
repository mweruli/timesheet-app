<?php
$skillssf = $controller->gettablecolumns('skills');
$skillssvalues = array();
?>
<div class="row" id="skillss_config">
         <div class="col-sm-12">
                  <!-- start: TEXT FIELDS PANEL -->
                  <!--<div class="panel panel-white">-->
                  <div class="panel-heading">
                           <h4 class="panel-title"> <span class="text-bold">SKILL</span></h4>
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
                           <form id="skillss_config_form" role="form" method="post" class="form-horizontal" novalidate>
                                    <input type="hidden"  id="tablename" name="tablename"  class="form-control" value="skillss">
                                    
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($skillssf, 'skillcategory')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               SKILL CATEGORY
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="SKILL CATEGORY" id="skillcategory" name="skillcategory" class="form-control"  value="<?= printvalues('skillcategory', $skillssvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($skillssf, 'skill')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               SKILL
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="SKILL" id="skill" name="skill" class="form-control"  value="<?= printvalues('skill', $skillssvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                             <div class="col-sm-4 pull-right">
                                                      <button class="btn btn-green btn-block" type="submit">
                                                               Add Skill<i class="fa fa-arrow-circle-right"></i>
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
                                    <div id="tablecontentskillss"></div>
                                    <!-- Paginator control -->
                                    <div id="paginator"></div>
                           </div>
                  </div>
         </div>
</div>
