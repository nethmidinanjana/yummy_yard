let defaultTransform = 0;
let intervalId;

function goNext() {
    defaultTransform = defaultTransform - 398;
    var slider = document.getElementById("slider");
    if (Math.abs(defaultTransform) >= slider.scrollWidth / 1.7) defaultTransform = 0;
    slider.style.transform = "translateX(" + defaultTransform + "px)";
}

function goPrev() {
    var slider = document.getElementById("slider");
    if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
    else defaultTransform = defaultTransform + 398;
    slider.style.transform = "translateX(" + defaultTransform + "px)";
}

function startAutoSlide() {
    intervalId = setInterval(goNext, 5500); // time
}

function stopAutoSlide() {
    clearInterval(intervalId);
}

document.getElementById("next").addEventListener("click", function () {
    stopAutoSlide();
    goNext();
    startAutoSlide();
});

document.getElementById("prev").addEventListener("click", function () {
    stopAutoSlide();
    goPrev();
    startAutoSlide();
});

// Start auto slide initially
startAutoSlide();

// Scroll to the Home section
function scrolltoHome() {
    document.getElementById("home-section").scrollIntoView({
        behavior: 'smooth'
    });
}

function changeView() {
    var signUpBox = document.getElementById("signupbox");
    var signInBox = document.getElementById("signinbox");

    signUpBox.classList.toggle("hidden");
    signInBox.classList.toggle("hidden");

    if (signUpBox.classList.contains("hidden")) {
        toggleLink.textContent = "Don't have an account? Sign up";
    } else {
        toggleLink.textContent = "Already has an account? Sign In";
    }
}

function scrollToAllFoods() {
    window.location.href = "all_foods.php";
}

function navigateToSingleProductView() {
    window.location.href = "single_product_view.php";
}

function NavigateToBasket() {
    window.location.href = "basket.php";
}

function navigateToSignUp() {
    window.location.href = "signup.php";
}

function passwordShow() {
    var passwordInput = document.getElementById('password');
    var showPasswordButton = document.getElementById('showPassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        showPasswordButton.textContent = 'Show';
    }
}

function confirmPasswordShow() {
    var passwordInput = document.getElementById('confirm_password');
    var showPasswordButton = document.getElementById('showConfirmPassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        showPasswordButton.textContent = 'Show';
    }
}

function signInPasswordSHow() {
    var passwordInput = document.getElementById('signin_password');
    var showPasswordButton = document.getElementById('showSigninPassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        showPasswordButton.textContent = 'Show';
    }
}

function signUp(event) {
    event.preventDefault();
    const first_name = document.getElementById("first_name").value;
    const last_name = document.getElementById("last_name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;
    const confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        document.getElementById("passwordMatchError").classList.remove("hidden");
        document.getElementById("passwordMatchError").innerText = "Passwords do not match.";
        return;
    }

    const form = new FormData;
    form.append("first_name", first_name);
    form.append("last_name", last_name);
    form.append("email", email);
    form.append("phone", phone);
    form.append("password", password);

    const request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            const response = request.responseText;
            if (response.trim() === "success") {
                document.getElementById("signupbox").classList.add("hidden");
                document.getElementById("signinbox").classList.remove("hidden");
            } else {
                document.getElementById("passwordMatchError").innerHTML = response;
                document.getElementById("passwordMatchError").classList.remove("hidden");
            }
        }
    }

    request.open("POST", "signUpProcess.php", true);
    request.send(form);

}


function signIn(event) {
    event.preventDefault();
    var email = document.getElementById("signin_email");
    var password = document.getElementById("signin_password");
    var rememberme = document.getElementById("rememberme");

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);
    f.append("r", rememberme.checked);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "index.php";
            } else {
                document.getElementById("incorrectPassword").innerHTML = t;
                document.getElementById("incorrectPassword").classList.remove("hidden");
            }
        }
    }

    r.open("POST", "signInProcess.php", true);
    r.send(f);

}


function signout() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            }
        }
    }

    r.open("GET", "signoutProcess.php", true);
    r.send();

}

function updateProfile() {
    var fname = document.getElementById("first_name");
    var lname = document.getElementById("last_name");
    var mobile = document.getElementById("phone");
    var line1 = document.getElementById("address_line1");
    var line2 = document.getElementById("address_line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var gender = document.getElementById("gender");

    var f = new FormData();
    f.append("fname", fname.value);
    f.append("lname", lname.value);
    f.append("mobile", mobile.value);
    f.append("line1", line1.value);
    f.append("line2", line2.value);
    f.append("province", province.value);
    f.append("district", district.value);
    f.append("city", city.value);
    f.append("gender", gender.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "updateProfileProcess.php", true);
    r.send(f);
}

ScrollReveal().reveal('.hero-div-animate', {
    origin: 'bottom',
    distance: '50px',
    duration: 1500,
    delay: 300,
    easing: 'ease-in-out',
    reset: true
});

ScrollReveal().reveal('.about-div-animate', {
    origin: 'bottom',
    distance: '50px',
    duration: 2000,
    delay: 400,
    easing: 'ease-in-out',
    reset: true
});


ScrollReveal().reveal('.category-div-animate', {
    origin: 'left',
    distance: '50px',
    duration: 1000,
    delay: 300,
    easing: 'ease-in-out',
    reset: true
});

ScrollReveal().reveal('.fav-div-animate', {
    origin: 'bottom',
    distance: '50px',
    duration: 1000,
    delay: 200,
    easing: 'ease-in-out',
    opacity: 0,
    scale: 0.8,
    reset: true
});

ScrollReveal().reveal('.special-div-animate', {
    origin: 'right',
    distance: '50px',
    duration: 1000,
    delay: 300,
    easing: 'ease-in-out',
    reset: true
});

const toggleButton = document.getElementById('sidebarToggle');
const sidebar = document.querySelector('.sidebar');
const content = document.querySelector('.content');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    content.classList.toggle('active');
});

var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function () {
    modal.style.display = "block";
}

span.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function forgotPassword() {
    // Disable the link after clicking once
    var link = document.getElementById('forgotPasswordLink');
    link.onclick = null; // Remove the click event
    link.style.pointerEvents = 'none'; // Disable further clicking
    link.style.color = 'gray'; // Optionally, change the color to indicate it's disabled

    var email = document.getElementById("signin_email").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var response = r.responseText;
            if (response === "success") {
                alert("Verification code has been sent to your email. Please check your inbox.");
                showModal();
            } else {
                alert(response);
            }
        }
    };

    r.open("GET", "forgotPasswordProcess.php?e=" + encodeURIComponent(email), true);
    r.send();
}

function showModal() {
    document.getElementById("resetPasswordModal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("resetPasswordModal").classList.add("hidden");
}

function submitResetPassword() {
    var verificationCode = document.getElementById("verification_code").value;
    var newPassword = document.getElementById("new_password").value;

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var response = r.responseText;
            if (response === "success") {
                alert("Password reset successfully!");
                closeModal();
            } else {
                alert(response);
            }
        }
    };

    r.open("POST", "resetPasswordProcess.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("code=" + encodeURIComponent(verificationCode) + "&password=" + encodeURIComponent(newPassword));
}

// Event listener to close the modal when clicking outside of it
window.onclick = function (event) {
    var modal = document.getElementById("resetPasswordModal");
    if (event.target == modal) {
        modal.classList.add("hidden");
    }
};


function forgotPasswordSHow() {
    var passwordInput = document.getElementById('forgot_password');
    var showPasswordButton = document.getElementById('showForgotPassword');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        showPasswordButton.textContent = 'Show';
    }
}

function forgotPasswordRTSHow() {
    var passwordInput = document.getElementById('forgot_passwordRT');
    var showPasswordButton = document.getElementById('showForgotPasswordRT');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        showPasswordButton.textContent = 'Show';
    }
}

function resetpw() {
    var email = document.getElementById("signin_email");
    var np = document.getElementById("forgot_password");
    var rnp = document.getElementById("forgot_passwordRT");
    var vcode = document.getElementById("verification_code");

    var f = new FormData();
    f.append("e", email.value);
    f.append("n", np.value);
    f.append("r", rnp.value);
    f.append("v", vcode.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                alert("Your Password Updated");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "resetPassword.php", true);
    r.send(f);
}

function loadDistrict() {

    var province = document.getElementById("province").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("district").innerHTML = t;
        }
    }

    r.open("GET", "loadDistricts.php?p=" + province, true);
    r.send();
}

function loadCity() {

    var district = document.getElementById("district").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("city").innerHTML = t;
        }
    }

    r.open("GET", "loadCity.php?d=" + district, true);
    r.send();
}

// admin side

function adminSignIn(event) {
    event.preventDefault();
    var email = document.getElementById("signin_email");
    var password = document.getElementById("signin_password");

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                // alert(t);
                window.location = "dashboard.php";
            } else {
                document.getElementById("incorrectPassword").innerHTML = t;
                document.getElementById("incorrectPassword").classList.remove("hidden");
            }
        }
    }

    r.open("POST", "adminSignInProcess.php", true);
    r.send(f);
}

function adminSignout() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = 'adminLogin.php';
            }
        }
    }

    r.open("GET", "adminSignout.php", true);
    r.send();

}

function loadSubCategory() {

    var category = document.getElementById("category").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            document.getElementById("sub_category").innerHTML = t;
        }
    }

    r.open("GET", "loadSubCategory.php?c=" + category, true);
    r.send();
}

function changeProductImage() {
    var imageUploader = document.getElementById("imageuploader");

    imageUploader.onchange = function () {
        var file_count = imageUploader.files.length;
        var maxFileSize = 10 * 1024 * 1024; // 10 MB in bytes
        var totalFileSize = 0;

        // Calculate total file size
        for (var i = 0; i < file_count; i++) {
            totalFileSize += imageUploader.files[i].size;
        }

        // Check if total file size exceeds the maximum allowed size
        if (totalFileSize > maxFileSize) {
            alert("Total file size exceeds the maximum allowed limit of 10 MB. Please reduce the size of your files.");
            // Reset file input to clear selected files (optional)
            imageUploader.value = null;
            return; // Exit function to prevent further processing
        }

        // Display selected images
        for (var i = 0; i < 3; i++) {
            document.getElementById("i" + i).src = "../resources/addprdctimg.png";
        }

        for (var x = 0; x < file_count; x++) {
            var file = this.files[x];
            var url = window.URL.createObjectURL(file);
            document.getElementById("i" + x).src = url;
        }

        // Inform user if more than 3 files are selected
        if (file_count > 3) {
            alert(file_count + " files selected. You can upload only 3 or less images.");
        }
    };
}


function addProduct(event) {
    event.preventDefault();

    var pname = document.getElementById("pname");
    var description = document.getElementById("description");
    var category = document.getElementById("category");
    var sub_category = document.getElementById("sub_category");
    var qty = document.getElementById("qty");
    var price = document.getElementById("price");
    var size = document.getElementById("size");
    var image = document.getElementById("imageuploader");

    var f = new FormData();
    f.append("pname", pname.value);
    f.append("des", description.value);
    f.append("ca", category.value);
    f.append("subca", sub_category.value);
    f.append("qty", qty.value);
    f.append("price", price.value);
    f.append("size", size.value);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {

        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t.includes("Product added successfully")) {
                alert("Product added successfully");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

}

function openABModal(button) {
    const productId = button.getAttribute('data-product-id');
    document.getElementById(`addToBasketModal-${productId}`).classList.remove('hidden');
}

function closeABModal(productId) {
    document.getElementById(`addToBasketModal-${productId}`).classList.add('hidden');
}

function addToBasket(productId) {
    var quantity = document.getElementById(`product-qty-${productId}`).value;

    if (!quantity || quantity < 1) {
        alert('Please enter a valid quantity.');
        return;
    }

    var formData = new FormData();
    formData.append("qty", quantity);
    formData.append("pid", productId);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var response = xhr.responseText;
            alert(response);
            window.location.reload();
        }
    };

    xhr.open("POST", "addToBasketProcess.php", true);
    xhr.send(formData);
}


function deleteFromCart(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t = "success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "deleteFromCartProcess.php?id=" + id, true);
    r.send();
}

function removeProduct(button) {
    var productId = button.getAttribute('data-product-id');

    if (confirm("Are you sure you want to remove this product?")) {
        var formData = new FormData();
        formData.append("pid", productId);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText.trim();

                if (response === 'Product removed successfully') {
                    window.location.reload();
                }
            }
        };

        xhr.open("POST", "productRemovalProcess.php", true);
        xhr.send(formData);
    }
}

function reAddProduct(button) {
    var productId = button.getAttribute('data-product-id');

    if (confirm("Are you sure you want to re-add this product?")) {
        var formData = new FormData();
        formData.append("pid", productId);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText.trim();

                if (response === 'Product addedd successfully') {
                    window.location.reload();
                }
            }
        };

        xhr.open("POST", "productReAddingProcess.php", true);
        xhr.send(formData);
    }
}

function blockUser(button) {
    var userId = button.getAttribute('data-user-id');

    if (confirm("Are you sure you want to block this user?")) {
        var formData = new FormData();
        formData.append("uid", userId);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText.trim();

                if (response === 'User Blocked successfully') {
                    window.location.reload();
                }
            }
        };

        xhr.open("POST", "blockUserProcess.php", true);
        xhr.send(formData);
    }
}

function unBlockUser(button) {
    var userId = button.getAttribute('data-user-id');

    if (confirm("Are you sure you want to unblock this user?")) {
        var formData = new FormData();
        formData.append("uid", userId);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText.trim();

                if (response === 'User Unblocked successfully') {
                    window.location.reload();
                }
            }
        };

        xhr.open("POST", "unBlockUserProcess.php", true);
        xhr.send(formData);
    }
}

function openModal(foodId) {
    document.getElementById('orderModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('orderModal').classList.add('hidden');
}

function orderNow(pid) {
    var quantity = document.getElementById('quantity').value;

    if (quantity > 0) {
        closeModal();

        var formData = new FormData();
        formData.append("pid", pid);
        formData.append("qty", quantity);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4) {
                if (xhttp.status == 200) {
                    try {
                        var rawResponse = xhttp.responseText;
                        console.log('Raw response:', rawResponse);
                        var obj = JSON.parse(rawResponse);

                        var amount = obj["amount"];
                        var uid = obj["uid"];



                        if (obj.error) {
                            if (obj.error === "profile error") {
                                alert("Please update your profile entering your address data before ordering.");
                                window.location = "account.php";
                            } else if (obj.error === "login error") {
                                alert("Please login first.");
                                window.location = "signup.php";
                            } else {
                                alert(obj.error);
                            }
                        } else {

                            // Payment completed. It can be a successful failure.


                            payhere.onCompleted = function onCompleted(OrderID) {
                                console.log("Payment completed. OrderID:" + OrderID);
                                var oid = obj["order_id"];
                                saveInvoice(oid, pid, uid, amount, quantity);
                                // Note: validate the payment and show success or failure page to the customer
                            };

                            // Payment window closed
                            payhere.onDismissed = function onDismissed() {
                                // Note: Prompt user to pay again or show an error page
                                console.log("Payment dismissed");
                            };

                            // Error occurred
                            payhere.onError = function onError(error) {
                                // Note: show an error page
                                console.log("Error:" + error);
                            };

                            var payment = {
                                "sandbox": true,
                                "merchant_id": "1221412",
                                "return_url": "http://localhost/yummy_yard/src/single_product_view.php?id=32",
                                "cancel_url": "http://localhost/yummy_yard/src/single_product_view.php?id=32",
                                "notify_url": "http://sample.com/notify",
                                "order_id": obj["order_id"],
                                "items": obj["item"],
                                "amount": obj["amount"],
                                "currency": obj["currency"],
                                "hash": obj["hash"],
                                "first_name": obj["fname"],
                                "last_name": obj["lname"],
                                "email": obj["email"],
                                "phone": obj["phone"],
                                "address": obj["address"],
                                "city": obj["city"],
                                "country": "Sri Lanka",
                                "delivery_address": obj["address"],
                                "delivery_city": obj["city"],
                                "delivery_country": "Sri Lanka",
                                "custom_1": "",
                                "custom_2": ""
                            };
                            console.log(payment);
                            payhere.startPayment(payment);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                } else {
                    console.error('Error occurred while processing request:', xhttp.statusText);
                }
            }
        };

        xhttp.open("POST", "paymentProcess.php", true);
        xhttp.send(formData);
    } else {
        alert("Please enter a valid quantity.");
    }
}

function saveInvoice(oid, pid, uid, amount, quantity) {

    console.log("Saving invoice...");
    console.log("Order ID:", oid);
    console.log("Product ID:", pid);
    console.log("User ID:", uid);
    console.log("Amount:", amount);
    console.log("Quantity:", quantity);

    var f = new FormData();
    f.append("o", oid);
    f.append("i", pid);
    f.append("u", uid);
    f.append("a", amount);
    f.append("q", quantity);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            console.log('Save invoice response:', t);
            if (t == "success") {
                alert("Order success. Check your email for order details.");
            } else {
                alert("Save invoice failed: " + t);
            }
        }
    };

    r.open("POST", "saveInvoice.php", true);
    r.send(f);
}

function checkOut() {
    const cartItems = [];
    document.querySelectorAll('.cart-item').forEach(item => {
        const productId = item.dataset.productId;
        const quantity = item.querySelector('.product-quantity').innerText;
        cartItems.push({ productId, quantity });
    });

    if (cartItems.length > 0) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "checkoutProcess.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Initiate payment gateway
                            payhere.onCompleted = function onCompleted(orderId) {
                                finalizeOrder(response.order_id);
                            };

                            payhere.onDismissed = function onDismissed() {
                                alert("Payment was dismissed.");
                            };

                            payhere.onError = function onError(error) {
                                alert("Error: " + error);
                            };

                            const payment = {
                                "sandbox": true,
                                "merchant_id": "1221412",
                                "return_url": "http://localhost/yummy_yard/src/basket.php",
                                "cancel_url": "http://localhost/yummy_yard/src/basket.php",
                                "notify_url": "notifyPayment.php",
                                "order_id": response.order_id,
                                "items": response.items,
                                "amount": response.total_amount,
                                "currency": response.currency,
                                "hash": response.hash,
                                "first_name": response.first_name,
                                "last_name": response.last_name,
                                "email": response.email,
                                "phone": response.phone,
                                "address": response.address,
                                "city": response.city,
                                "country": "Sri Lanka",
                                "delivery_address": response.address,
                                "delivery_city": response.city,
                                "delivery_country": "Sri Lanka",
                                "custom_1": "",
                                "custom_2": ""
                            };

                            payhere.startPayment(payment);
                        } else {
                            alert("Checkout failed: " + response.message);
                            console.log(response);
                        }
                    } catch (e) {
                        console.error("Error parsing JSON response: ", e);
                        console.log(xhr.responseText);
                    }
                } else {
                    console.error("HTTP error: ", xhr.status, xhr.statusText);
                }
            }
        };
        xhr.send(JSON.stringify({ cartItems }));
    } else {
        alert("Your cart is empty!");
    }
}


function finalizeOrder(orderId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "finalizeOrder.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Checkout successful! Check you email for order details.");
                window.location.reload();
            } else {
                alert("Checkout failed: " + response.message);
            }
        }
    };
    xhr.send(JSON.stringify({ order_id: orderId }));
}

function deleteOrder(oid) {

    if (confirm("Are you sure you want to remove this order details?")) {
        var formData = new FormData();
        formData.append("oid", oid);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText.trim();

                if (response === 'success') {
                    alert("Order Details removed successfully.");
                    window.location.reload();
                } else {
                    alert("Failed to remove order details.");
                }
            }
        };

        xhr.open("POST", "orderRemovalProcess.php", true);
        xhr.send(formData);
    }
}

function changeInvoiceStatus(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == 3) {
                document.getElementById("btn" + id).innerHTML = "On Delivery";
                document.getElementById("btn" + id).classList = "focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800";
                window.location.reload();

            } else if (t == 4) {
                document.getElementById("btn" + id).innerHTML = "Delivered";
                document.getElementById("btn" + id).classList = "text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700";
                window.location.reload();

            } else if (t == 5) {
                document.getElementById("btn" + id).innerHTML = "Delete Order";
                document.getElementById("btn" + id).classList = "focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mt-2  dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900";
                window.location.reload();

            } else {
                window.location.reload();
            }
        }
    }

    r.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
    r.send();
}

function updateProduct(event, pid, fdid) {
    event.preventDefault();

    var pname = document.getElementById("pname");
    var description = document.getElementById("description");
    var category = document.getElementById("category");
    var sub_category = document.getElementById("sub_category");
    var qty = document.getElementById("qty");
    var price = document.getElementById("price");
    var size = document.getElementById("size");
    var image = document.getElementById("imageuploader");

    var f = new FormData();
    f.append("pid", pid);
    f.append("fdid", fdid);
    f.append("pname", pname.value);
    f.append("des", description.value);
    f.append("ca", category.value);
    f.append("subca", sub_category.value);
    f.append("qty", qty.value);
    f.append("price", price.value);
    f.append("size", size.value);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {

        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t.includes("Product updated successfully")) {
                alert("Product updated successfully");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "updateProductProcess.php", true);
    r.send(f);

}

function searchFoods() {

    var category = document.getElementById('categoryDropdown').value;
    var searchQuery = document.getElementById('searchInput').value;
    var sortPrice = document.getElementById('sortPriceDropdown').value;

    var searchParams = {
        searchCategoryInput: category,
        searchInput: searchQuery,
        sortPriceInput: sortPrice
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'basicSearchProcess.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            document.getElementById('resultsContainer').innerHTML = xhr.responseText;
        }
    };
    xhr.send(JSON.stringify(searchParams));
}


function searchProducts() {
    const category = document.getElementById('searchCategoryInput2').value;
    const searchQuery = document.getElementById('searchInput2').value;

    const data = {
        searchCategoryInput: category,
        searchInput: searchQuery
    };

    fetch('productSearch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.text())
        .then(result => {
            document.getElementById('resultsContainer').innerHTML = result;
        })
        .catch(error => console.error('Error:', error));
}

function searchUser() {
    const searchQuery = document.getElementById('userSearch').value;
    const data = {
        searchInput: searchQuery
    };

    fetch('usertSearch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.text())
        .then(result => {
            document.getElementById('resultsContainer').innerHTML = result;
        })
        .catch(error => console.error('Error:', error));
}

function addMainCategory() {
    var categoryElement = document.getElementById("category_name");

    if (categoryElement) {
        var category = categoryElement.value;

        var f = new FormData();
        f.append("txt", category);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;
                if (t.includes("success")) {
                    alert("Category added successfully");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("POST", "addNewCategory.php", true);
        r.send(f);
    } else {
        alert("Category element not found");
    }
}

function addSubC() {
    var name = document.getElementById("sub_category_name");
    var category = document.getElementById("category").value;

    if (name) {
        var sc = name.value;
        var f = new FormData();
        f.append("txt", sc);
        f.append("c", category);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;
                if (t.includes("success")) {
                    alert("Sub Category added successfully");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("POST", "addSubCategory.php", true);
        r.send(f);

    } else {
        alert("Sub Category element not found");
    }
}

function addTodaySpecial() {
    var form = document.getElementById("specialForm");

    var formData = new FormData(form);

    var fileInput = document.getElementById("file_input");
    if (fileInput.files.length > 0) {
        formData.append("file", fileInput.files[0]);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "addTodaySpecial.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var t = xhr.responseText;
            if (t == "success") {
                alert("Today's special added successfully!");
                window.location.reload();
            } else {
                alert(t);
            }

        };
    };

    xhr.onerror = function () {
        alert("An error occurred during the request.");
    };

    xhr.send(formData);
}

function openModal(foodId) {
    document.getElementById('foodId').value = foodId;
    document.getElementById('feedbackModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('feedbackModal').classList.add('hidden');
}

function addFeedback() {
    var feedback = document.getElementById("feedback").value;
    var foodId = document.getElementById("foodId").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                var response = xhr.responseText;
                if (response.includes("success")) {
                    alert("Feedback added successfully");
                    window.location.reload();
                } else {
                    alert(response);
                }
            } else {
                alert('There was a problem with the request.');
            }
        }
    };

    xhr.open("POST", "addFeedback.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("fid=" + encodeURIComponent(foodId) + "&f=" + encodeURIComponent(feedback));
}