<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom CSS for styling */
        .container {
            margin-top: 20px;
        }
        .service-section {
            background-color: #f8f9fa; /* Bootstrap background color */
            padding: 20px;
            border-radius: 10px;
        }
        .details-section {
            background-color: #e9ecef; /* Bootstrap background color */
            padding: 20px;
            border-radius: 10px;
        }
            /* Add styles for the <i> element here */
                .service-price {
            font-size: 16px;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <!-- Check if there's a flashed message and display it -->
@if(session()->has('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif

    <div class="container">
        <h1 class="text-center">Monthly SEO & Content Management Services</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="service-section">
                    <h2>SEO Optimization</h2>
                    <p>Our monthly SEO optimization service includes keyword research, on-page SEO, backlink building, and performance tracking.</p>
                    <h3>Price: <i class="service-price">price on invoice</i></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-section">
                    <h2>Content Management</h2>
                    <p>Our content management service includes content creation, publishing, and optimization for SEO.</p>
                    <h3>Price: <i class="service-price">price on invoice</i></h3>
                </div>
            </div>
        </div>
        <!-- Details Section -->
        <div class="details-section mt-4">
            <h2>Details</h2>
            <form action="{{ route('pay') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="Name" name="firstName" placeholder="Enter first name">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number">
                </div>
                <div class="mb-3">
                    <label for="services" class="form-label">Select Services:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="seo" id="seoService" name="services[]">
                        <label class="form-check-label" for="seoService">SEO Optimization</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="content" id="contentService" name="services[]">
                        <label class="form-check-label" for="contentService">Content Management</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Select Your Location/Country:</label>
                    <select class="form-select" id="location" name="location">
                        @foreach ($countries as $country)
                            <option value="{{ $country['AlphabeticCode'] }}">{{ $country['Entity'] }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="mb-3">
                    <label for="detailsAmount" class="form-label">Enter Amount </label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="Enter additional amount">
                        <span class="input-group-text bg-primary text-white" id="localCurrency" style="border-radius: 0 5px 5px 0;">Local Currency</span>
                        <span class="input-group-text" id="convertedAmount" style="background-color: #f8f9fa; border-radius: 5px 0 0 5px;"><!-- The strong/bold style comes from the server --> </span>
                    </div>

                <!--<h4>Total Amount: <span id="totalAmount">$0</span></h4> -->
                <button class="btn btn-primary btn-lg float-end">Pay</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  </form>
            <!-- JavaScript to Send Data and Display Converted Amount -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                // Function to fetch and display converted amount
                function updateConvertedAmount() {
                    var paymentAmount = $('#paymentAmount').val();

                    // Only proceed if paymentAmount is not empty
                    if (paymentAmount !== '') {
                        var location = $('#location').val();

                        $.ajax({
                            url: '/convert-amount', // Your route for converting the amount
                            type: 'post',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'paymentAmount': paymentAmount,
                                'location': location
                            },
                            success: function (response) {
                                $('#convertedAmount').html(response);
                                console.log(response); // Log the response to the console
                            },
                            error: function () {
                                $('#convertedAmount').html('Conversion test failed. Please check your input.');
                            }
                        });
                    } else {
                        $('#convertedAmount').html('Amount in your Currency:');
                    }
                }

                // Trigger the conversion when the paymentAmount field is changed (user input)
                $('#paymentAmount').on('input', updateConvertedAmount);

                // Initial conversion when the page loads
                updateConvertedAmount();

                // Prevent the form from submitting (handled separately for payment)
                $('#paymentForm').submit(function (e) {
                    e.preventDefault();
                });
            });
        </script>

</body>
</html>
