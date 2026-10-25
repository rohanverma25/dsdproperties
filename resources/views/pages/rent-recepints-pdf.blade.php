<!DOCTYPE html>
<html>
<head>
    <title>Rent Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 16px; }
        .box { border: 1px solid #000; padding: 20px; margin: 20px auto; width: 90%; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Rent Receipt</h2>
        <p><strong>Tenant Name:</strong> {{ $data['tenant_name'] }}</p>
        <p><strong>Owner Name:</strong> {{ $data['owner_name'] }}</p>
        <p><strong>Rent Amount:</strong> ₹{{ number_format($data['rent_amount']) }}</p>
        <p><strong>Owner PAN:</strong> {{ $data['owner_pan'] }}</p>
        <p><strong>Property Address:</strong> {{ $data['rented_property_address'] }}</p>
        <p><strong>Owner Address:</strong> {{ $data['owner_address'] }}</p>
        <p><strong>Period:</strong> {{ $data['receipt_start_date'] }} to {{ $data['receipt_end_date'] }}</p>
    </div>
</body>
</html>
