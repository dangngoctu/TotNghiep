<!-- Edit modal employee -->
<div class="modal fade" id="modal-area" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="AreaForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <div class="row">
                        <label class="col-sm-3 form-control-label">Name<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="name" id="name" value=""
                                   maxlength="255" required data-parsley-required-message="Name is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Major<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperLocation" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="major_id_modal" name="major_id_modal" data-placeholder="Select Major"
                                        data-parsley-class-handler="#slWrapperLocation"
                                        data-parsley-errors-container="#slErrorContainerLocation"
                                        required data-parsley-required-message="Major is required.">
                                    <option label="Select major"></option>
                                </select>
                                <div id="slErrorContainerLocation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30 d-none">
                        <label class="col-sm-3 form-control-label">List Name<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperComment" class="parsley-select">
                                <textarea class="form-control" id="listname" name="listname" placeholder="" style="width: 100%;" rows="15"
                                          data-parsley-class-handler="#slWrapperComment"
                                          data-parsley-errors-container="#slErrorContainerComment"
                                          data-parsley-required-message="List name is required."></textarea>
                                <div id="slErrorContainerComment"></div>
                                <span class="help-block">Add one item per line, without the specical symbols</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Status</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <label class="ckbox">
                                <input type="checkbox" name="status" id="status">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnArea"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
