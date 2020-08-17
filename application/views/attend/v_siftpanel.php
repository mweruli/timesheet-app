<div class="tabbable no-margin no-padding  partition-black">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#shiftone"> Shifts
				Parameters Settings </a></li>
		<li class=""><a data-toggle="tab" href="#shifttwo" id="shift_addsec">
				Create Shift </a></li>
		<li class=""><a data-toggle="tab" href="#shiftlist" id="listshiftids">
				List Of Shifts </a></li>
		
	</ul>
	<div class="tab-content partition-white">
		<div id="shiftone" class="tab-pane padding-bottom-5 active">
            <?php echo $this->load->view('attend/times/v_shifeditview', '', TRUE); ?>
        </div>
		<div id="shifttwo" class="tab-pane padding-bottom-5">
            <?php echo $this->load->view('attend/times/v_shifadd', '', TRUE); ?>
        </div>
		<div id="shiftlist" class="tab-pane padding-bottom-5">
            <?php echo $this->load->view('attend/times/v_shiftlists', '', TRUE); ?>
        </div>
	</div>
</div>