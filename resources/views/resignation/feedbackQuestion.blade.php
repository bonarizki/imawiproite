<!-- Modal -->
<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Working Experience Feedback</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                @csrf
                <div class="form-body">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group" id="resign_feedback_1_group">
                                            <label>1. What is the biggest reason you are leaving our organization? (you can choose more than 1 answer) <span class="text-danger">*</span></label>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox" value="Leadership Issue" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Leadership Issue</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Working location" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Working location</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Better benefit" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Better benefit</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Career development" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Career development</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Family or Personal reason" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Family or Personal reason</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Work load" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Work load</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Medical reason" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Medical reason</span>
                                            </div>
                                            <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="Environment and culture" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Environment and culture</span>
                                            </div>
                                            {{-- <div class="vs-checkbox-con vs-checkbox-primary" style="padding-left: 30px">
                                                <input type="checkbox"  value="other" name="resign_feedback_1[]">
                                                <span class="vs-checkbox vs-checkbox-lg">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Yang Lainnya</span>
                                            </div> --}}
                                        </div>
                                        <div class="form-group" id="resign_feedback_2_group">
                                            <label>2. How would you rate your satisfaction working with us? <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Dissatisfied
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_2" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_2" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_2" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_2" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_2" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Satisfied
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_3_group">
                                            <label>3. You feel that the management is fair and implement the Wipro Values <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_3" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_3" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_3" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_3" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_3" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_4_group">
                                            <label>4. Were you satisfied with your remuneration and other benefits? <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_4" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_4" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_4" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_4" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_4" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_5_group">
                                            <label>5. You feel that job role is suitable for you * ? <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_5" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_5" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_5" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_5" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_5" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_6_group">
                                            <label>6. My manager/superior gave me clear objectives <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_6" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_6" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_6" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_6" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_6" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_7_group">
                                            <label>7. My manager/superior gave me appropriate guidance and help <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_7" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_7" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_7" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_7" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_7" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_8_group">
                                            <label>8. My manager/superior respect me and others <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_8" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_8" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_8" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_8" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_8" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_9_group">
                                            <label>9. My manager/superior ran the business fairly <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_9" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_9" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_9" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_9" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_9" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_10_group">
                                            <label>10. My manager/superior gave me an opportunity on my career development <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_10" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_10" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_10" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_10" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_10" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_11_group">
                                            <label>11. My manager/superior support teamwork and collaboration <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_11" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_11" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_11" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_11" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_11" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_12_group">
                                            <label>12. My manager/superior was really open-minded and open with feedback <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_12" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_12" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_12" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_12" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_12" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_13_group">
                                            <label>13. My manager/superior gave me work or performance evaluation regularly <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_13" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_13" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_13" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_13" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_13" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_14_group">
                                            <label>14. My manager/superior acknowledged my work result <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_14" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_14" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_14" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_14" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_14" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_15_group">
                                            <label>15. My manager/superior gave me trust in work <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_15" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_15" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_15" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_15" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_15" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_16_group">
                                            <label>16. Will you recommend this organization as a great place to belong? <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_16" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_16" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_16" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_16" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_16" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_17_group">
                                            <label>17. Will you recommend this organization to your colleague/family/friends ?<span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_17" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_17" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_17" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_17" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_17" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_18_group">
                                            <label>18. Will you reconsider to rejoin with our organization? <span class="text-danger">*</span></label>
                                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                                <li class="d-inline-block mr-2">
                                                    Very Disagreed
                                                </li>
                                                <li class="d-inline-block mr-2 ">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_18" value="1">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">1</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_18" value="2">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">2</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_18" value="3">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">3</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_18" value="4">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">4</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="vs-radio-con vs-radio-primary">
                                                            <input type="radio" name="resign_feedback_18" value="5">
                                                            <span class="vs-radio vs-radio-lg">
                                                                <span class="vs-radio--border"></span>
                                                                <span class="vs-radio--circle"></span>
                                                            </span>
                                                            <span class="">5</span>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    Very Agreed
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group" id="resign_feedback_19_group">
                                            <label>19. What did you like most when you worked with us? *<span class="text-danger">*</span></label>
                                            <input type="text" id="resign_feedback_19" class="form-control" name="resign_feedback_19" placeholder="your answer">
                                        </div>
                                        <div class="form-group" id="resign_feedback_20_group">
                                            <label>20. What did you dislike most when you worked with us? *<span class="text-danger">*</span></label>
                                            <input type="text" id="resign_feedback_20" class="form-control" name="resign_feedback_20" placeholder="your answer">
                                        </div>
                                        <div class="form-group" id="resign_feedback_21_group">
                                            <label>21. If you can change something in our organization or the working experience with us, what would it be?<span class="text-danger">*</span></label>
                                            <input type="text" id="resign_feedback_21" class="form-control" name="resign_feedback_21" placeholder="your answer">
                                        </div>
                                        <div class="form-group" id="resign_feedback_22_group">
                                            <label>22. What skills and qualifications do you think we need to look for in your replacement? <span class="text-danger">*</span></label>
                                            <input type="text" id="resign_feedback_22" class="form-control" name="resign_feedback_22" placeholder="your answer">
                                        </div>
                                        <div class="form-group" id="resign_feedback_23_group">
                                            <label>23. Suggestion for improvement (you can share it in Bahasa) <span class="text-danger">*</span></label>
                                            <input type="text" id="resign_feedback_23" class="form-control" name="resign_feedback_23" placeholder="your answer">
                                        </div>
                                        <div class="form-group" id="resign_feedback_24_group">
                                            <label>24. Are you leaving here to join another organization? *<span class="text-danger">*</span></label>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_24" value="yes">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Yes</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_24" value="no">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">No</span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="resign_feedback_25_group">
                                            <label>25. If yes, is the company run in the same category/field as our organization? <span class="text-danger">*</span></label>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_25" value="yes">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Yes</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_25" value="no">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">No</span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="resign_feedback_26_group">
                                            <label>26. Is your new job is a promotion? *<span class="text-danger">*</span></label>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_26" value="yes">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Yes</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_26" value="no">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">No</span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="resign_feedback_27_group">
                                            <label>27. How is your total benefit in the new company compared with us? *<span class="text-danger">*</span></label>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_27" value="Lower than current benefit">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Lower than current benefit</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_27" value="Almost the same">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">Almost the same</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_27" value="10-20% higher">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">10-20% higher</span>
                                            </div>
                                            <div class="vs-radio-con vs-radio-primary">
                                                <input type="radio" name="resign_feedback_27" value="More than 20% increment">
                                                <span class="vs-radio vs-radio-lg">
                                                    <span class="vs-radio--border"></span>
                                                    <span class="vs-radio--circle"></span>
                                                </span>
                                                <span class="">More than 20% increment</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="validasi()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>