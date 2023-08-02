<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="insertData">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                                <input type="hidden" id="update_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateCust" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#CloseCreateCust").on('click', function(e) {
        document.getElementById('update_id').value = '';
        document.getElementById('customerName').value = '';
        document.getElementById('customerEmail').value = '';
        document.getElementById('customerMobile').value = '';
        e.preventDefault();
        $('#create-modal').modal('hide');
        document.getElementById('categoryName').value = '';

    })
    $("#insertData").on('submit', async function(e) {
        e.preventDefault();
        let update_id = $("#update_id").val();
        if (update_id == "") {
            let customerName = document.getElementById('customerName').value;
            let customerEmail = document.getElementById('customerEmail').value;
            let customerMobile = document.getElementById('customerMobile').value;
            if (customerName.length === 0) {
                errorToast("Name Required !")
            } else if (customerEmail.length === 0) {
                errorToast("Email Required !")
            } else if (customerMobile.length === 0) {
                errorToast("Mobile Required !")
            } else {
                $('#create-modal').modal('hide');
                showLoader();
                let res = await axios.post("/create-customer", {
                    name: customerName,
                    email: customerEmail,
                    mobile: customerMobile
                })
                // console.log(res.data);
                hideLoader();
                if (res.data.status == "success") {
                    successToast('Request completed');
                    $("#insertData").trigger("reset");
                    await getList();
                } else if(res.data.status == "error") {
                    errorToast(res.data.message)
                }
            }
        } else {


            let customerName = document.getElementById('customerName').value;
            let customerEmail = document.getElementById('customerEmail').value;
            let customerMobile = document.getElementById('customerMobile').value;

            let id = document.getElementById('update_id').value;


             if (customerName.length === 0) {
                errorToast("Name Required !")
            } else if (customerEmail.length === 0) {
                errorToast("Email Required !")
            } else if (customerMobile.length === 0) {
                errorToast("Mobile Required !")
            } else {
                $('#create-modal').modal('hide');
                showLoader();
                let res = await axios.post("/update-customer", {
                    id: id,
                    name: customerName,
                    email: customerEmail,
                    mobile: customerMobile
                });
                // console.log(res.data);
                document.getElementById('update_id').value = '';
                hideLoader();
                if (res.data.status == "success") {
                    successToast('Customer Information Updated');
                    $("#insertData").trigger("reset");
                    await getList();
                    
                } else if(res.data.status == "error") {
                    $('#create-modal').modal('show');
                    errorToast(res.data.message)
                }

            }



        }



    })
</script>
