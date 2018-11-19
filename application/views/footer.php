    <footer class="main-footer">
        <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>
</div>

<!-- jQuery 3 -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<!-- SlimScroll -->
<script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js');?>"></script>
<!-- Datepicker -->
<script src="<?= base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",');?>"></script>
<!-- General Function -->
<script src="<?= base_url('assets/application/general.js');?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/dist/js/demo.js');?>"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>

<!-- General Modal -->
<div class="modal fade modal-danger" id="modal-deleteConfirm" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$this->lang->line("generalMessage")?></h4>
            </div>
            <div class="modal-body">
              <p><?=$this->lang->line("generalDeleteConfirm")?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><?=$this->lang->line("generalClose")?></button>
                <button type="button" class="btn btn-outline" id="deleteButtonConfirm" data-id=""><?=$this->lang->line("generalDelete")?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Success Modal -->
<div class="modal modal-success fade" id="modal-success" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><?=$this->lang->line("generalMessage")?></h4>
            </div>
            <div class="modal-body">
            <p><?=$this->lang->line("generalSucess")?></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal"><?=$this->lang->line("generalDone")?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- message modal -->
<div class="modal fade" id="modal-message" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><?=$this->lang->line("generalMessage")?></h4>
            </div>
            <div class="modal-body">
            <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line("generalClose")?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- General Pagination -->
<div class="template" id="paginationTemplate">
    <li class="paginate_button {status} template" data-page="{page}">
        <a href="#">{page}</a>
    </li>
</div>

<!-- row component -->
<div class="tempalte" id="rowComponent">
    <div class="template row pb-4">
        {innerDiv}
    </div>
</div>

<!-- template -->
<div class="template" id="option">
    <option value="{value}" {selected}>{title}</option>
</div>

<?php
    if(isset($js)){
        
        foreach($js as $file){
            echo "<script src='".base_url($file)."?refres=".date("s")."'></script>";
        }
    }
?>