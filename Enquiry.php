    <div class="container">
        <div class="row box_shad d-flex mt-sm-5 mb-sm-5">
            <div class="col-lg" style="background-color: #fff; padding: 10px">
                <img src="./assets//images/enquiry.webp" alt="enquiry" class="lear_img" />
            </div>
            <div class="col-lg" style="background-color: #fff; padding: 10px">
                <h1 class="header" style="font-weight: bold;">ENQUIRY</h1>

                <form action="./enqcode.php" method="POST">
                    <label for="eqName" class="txt"> Name</label>
                    <input type="text" id="eqName" name="eqName" class="input_enter" placeholder="Enter Your Name" required />
                    <label for="eqMail" class="txt">Email Id</label>
                    <input type="email" id="eqMail" name="eqMail" class="input_enter" placeholder="Enter Your Email Id" required />
                    <label for="eqPhone" class="txt">Phone</label>
                    <input type="tel" id="eqPhone" name="eqPhone" class="input_enter" placeholder="Enter Your Phone " pattern= "[0-9]+" minlength="10" maxlength="11" required />
                    <label for="eqApply" class="txt">Applying For</label>
                    <input type="text" id="eqApply" name="eqApply" class="input_enter" placeholder="Applying For" required />
                    <label for="eqMsg" class="txt">Message</label>
                    <input type="text" id="eqMsg" name="eqMsg" class="input_enter" placeholder="Enter Your Message Here..." required />
                    <button type="submit" name="eqsubmit" class="btn btn-lg btn-block" style="
            background-color: #6e20a7;
            color: #fff;
            width: 100%;
            margin-top: 25px;
            margin-bottom: 25px;
          ">
                        <span class="d-flex justify-content-center">SEND</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
