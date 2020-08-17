<div class="row" >
         <div class="col-sm-12">
                  <div class="tabbable">
                           <ul id="myTab2" class="nav nav-tabs">
                                    <li class="active">
                                             <a href="#myTab2_addperemployee" data-toggle="tab" > 
                                                      <i class="fa fa-user">&nbsp;Assign Leave </i>
                                             </a>
                                    </li>
                           </ul>
                           <div class="tab-content">
                                    <div class="tab-pane  in active" id="myTab2_addperemployee">
                                             <?php echo $this->load->view('company/leave/assignleave', '', TRUE); ?>
                                    </div>
                           </div>
                  </div>
         </div>
</div>