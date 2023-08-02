<div class="" id="" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form id="sendMailToUser">
            <div class="modal-content">
                <div class="modal-header" style="padding: 2rem">
                    <h5 class="modal-title" id="exampleModalLabel">Promotional Email</h5>
                </div>
                <div class="modal-body" style="padding: 1rem 2rem">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Subject *</label>
                                <input type="text" class="form-control" id="subject">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="mailBody">
                                <label class="form-label">Description *</label>
                                <textarea class="form-control" name="" id="description" cols="30" rows="10"></textarea>
                                <input type="hidden" id="update_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn px-5  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#sendMailToUser").on('submit', async function(e) {
        e.preventDefault();


        let subject = document.getElementById('subject').value;
        let body = document.getElementById('mailBody').value;
        let description = document.getElementById('description').value;


        if (subject === '') {
            errorToast("Subject Required");
        } else if (body === '') {
            errorToast("Body Required");
        } else if (description === '') {
            errorToast("Description Required");
        } else {


            // console.log({
            //     subject,
            //     body,
            //     description
            // });

            showLoader();
            let res = await axios.post('/prom-mail', {
                subject: subject,
                body: body,
                description: description
            });
            hideLoader();

            console.log(res.data);

            if (res.data.status == "success") {
                successToast('Mail Send Successfull. Please Check Your Email Inbox');
                $("#sendMailToUser").trigger("reset");
            } else if (res.data.status == "error") {
                errorToast(res.data.message);
            }


        }


    });
</script>
