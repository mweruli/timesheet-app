<div class="row" >
         <div class="col-sm-12">
                  <div class="tabbable">
                           <ul id="myTab2" class="nav nav-tabs">
                                    <li class="active">
                                             <a href="#myTab2_employeesonleave" data-toggle="tab" id="link_tab_addclient"> 
                                                      <i class="green fa fa-home">&nbsp;Employees On Leave</i>
                                             </a>
                                    </li>
                                    <li><a href="#myTab2_leavespendingapproval" data-toggle="tab"> 
                                                      <i class="fa fa-code-fork"></i>&nbsp;Leaves Pending Approval
                                             </a>
                                    </li>
                                    <li><a href="#myTab2_scheduledleaves" data-toggle="tab">
                                                      <i class="fa fa-code-fork"></i>&nbsp;Scheduled Leaves
                                             </a>
                                    </li>
                                    <li><a href="#myTab2_completedleaves" data-toggle="tab">
                                                      <i class="fa fa-code-fork"></i>&nbsp;Completed Leaves
                                             </a>
                                    </li>
                                    <li><a href="#myTab2_declinedleaves" data-toggle="tab">
                                                      <i class="fa fa-code-fork"></i>&nbsp;Declined Leaves
                                             </a>
                                    </li>
                           </ul>
                           <div class="tab-content">
                                    <div class="tab-pane fade in active" id="myTab2_employeesonleave">
                                             <?php echo $this->load->view('company/leave/employeesonleave', '', TRUE); ?>
                                    </div>
                                    <div class="tab-pane fade" id="myTab2_leavespendingapproval">
                                             <?php echo $this->load->view('company/leave/leavespendingapproval', '', TRUE); ?>
                                    </div>
                                    <div class="tab-pane fade" id="myTab2_scheduledleaves">
                                             <?php echo $this->load->view('company/leave/scheduledleaves', '', TRUE); ?>
                                    </div>
                                    <div class="tab-pane fade" id="myTab2_completedleaves">
                                             <?php echo $this->load->view('company/leave/completedleaves', '', TRUE); ?>
                                    </div>
                                    <div class="tab-pane fade" id="myTab2_declinedleaves">
                                             <?php echo $this->load->view('company/leave/declinedleaves', '', TRUE); ?>
                                    </div>
                           </div>
                  </div>
         </div>
</div>