<div class="row" novalidate>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab2" class="nav nav-tabs">
                <li class="active"><a href="#myTab2_temtypes" data-toggle="tab"
                                      id="link_tab_addclient"> <i class="green fa fa-home">&nbsp;Termination Types</i>
                    </a>
                </li>
                <li><a href="#myTab2_indiscat" data-toggle="tab"
                       > <i class="fa fa-code-fork"></i>&nbsp;Indiscipline Categories
                    </a>
                </li>
                <li><a href="#myTab2_indisact" data-toggle="tab"
                       > <i class="fa fa-share-alt"></i>&nbsp;Indiscipline Actions
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab2_temtypes">
                    <?php echo $this->load->view('company/otherspecs/tymintypes', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_indiscat">
                    <?php echo $this->load->view('company/otherspecs/indisplinacat', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab2_indisact">
                    <?php echo $this->load->view('company/otherspecs/indisplineactions', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('viewjs/hrconfig', TRUE); 