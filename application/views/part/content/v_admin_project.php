<style>
    .disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul id="myTab5" class="nav nav-tabs">
                <li class="active">
                    <a href="#myTab5_example1xx" data-toggle="tab">
                        On Going Projects
                    </a>
                </li>
                <li class="">
                    <a href="#myTab5_example4yy" data-toggle="tab">
                        Closed Projects
                    </a>
                </li>
                <li class="">
                    <a href="#myTab5_example5pp" data-toggle="tab" id="project_view_id" class="disabled">
                        Project View
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="myTab5_example1xx">
                    <?php echo $this->load->view('part/content/cli/v_client_current', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab5_example4yy">
                    <?php echo $this->load->view('part/content/project/v_projetclosed', '', TRUE); ?>
                </div>
                <div class="tab-pane fade" id="myTab5_example5pp">
                    <?php echo $this->load->view('part/content/cli/v_clientproject', '', TRUE); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
//        alert('hey');
        $('.buttons-excel').hide();
//        document.getElementsByClassName('buttons-excel')[0].style.visibility = 'hidden';
    });
</script>