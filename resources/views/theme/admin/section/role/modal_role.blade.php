<!-- Edit modal employee -->
<div class="modal fade" id="modal-role" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="RoleForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="permission" name="permission" value="">
                    <div class="row">
                        <label class="col-sm-3 form-control-label">Role<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="name" id="name" value=""
                                   maxlength="191" required data-parsley-required-message="Role is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Name<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="display_name" id="display_name" value=""
                                   maxlength="191" required data-parsley-required-message="Name is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Description<span class="tx-danger">*</span></label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="description" id="description" value=""
                                   maxlength="191" required data-parsley-required-message="Description is required.">
                        </div>
                    </div>
                    {{--<div class="row mg-t-30">--}}
                        {{--<label class="col-sm-3 form-control-label">Multiple management</label>--}}
                        {{--<div class="col-sm-9 mg-t-10 mg-sm-t-0">--}}
                            {{--<label class="ckbox">--}}
                                {{--<input type="checkbox" name="multiple_management" id="multiple_management">--}}
                                {{--<span></span>--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="row mg-t-30">
                        <label class="col-sm-3 form-control-label">Permission</label>
                        <div class="col-sm-9 mg-t-10 mg-sm-t-0">
                            <div class="table-wrapper">
                                <table id="datatable1" class="table display responsive nowrap table-dynamic-permission w-100">
                                    <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th class="wd-10p">Active</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div><!-- table-wrapper -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnRole"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
