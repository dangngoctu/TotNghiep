<!-- Edit modal notification add -->
<div class="modal fade" id="modal-notification-add" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="NotificationForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <div id="blockLine">
                        <div class="row">
                            <label class="col-sm-3 form-control-label">Line<span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                                <div id="slWrapperLine" class="parsley-select">
                                    <select class="form-control select2" style="width: 100%" id="line_id" name="line_id" data-placeholder="Select line"
                                            data-parsley-class-handler="#slWrapperLine"
                                            data-parsley-errors-container="#slErrorContainerLine"
                                            required data-parsley-required-message="Line is required.">
                                        <option label="Select line"></option>
                                    </select>
                                    <div id="slErrorContainerLine"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="blockArea" class="d-none">
                        <div class="row mg-t-30" class="d-none">
                            <label class="col-sm-3 form-control-label">Area<span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                                <div id="slWrapperArea" class="parsley-select">
                                    <select class="form-control select2" style="width: 100%" id="area_id" name="area_id" data-placeholder="Select area"
                                            data-parsley-class-handler="#slWrapperArea"
                                            data-parsley-errors-container="#slErrorContainerArea"
                                            required data-parsley-required-message="Area is required.">
                                        <option label="Select area"></option>
                                    </select>
                                    <div id="slErrorContainerArea"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="blockDevice" class="d-none">
                        <div class="row mg-t-30" class="d-none">
                            <label class="col-sm-3 form-control-label">Device<span class="tx-danger">*</span></label>
                            <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                                <div id="slWrapperDevice" class="parsley-select">
                                    <select class="form-control select2" style="width: 100%" id="device_id" name="device_id" data-placeholder="Select Device"
                                            data-parsley-class-handler="#slWrapperDevice"
                                            data-parsley-errors-container="#slErrorContainerDevice"
                                            required data-parsley-required-message="Device is required.">
                                        <option label="Select Device"></option>
                                    </select>
                                    <div id="slErrorContainerDevice"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Logo</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-9">
                            <input type="file"  accept=".jpg, .jpeg, .png" class="picupload" id="logo" name="logo"/>
                            Maximum 3MB
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Category</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
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
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Failure</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperFailure" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="failure_id" name="failure_id" data-placeholder="Select failure"
                                        data-parsley-class-handler="#slWrapperFailure" data-parsley-errors-container="#slErrorContainerFailure"
                                        required data-parsley-required-message="Failure is required.">
                                    <option label="Select failure"></option>
                                </select>
                                <div id="slErrorContainerFailure"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Comment</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="comment" id="comment" value=""
                                required data-parsley-required-message="Comment is required.">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnLocation"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Submit</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
