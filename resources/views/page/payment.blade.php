<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FlutterPay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center bg-primary py-5 text-white">
            <h1>Pay for Service</h1>
        </div>
        <div class="main mt-4">
            @if(session('payment_success'))
                <div class="alert alert-success">
                    {{ session('payment_success') }}
                </div>
            @endif
            <form id="makePayment" action="{{ route('payment') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                    </div>
                </div>
                <button type="submit" id="start-payment-button" class="btn btn-primary btn-block">Pay Now</button>
            </form>
        </div>
    </div>


<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var startPaymentButton = document.getElementById("start-payment-button");
        startPaymentButton.addEventListener("click", function (event) {
            event.preventDefault();

            // Replace with your actual Flutterwave public key
            var publicKey = "FLWPUBK_TEST-0e0cd6eefe6670d3b36f2b2b9d3b177d-X";

            // Replace with your payment details
            var paymentData = {
                public_key: publicKey,
                tx_ref: "TX_REF",
                amount: document.getElementById("amount").value,
                currency: "NGN",
                payment_type: "card",
                customer: {
                    email: document.getElementById("email").value,
                    phone_number: document.getElementById("phone").value,
                    name: document.getElementById("name").value,
                },
            };

            FlutterwaveCheckout({
                ...paymentData,
                callback: function (response) {
                    // Handle payment response here
                    console.log(response);
                },
            });
        });
    });
</script>


</body>
</html>
