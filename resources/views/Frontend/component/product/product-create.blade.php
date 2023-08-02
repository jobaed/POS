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

                                <input type="hidden" id="update_id" value="">

                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="productName" placeholder=":Burger">

                                <label class="form-label">Catrgory *</label>
                                <select id="catSelect" class="form-control">
                                    <option value="">Select Catgory</option>
                                </select>

                                <label class="form-label">Price *</label>
                                <input type="text" class="form-control" id="productPrice" placeholder="150.00">

                                <label class="form-label">Unit *</label>
                                <select id="productUnit" class="form-control">
                                    <option value="">Select Unit</option>
                                    <option value="KG">KG</option>
                                    <option value="PCS">PCS</option>
                                    <option value="LITER">LITER</option>
                                </select>

                                <div id="oldimgWrapper">
                                    <label class="form-label">Old Image *</label>
                                    <img src="" id="oldestImg" class="img-fluid" alt="">
                                </div>

                                <label class="form-label">Product Image *</label>
                                <input type="file" accept="image/png, image/gif, image/jpeg" id="productImg"
                                    class="form-control"
                                    value="{{ asset('uploads/11-1690639466-featured-stovetop-burgers-recipe.jpg') }}">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateProd" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $("#CloseCreateProd").on('click', function(e) {
        document.getElementById('update_id').value = '';
        document.getElementById('productName').value = '';
        document.getElementById('catSelect').value = '';
        document.getElementById('productPrice').value = '';
        document.getElementById('productUnit').value = '';
        document.getElementById('productImg').src = '';
        e.preventDefault();
        $('#create-modal').modal('hide');
        document.getElementById('productName').value = '';

    });

    $('#createProBtn').on('click', function() {
        // let id = $(this).data('id');
        // let Name = $(this).data('name');
        // // console.log(Name);
        // $(".catName").text(Name);
        // $("#delete-modal").modal('show');
        // $(".catID").html(id);
        ("#oldimgWrapper").addClass("d-none");
        ("#oldestImg").attr("src", "");;
    });


    $("#insertData").on('submit', async function(e) {
        e.preventDefault();
        let update_id = $("#update_id").val();

        if (update_id == "") {

            var OldImgDiv = document.getElementById('oldimgWrapper');
            OldImgDiv.style.display = 'none';
            OldImgDiv.src = '';

            let productName = document.getElementById('productName').value;
            let productCatrgory = document.getElementById('catSelect').value;
            let productPrice = document.getElementById('productPrice').value;
            let productUnit = document.getElementById('productUnit').value;
            let productImg = document.getElementById('productImg');
            if (productName.length === 0) {
                errorToast("Product Name Required !")
            } else if (productCatrgory.length === 0) {
                errorToast("Product Category Required !")
            } else if (productPrice.length === 0) {
                errorToast("Product Price Required !")
            } else if (productUnit.length === 0) {
                errorToast("Product Unit Required !")
            } else if (productImg.value.length === 0) {
                errorToast("Product Price Required !")
            } else {
                $('#create-modal').modal('hide');
                showLoader();
                const imageFile = productImg.files[0];


                const formData = new FormData();
                formData.append('category_id', productCatrgory);
                formData.append('name', productName);
                formData.append('price', productPrice);
                formData.append('unit', productUnit);
                formData.append('img', imageFile);

                try {
                    const res = await axios.post("/create-product", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });
                    hideLoader();
                    // console.log(res.data);


                    if (res.data.status == "success") {
                        successToast('Product Added Successfull');
                        $("#insertData").trigger("reset");
                        await getList();
                    } else if (res.data.status == "error") {
                        errorToast(res.data.message)
                    }
                } catch (error) {
                    console.error(error);
                    errorToast(error)
                }


            }
        } else {



            let id = document.getElementById('update_id').value;

            let productName = document.getElementById('productName').value;
            let productCatrgory = document.getElementById('catSelect').value;
            let productPrice = document.getElementById('productPrice').value;
            let productUnit = document.getElementById('productUnit').value;
            let productImg = document.getElementById('productImg');
            if (productName.length === 0) {
                errorToast("Product Name Required !")
            } else if (productCatrgory.length === 0) {
                errorToast("Product Category Required !")
            } else if (productPrice.length === 0) {
                errorToast("Product Price Required !")
            } else if (productUnit.length === 0) {
                errorToast("Product Unit Required !")
            } else if (productImg.value.length === 0) {
                errorToast("Product Price Required !")
            } else {

                $('#create-modal').modal('hide');

                const imageFile = productImg.files[0];


                const formData = new FormData();
                formData.append('category_id', productCatrgory);
                formData.append('name', productName);
                formData.append('price', productPrice);
                formData.append('unit', productUnit);
                formData.append('img', imageFile);

                try {
                    showLoader();
                    const res = await axios.post("/create-product", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });
                    hideLoader();

                    if (res.data.status == "success") {
                        successToast('Product Added Successfull');
                        $("#insertData").trigger("reset");
                        await getList();
                    } else if (res.data.status == "error") {
                        errorToast(res.data.message)
                    }
                } catch (error) {
                    console.error(error);
                    errorToast(error)
                }
            }
        }
    });
</script>
