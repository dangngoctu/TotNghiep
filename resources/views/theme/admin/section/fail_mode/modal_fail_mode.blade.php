<!-- Edit modal employee -->
<div class="modal fade" id="modal-fail-mode" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="FailModeForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <div class="row">
                        <label class="col-sm-4 form-control-label">Name</label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="name" id="name" value=""
                                   maxlength="255" required data-parsley-required-message="Name is required.">
                        </div>
                    </div>
                    {{--<div class="row mg-t-30">--}}
                        {{--<label class="col-sm-4 form-control-label">Group category</label>--}}
                        {{--<div class="col-sm-8 mg-t-10 mg-sm-t-0">--}}
                            {{--<div id="slWrapperGroupCategory" class="parsley-select">--}}
                                {{--<select class="form-control select2" style="width: 100%" id="group-category-id" name="group-category-id" data-placeholder="Select group category"--}}
                                        {{--data-parsley-class-handler="#slWrapperGroupCategory"--}}
                                        {{--data-parsley-errors-container="#slErrorContainerGroupCategory"--}}
                                        {{--required data-parsley-required-message="Group category is required.">--}}
                                    {{--<option label="Select group category"></option>--}}
                                    {{--<option value="1">Production</option>--}}
                                    {{--<option value="2">Office</option>--}}
                                    {{--<option value="1">Warehouse</option>--}}
                                {{--</select>--}}
                                {{--<div id="slErrorContainerGroupCategory"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Category</label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnFailMode"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
