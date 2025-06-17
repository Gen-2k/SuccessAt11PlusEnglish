    <!-- MAIL SEND for Pending Students -->

    <div class="modal mailSendContainer" id="mailSentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class=" modal-dialog">
            <div class="modal-content shadow p-2 rounded maindiv">
                <div class="modal-header">
                    <label for="enter maessage" class="fw-bold mb-2" style="color: #6e20a7;font-size: 20px;">Message To
                        Pending Students</label>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST" id="send" class="p-3">
                    <!--<label for="subject" class="h5 my-2 fw-bold" style="color: #165BAA;">Subject</label>-->
                    <!--<input type="text" class="form-control shadow-none" id='email_sub' placeholder="Enter Your Subject" required>-->
                    <label for="mailHeading" class="h5 my-2 fw-bold" style="color: #165BAA;">Title</label>
                    <input type="text" name="" id="mailHeading" class="form-control shadow-none rounded" required>
                    <label for="email_text" class="h5 my-2 fw-bold" style="color: #165BAA;">Message</label>
                    <textarea class="form-control shadow-none rounded" name="" id="email_text" cols="50" rows="5"
                        autofocus required></textarea>
                    <div class="d-flex justify-content-between mt-2 modal-body">
                        <button type="button" class="btn shadow-none my-3 rounded fw-bold bg-dark text-white"
                            data-bs-dismiss="modal">Back</button>
                        <button type="submit" class="btn my-3 shadow-none bg-success text-white fw-bold uploadBtn"><img
                                src="./assect/logo/fileupload.gif" class="me-1 pb-1 d-none" width="20px">Send</button>
                    </div>
                </form>

            </div>
        </div>
    </div>