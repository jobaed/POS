<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control"
                                    type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="fname"  placeholder="First Name" class="form-control"
                                    type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lname"  placeholder="Last Name" class="form-control"
                                    type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="phone"  placeholder="Mobile" class="form-control"
                                    type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" type="text" placeholder="User Password" class="form-control"
                                    type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Save
                                    Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile()
    async function getProfile() {

        showLoader();
        let res = await axios.get('/user-profile');
        hideLoader()

        console.log(res.data)


        if (res.status === 200 && res.data['status'] === 'success') {
            let data = res.data['data'];

            document.getElementById('email').value = data['email'];
            document.getElementById('fname').value = data['firstName'];
            document.getElementById('lname').value = data['lastName'];
            document.getElementById('phone').value = data['mobile'];
            document.getElementById('password').value = data['password'];


        } else if(res.data['status'] === 'failed') {
            errorToast("Something Went Wrong");
        }




    }


    async function onUpdate() {


        let password = document.getElementById('password').value;
        let firstName = document.getElementById('fname').value;
        let lastName = document.getElementById('lname').value;
        let mobile = document.getElementById('phone').value;


        if (password.length === 0) {
            errorToast("Password Required !")
        } else if (firstName.length === 0) {
            errorToast("First Name Required")
        } else if (lastName.length === 0) {
            errorToast("Last Name Required")
        } else if (mobile.length === 0) {
            errorToast("Mobile Number Required !")
        } else {


            showLoader();
            let data = {
                firstName: firstName,
                lastName: lastName,
                password: password,
                mobile: mobile
            }
            let res = await axios.post("/userUdate", data)
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast(res.data['message']);
                await getProfile()
            } else {
                errorToast(res.data['message']);
            }



        }
    }
</script>
