<!-- Edit modal employee -->
<div class="modal fade" id="modal-fail-mode-detail" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="FailModeDetailForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <div class="row">
                        <label class="col-sm-3 form-control-label">Name</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="name" id="name" value=""
                                   maxlength="255" required data-parsley-required-message="Name is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Weight Factor</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="number" class="form-control" name="weight_factor" id="weight_factor" value="" min="0"
                                   maxlength="2" required data-parsley-required-message="Weight factor is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Category</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperCategory" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="category_id" name="category_id" data-placeholder="Select category"
                                        data-parsley-class-handler="#slWrapperCategory" data-parsley-errors-container="#slErrorContainerCategory"
                                        required data-parsley-required-message="Category is required.">
                                    <option label="Select category"></option>
                                </select>
                                <div id="slErrorContainerCategory"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30 d-none">
                        <label class="col-sm-3 form-control-label">Failure mode</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperFailureMode" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="failure_id" name="failure_id" data-placeholder="Select failure mode"
                                        data-parsley-class-handler="#slWrapperFailureMode" data-parsley-errors-container="#slErrorContainerFailureMode"
                                        data-parsley-required-message="Failure mode is required.">
                                    <option label="Select failure mode"></option>
                                </select>
                                <div id="slErrorContainerFailureMode"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnFailModeDetail"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
