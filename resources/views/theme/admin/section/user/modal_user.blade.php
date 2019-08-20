<!-- Edit modal employee -->
<div class="modal fade" id="modal-user" data-backdrop="static">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fas fa-user-graduate" id="ttlModal"></i></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <form class="form-layout" id="UserForm">
                    <input type="hidden" id="action" name="action" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="lang" name="lang" value="">
                    <div class="row">
                        <label class="col-sm-4 form-control-label">Name <span class="tx-danger">*</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="name" id="name" value=""
                                   maxlength="128" required data-parsley-required-message="Name is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Email <span class="tx-danger">*</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" name="email" id="email" value=""
                                   maxlength="128" required data-parsley-required-message="Email is required.">
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Phone <span class="tx-danger">*</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperPhone" class="parsley-select">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div><!-- input-group-prepend -->
                                    <input type="number" class="form-control" name="phone" id="phone" value="" placeholder="" min="0"
                                           data-parsley-class-handler="#slWrapperPhone" data-parsley-errors-container="#slErrorContainerPhone"
                                           maxlength="20" required data-parsley-required-message="Phone is required.">
                                </div><!-- input-group -->
                                <div id="slErrorContainerPhone"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label"></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <div id="rdioWrapperPass" class="parsley-checkbox w-100">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="rdiobox">
                                            <input name="pass" type="radio" value="1" checked
                                                   data-parsley-class-handler="#rdioWrapperPass"
                                                   data-parsley-errors-container="#rdioErrorContainerPass"
                                                   required data-parsley-required-message="Password type is required.">
                                            <span>Use default password</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="rdiobox">
                                            <input name="pass" type="radio" value="2">
                                            <span>Use optional password</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="rdioErrorContainerPass"></div>
                        </div>
                    </div>
                    <div class="block-pass-word d-none">
                        <div class="row mg-t-30">
                            <label class="col-sm-4 form-control-label">Password <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="password" class="form-control" name="password" id="password" value="" maxlength="20"
                                       data-parsley-minlength="4" data-parsley-minlength-message="Password at least 4 characters."
                                       data-parsley-required-message="Password is required.">
                            </div>
                        </div>
                        <div class="row mg-t-30">
                            <label class="col-sm-4 form-control-label">Repeat password <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="password" class="form-control" name="repassword" id="repassword" value="" maxlength="20"
                                       data-parsley-minlength="4" data-parsley-minlength-message="Password at least 4 characters."
                                       data-parsley-equalto="#password" data-parsley-equalto-message="Repeat password incorrect."
                                       data-parsley-required-message="Repeat password is required.">
                            </div>
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Avatar</label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="file" accept=".jpg, .jpeg, .png" class="picupload" id="avatar" name="avatar"/>
                            Maximum 3MB
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Birthday <span class="tx-danger">*</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperBirthday" class="parsley-select">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="dob" id="dob" value=""
                                            placeholder="DD/MM/YYYY" readonly
                                            required data-parsley-required-message="Birthday is required."
                                           data-parsley-class-handler="#slWrapperBirthday"
                                           data-parsley-errors-container="#slErrorContainerBirthday"
                                           data-parsley-minimumage="18" data-parsley-minimumage-message="User must be at least 18 years of age to register">
                                </div>
                                <div id="slErrorContainerBirthday"></div>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="row mg-t-30">
                        <label class="col-sm-4 form-control-label">Role <span class="tx-danger">*</span></label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <div id="slWrapperRole" class="parsley-select">
                                <select class="form-control select2" style="width: 100%" id="role" name="role" data-placeholder="Select role"
                                        data-parsley-class-handler="#slWrapperRole"
                                        data-parsley-errors-container="#slErrorContainerRole"
                                        required data-parsley-required-message="Role is required.">
                                </select>
                                <div id="slErrorContainerRole"></div>
                            </div>
                        </div>
                    </div>
                    <div id="blockLine" class="">
                        <div class="row mg-t-30" class="">
                            <label class="col-sm-4 form-control-label">Line<span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div id="slWrapperLine" class="parsley-select">
                                    <select class="form-control select2" style="width: 100%" id="line_select" name="line_select" data-placeholder="Select line"
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
                            <label class="col-sm-4 form-control-label">Area<span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <div id="slWrapperArea" class="parsley-select">
                                    <select class="form-control select2" style="width: 100%" id="area_select" name="area_select" data-placeholder="Select area"
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnUser"
                        data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Edit modal employee  -->
