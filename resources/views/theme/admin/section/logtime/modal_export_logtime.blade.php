<!-- Edit modal location -->
<div class="modal fade" id="modal-export-logtime" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
            <form class="form-horizontal" id="dataExportLogtime" role="form" data-toggle="validator">
                    <div class="row">
                        <label for="exportFromDate" class="col-sm-3 control-label">Từ ngày</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="exportFromDate" name="exportFromDate" value=""
                                    required data-parsley-required-message="Ngày bắt đầu không được trống">
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                    <label for="exportToDate" class="col-sm-3 control-label">Đến ngày</label>
                        <div class="col-sm-9 mg-t-9 mg-sm-t-0">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="exportToDate" name="exportToDate" value=""
                                    required data-parsley-required-message="Ngày kết thúc không đượct rống">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-primary" id="exportLogtimeBtn"
                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> ">
                    <i class="fa fa-file-excel"></i> Xuất dữ liệu</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
