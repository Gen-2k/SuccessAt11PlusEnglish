<div class="modal fade viewContainer " id="dataViewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 800px;">
        <div class="modal-content shadow p-2 rounded maindiv">
            <div class="d-flex justify-content-end"><button type="button" class="btn-close  shadow-none"
                    data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-header">
                <div class="row m-3">
                    <a href="#section1" class="text_decoration col-sm-4 studentViewHeader p-2">
                        <p class="fs-5 fw-bold m-0">STUDENT PERSONAL AND COURSE DETAILS</p>
                    </a>
                    <a href="#section2" class="text_decoration col-sm-4 studentViewHeader p-2">
                        <p class="fs-5 fw-bold m-0">PARENTS DETAILS</p>
                    </a>
                    <a href="#section3" class="text_decoration col-sm-4 studentViewHeader p-2">
                        <p class="fs-5 fw-bold m-0">TERMS AND CONDITIONS</p>
                    </a>
                </div>
            </div>
            <div class="modal-body">
                <div class="shadow m-2 p-4" id="section1">
                    <div class="h4 text-center">STUDENT'S PERSONAL AND COURSE DETAILS</div>
                    <hr class="new2">

                    <pre><p class="text-start mt-4 fs-5 fw-bold">APPLICANT NAME : <span class="view_Fname" style="color: red;"></span> <span class="view_Sname" style="color: red;"></span> <small class="fs-6">(<span class="text-secondary view_dofe"></span>)</small></p></pre>
                    <hr class="new2">
                    <div class="row mt-3">
                        <div class="col-sm-6 insidediv  p-2 ">
                            <p class="fs-5 fw-bold">STUDENT'S INFORMATION :</p>
                            <div class="mt-4">
                                <h6 class="fw-bold"> FIRSTNAME : <span class="view_Fname" style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> SURNAME : <span class="view_Sname" style="color: red;"></span></h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> DATE OF BIRTH : <span class="view_dob" style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> GENDER : <span class="view_gender" style="color: red;"></span></h6>

                            </div>
                        </div>
                        <div class="col-sm-6 insidediv  p-2 ">
                            <p class="fs-5 fw-bold">COURSE INFORMATION :</p>

                            <div class="mt-4">
                                <div class="">
                                    <h6 class="fw-bold"> CATEGORY : <span class="view_cat"
                                            style="color: red;">ADULTS</span></h6>
                                </div>
                                <hr class="new2">
                                <h6 class="fw-bold"> SUBJECT : <span class="view_sub" style="color: red;">PANJABI</span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> TERMS : <span class="view_term" style="color: red;">Term 1 </span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> STATUS : <span id="view_status" style="color: green;">LIVE </span>
                                </h6>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="shadow m-2 p-4" id="section2">
                    <div class="h4">PARENT'S DETAILS</div>
                    <hr class="new2">

                    <div class="row mt-3  insidediv">
                        <!-- <p class="fs-5 fw-bold">PARENT INFORMATION :</p> -->
                        <div class="col-sm-6 ">
                            <div class="mt-3">
                                <h6 class="fw-bold">PARENT'S FIRSTNAME : <span id="pFname" style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold">PARENT'S SURNAME : <span id="pSname" style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold">ADDRESS : <span id="view_address" style="color: red;"></span></h6>
                                <hr class="new2">
                            </div>
                        </div>
                        <div class="col-sm-6 insidediv">
                            <!-- <p style="visibility: hidden;">PARENT INFORMATION INFORMATION :</p> -->
                            <div class="mt-3">
                                <h6 class="fw-bold"> EMAIL : <span class="view_eMail text-break"
                                        style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> PASSWORD : <span id="userpwd" style="color: red;"></span>
                                </h6>
                                <hr class="new2">
                                <h6 class="fw-bold"> PHONE NUMBER : <span class="view_Ph" style="color: red;"></span>
                                </h6>
                                <!-- <hr class="new2">
                                    <div class="fw-bold p"> CHILD : <span style="color: red;">FIRST CHILD</span>
                                    </div> -->
                                <hr class="new2">


                            </div>

                        </div>
                    </div>

                </div>
                <div class="shadow p-4 m-2">
                    <button class="h4 btn-lg btn shadow-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#changeAmount" aria-expanded="false" aria-controls="changeAmount">Change Course
                        Price <small>(click here)</small> </button>
                    <!-- <hr class="new2"> -->
                    <div class="collapse" id="changeAmount">
                        <div class="row  shadow">
                            <div class="col-sm-12 insidediv">
                                <div class="d-flex flex-wrap justify-content-center align-items-center py-4">
                                    <div class="card p-4">
                                        <div class="fs-5">Current Amount : <span>&pound</span></span><span
                                                id="view_CrAmt">155</span></div>
                                        <form action="" method="POST" id="disc_Amt" class="needs-validation" novalidate>
                                            <div class="form-floating my-3">
                                                <input type="text" name="dis_Amt" class="form-control shadow-none"
                                                    maxlength="3" pattern="[0-9]+" placeholder="Discount Price (&pound)"
                                                    id="discount" required>
                                                <label for="discount" class="text-secondary">Discount Price
                                                    (&pound)</label>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="sub_disAmt"
                                                    class="btn shadow-none btn-danger" id="liveToastBtn">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow m-2 p-4" id="section3">
                    <div class="h4">TERMS AND CONDITIONS & DATA PROTECTION</div>
                    <hr class="new2">
                    <div class="row mt-3  shadow">
                        <div class="col-sm-12 insidediv">

                            <div class="mt-4">
                                <hr class="new2">
                                <p class="fs-6"> I consent to occasional classes being recorded for staff training
                                    purposes only. I accept that I will have the right to decline or permit use of any
                                    footage of my child, when asked, (for use on  Success at 11 plus English website or social media),
                                    prior to use : <span id="view_YoN" style="color: red;"></span>
                                </p>
                                <hr class="new2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center px-4">
                <button type="button" class="btn shadow-none my-3 btn-success rounded fw-bold viewBackBtn"
                    data-bs-dismiss="modal">BACK</button>
                <!-- <button type="button" class="btn shadow-none my-3 btn-info rounded fw-bold viewBackBtn" data-bs-dismiss="modal">GIVE DISCOUNT</button> -->
            </div>
        </div>
    </div>
</div>