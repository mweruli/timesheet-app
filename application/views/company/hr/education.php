<?php
$educationsf = $controller->gettablecolumns('education');
$educationsvalues = array();
?>
<div class="row" id="educations_config">
         <div class="col-sm-12">
                  <!-- start: TEXT FIELDS PANEL -->
                  <!--<div class="panel panel-white">-->
                  <div class="panel-heading">
                           <h4 class="panel-title">EDUCA<span class="text-bold">TION</span></h4>
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
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'course')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               COURSE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="COURSE" id="course" name="course" class="form-control"  value="<?= printvalues('course', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'educationlevel')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               EDUCATION LEVEL
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder=" EDUCATION LEVEL" id="educationlevel" name="educationlevel" class="form-control"  value="<?= printvalues('educationlevel', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'institution')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               INSTITUTION
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="INSTITUTION" id="institution" name="institution" class="form-control"  value="<?= printvalues('institution', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'datefrom')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               FROM
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="date" placeholder="FROM" id="datefrom" name="datefrom" class="form-control"  value="<?= printvalues('datefrom', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'dateto')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               to
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="date" placeholder="DATE TO" id="dateto" name="dateto" class="form-control"  value="<?= printvalues('dateto', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'grade')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               GRADE
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="GRADE" id="grade" name="grade" class="form-control"  value="<?= printvalues('grade', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'points')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               POINTS
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="POINTS" id="points" name="points" class="form-control"  value="<?= printvalues('points', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'ranking')['status']) ?>>
                                                      <label class="col-sm-2 control-label">
                                                               RANKING
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="RANKING" id="ranking" name="ranking" class="form-control"  value="<?= printvalues('ranking', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                    </div>
                                    <div class="form-group">
                                             <div <?= hideorshow(array_keyvaluen($educationsf, 'memo')['status']) ?>>
                                                      <label class="col-sm-2 control-label" for="form-field-1">
                                                               MEMO
                                                      </label>
                                                      <div class="col-sm-4">
                                                               <input type="text" placeholder="MEMO" id="memo" name="memo" class="form-control"  value="<?= printvalues('memo', $educationsvalues) ?>">
                                                      </div>
                                             </div>
                                             <div class="col-sm-4 pull-right">
                                                      <button class="btn btn-green btn-block" type="submit">
                                                               Add Education<i class="fa fa-arrow-circle-right"></i>
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
