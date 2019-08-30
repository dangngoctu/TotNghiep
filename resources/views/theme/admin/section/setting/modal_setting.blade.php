<form class="form-layout" id="SettingForm">
    <input type="hidden" id="action" name="action" value="">
    <input type="hidden" id="id" name="id" value="">
    <div class="row mg-t-10">
        <label class="col-sm-4 form-control-label">Logo</label>
        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            <input type="file"  accept=".jpg, .jpeg, .png" class="picupload" id="logo" name="logo"/>
            Maximum 3MB
        </div>
    </div>
    <div class="row mg-t-30">
        <label class="col-sm-4 form-control-label">Limit image size upload(MB)<span class="tx-danger">*</span></label>
        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            <input type="text" class="form-control score" name="limit_upload" id="limit_upload" value=""
                   data-v-min="0" data-a-sep="" data-v-max="9999"
                   data-parsley-min="1" maxlength="4" data-parsley-min-message="Limit image size upload should be greater than or equal to 1."
                   required data-parsley-required-message="Limit image size upload is required.">
                   Limit image size upload.(Unit: Megabytes)
        </div>
    </div>
    <div class="row mg-t-25">
        <label class="col-sm-4 form-control-label">Hotline<span class="tx-danger">*</span></label>
        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            <input type="number" class="form-control" name="phone" id="phone" value="" min="0"
                   maxlength="20" required data-parsley-required-message="Hotline is required.">
        </div>
    </div>
    <div class="row mg-t-30">
        <label class="col-sm-4 form-control-label">Password default<span class="tx-danger">*</span></label>
        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            <input type="text" class="form-control" name="default_password" id="default_password" value=""
                   maxlength="20" required data-parsley-required-message="Password default is required.">
        </div>
    </div>

    <div class="form-layout-footer mg-t-30">
        <button type="button" class="btn btn-primary mg-l-5" id="btnSetting"
                data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
            <i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- form-layout-footer -->
</form>