<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Product</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" id="createProBtn" data-bs-target="#create-modal"
                            class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        {{-- Table Data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(async function() {
        showLoader();
        let res = await axios.get("/list-category");
        hideLoader();

        const categorySelect = document.getElementById('catSelect');

        // console.log(res.data.data);

        res.data.data.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });


    });


    getList();


    async function getList() {

        showLoader();
        let res = await axios.get("/list-product");
        hideLoader();

        // console.log(res.data.data);


        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();

        


        res.data['data'].forEach(function(item, index) {
            let row = `<tr>
                    <td>${index+1}</td>
                    <td><img alt="" class="img-fluid" src="/${item['img_url']}"></td>
                    <td>${item['name']}</td>
                    <td>${item['price']}</td>
                    <td>${item['unit']}</td>
                    <td>
                        <button data-id="${item['id']}" data-name="${item.name}"  class="btn edit btn-sm btn-outline-success" id="proEditBtn">Edit</button>
                        <button data-id="${item['id']}" data-name="${item.name}" class="btn delete btn-sm btn-outline-danger">Delete</button>
                    </td>
                </tr>`;
            tableList.append(row);
        });


        $('.edit').on('click', async function() {
            let id = $(this).data('id');

            let res = await axios.post('/singleProduct', {
                id: id
            });


            $("#update_id").val(id);
            $("#productName").val(res.data['name']);
            let catId = res.data['category_id'];
            let unit = res.data['unit'];
            $("#productPrice").val(res.data['price']);
            $("#productPrice").val(res.data['price']);
            $("#newImg").attr('src', res.data['img_url']);
            $("#imageLabel").addClass("d-none");

            $('#catSelect > option').each(function() {
                if($(this).val() == catId){
                    $(this).attr("selected","selected"); 
                }
            });

            $('#productUnit > option').each(function() {
                if($(this).val() == unit){
                    $(this).attr("selected","selected"); 
                }
            });


            $("#create-modal").modal('show');

            // console.log(res.data);
        });



        $('.delete').on('click', async function() {

            let id = $(this).data('id');

            let res = await axios.post('/singleProduct', {
                id: id
            });


            let name = res.data['name'];
            $(".catName").text(name);
            $(".catID").html(id);
            $(".filePath").html(res.data['img_url']);

            $("#delete-modal").modal('show');

            
        });

        $('#createProBtn').on('click', function() {
            ("imageLabel").removeClass("d-none");
        });

        tableData.DataTable({
            order:[[0,'desc']],
            lengthMenu: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }
</script>
