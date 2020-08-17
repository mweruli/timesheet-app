<div class="row">
	<div class="col-sm-12">
		<div class="tabbable">
			<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
				<li class="active"><a data-toggle="tab" href="#panel_overview">
						Overview </a></li>
				<li><a data-toggle="tab" href="#panel_edit_account"
					id="id_editaccount"> Edit Account </a></li>
			</ul>
			<div class="tab-content">
				<div id="panel_overview" class="tab-pane fade in active">
                    <?php echo $this->load->view('part/content/emp/v_profileview', '', TRUE); ?>
                </div>
				<div id="panel_edit_account" class="tab-pane fade">
                    <?php echo $this->load->view('part/content/emp/edit_account', '', TRUE); ?>
                </div>
			</div>
		</div>
	</div>
</div>