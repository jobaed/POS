<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="inserToDo">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                </div>
                <div class="modal-body">


                    
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <input type="hidden" id="update_id" value="">

                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title"
                                    placeholder=":Enter Your Work , Event">

                                <label class="form-label">Description (Optional)</label>
                                <textarea name="" class="form-control" id="description" cols="30" rows="5"></textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateTodo" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#CloseCreateTodo").on('click', function(e) {

        e.preventDefault();
        $('#create-modal').modal('hide');
        $("#inserToDo").trigger("reset");
        document.getElementById('update_id').value = '';

    });

    $("#inserToDo").on('submit', async function(e) {

        e.preventDefault();

        let title = document.getElementById('title').value;
        let description = document.getElementById('description').value;
        let Userdata = {};

        if (update_id == "") {

            if (title === '') {
                errorToast("Title Required");
            } else if (description === '') {
                Userdata = {
                    title: title
                };
            } else {
                Userdata = {
                    title: title,
                    description: description
                };
            }

            // console.log(Userdata);

            showLoader();
            let res = await axios.post('/create-todo', Userdata);
            hideLoader();

            console.log(res.data);

            if (res.data.status == "success") {
                getList();
                $('#create-modal').modal('hide');
                $("#inserToDo").trigger("reset");
                successToast('Todo Added Successfull');
            } else if (res.data.status == "error") {
                errorToast(res.data.message);
            }


        } else {

            let id = document.getElementById('update_id').value;

            if (title === '') {
                errorToast("Title Required");
            } else if (description === '') {
                Userdata = {
                    id: id,
                    title: title,
                    completed: 0
                };
            } else {
                Userdata = {
                    id: id,
                    title: title,
                    description: description,
                    completed: 0
                };
            }

            // console.log(Userdata);

            showLoader();
            let res = await axios.post('/update-todo', Userdata);
            hideLoader();

            console.log(res);

            if (res.data.status == "success") {
                getList();
                $('#create-modal').modal('hide');
                $("#inserToDo").trigger("reset");
                successToast('Todo Added Successfull');
            } else if (res.data.status == "error") {
                errorToast(res.data.message);
            }



        }





    });
</script>
