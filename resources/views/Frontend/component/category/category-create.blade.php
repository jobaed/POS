<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="insertData">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryName">
                                <input type="hidden" id="update_id" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeBtnCreate" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#closeBtnCreate").on('click', function(e) {
        document.getElementById('update_id').value = '';
        e.preventDefault();
        $('#create-modal').modal('hide');
        document.getElementById('categoryName').value = '';

    })
    $("#insertData").on('submit', async function(e) {
        e.preventDefault();
        let update_id = $("#update_id").val();
        if (update_id == "") {
            let categoryName = document.getElementById('categoryName').value;
            if (categoryName.length === 0) {
                errorToast("Category Required !")
            } else {
                $('#create-modal').modal('hide');
                showLoader();
                let res = await axios.post("/create-category", {
                    name: categoryName
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
        }else{
            

            let categoryName = document.getElementById('categoryName').value;
            let id = document.getElementById('update_id').value;
            if (categoryName.length === 0) {
                errorToast("Category Required !")
            } else {
                $('#create-modal').modal('hide');
                showLoader();
                let res = await axios.post("/update-category", {
                    id:id,
                    name: categoryName
                })
                // console.log(res.data);
                document.getElementById('update_id').value = '';
                hideLoader();
                if (res.data.status == "success") {
                    successToast('Request completed');
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
