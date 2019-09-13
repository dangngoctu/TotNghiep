<!-- Edit modal location -->
<div class="modal fade" id="modal-notification-update" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="NotificationFormUpdate">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <input type="hidden" id="reason" name="reason" value="">
                    <div class="row">
                        <label class="col-sm-3 form-control-label">Creater</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperCreater" class="parsley-select">
                                <input type="text" class="form-control" name="creater" id="creater" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Category</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperCategory" class="parsley-select">
                                <input type="text" class="form-control" name="category" id="category" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Failure</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperFailure" class="parsley-select">
                                <input type="text" class="form-control" name="category" id="category" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Device</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperDevice" class="parsley-select">
                                <input type="text" class="form-control" name="device" id="device" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Comment</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperComment" class="parsley-select">
                                <input type="text" class="form-control" name="comment" id="comment" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Status</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperStatus" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="status" name="status" data-placeholder="Select status"
                                        data-parsley-class-handler="#slWrapperStatus" data-parsley-errors-container="#slErrorContainerStatus"
                                        required data-parsley-required-message="Status is required.">
                                    <option value='2'>Confirm</option>
                                    <option value='3'>Reject</option>
                                </select>
                                <div id="slErrorContainerStatus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Comment Review</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div id="slWrapperCommentReview" class="parsley-select">
                            <div class="summernote"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnLocation"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
