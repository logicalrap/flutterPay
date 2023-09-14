<!-- payment-form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
</head>
<body>
    <h1>Payment Form</h1>
    <form action="{{ route('payment.initiate') }}" method="post">
        @csrf
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>

