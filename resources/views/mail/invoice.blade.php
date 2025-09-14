<?php
$company = $invoices[0]['company'] ?? null;
$factoringCompany = $company ? $company['factoring_company'] : null;
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ count($invoices) === 1 ? 'Invoice Email' : '' }}Invoice Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; }
    </style>
</head>
<body>
<div class="container">

    @if(count($invoices) === 1)
        @php
            $invoice = $invoices[0];
            $load = $invoice['parent_load'];
            $loadStops = collect($load['load_stops']);
            $shipper = $loadStops->where('type', 'Shipper')->first();
            $consignee = $loadStops->where('type', 'Consignee')->sortByDesc('available_from_date')->first();
        @endphp

        <p><strong>Subject:</strong> Invoice #{{ $invoice['number'] }} for Load #{{ $load['internal_id'] }}</p>
        <p>Dear <strong>{{ $factoringCompany['name'] ?? '' }}</strong>,</p>


        <p>
            I hope you’re doing well. Please find attached the invoice #{{ $invoice['number'] }}
            for Load #{{ $load['internal_id'] }} from {{ $shipper['address'] ?? '' }} to {{ $consignee['address'] ?? '' }}.
        </p>
        <p><strong>Invoice Details:</strong></p>
        <ul>
            <li><strong>Load Number:</strong> {{ $load['internal_id'] }}</li>
            <li><strong>Reference Number:</strong> {{ $load['reference'] }}</li>
            <li><strong>Invoice Amount:</strong> ${{ number_format($load['price'], 2) }}</li>
        </ul>
        <span>You can review the attached invoice and let us know if you have any questions. Please process the payment as per the agreed terms.</span>
        <br>
        <span>Let us know if you need any further information.</span>

    @else
        @php
            $companyName = $company['name'] ?? '';
        @endphp
        <p><strong>Subject:</strong> Invoices for Multiple Loads - {{ $companyName }}</p>
        <p>Dear <strong>{{ $factoringCompany['name'] ?? '' }}</strong>,</p>

        <p>I hope you’re doing well. Please find attached the invoices for multiple loads completed during date. Below are the details: </p>
        <table class="table">
            <thead>
            <tr>
                <th>Invoice #</th>
                <th>Load #</th>
                <th>Reference #</th>
                <th>Amount</th>
                <th>Due Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                @php
                    $load = $invoice['parent_load'];
                @endphp
                <tr>
                    <td>{{ $invoice['number'] }}</td>
                    <td>{{ $load['internal_id'] }}</td>
                    <td>{{ $load['reference'] }}</td>
                    <td>${{ number_format($load['price'], 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice['pick_up_date'])->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p>Kindly review the attached invoices and process the payment accordingly.</p>

        <p><strong>Payment Details:</strong></p>
        <p>[Bank Transfer / Payment Instructions]</p>

        <p>If you have any questions or require any adjustments, feel free to reach out.</p>

    @endif

    <br>
        <span>
    <strong>Best regards,</strong><br>
    {{ $current_user_name ?? '' }}<br>
    {{ $company['name'] ?? '' }}<br>
    {{ $company['email'] ?? '' }}<br>
    {{ $company['phone_number'] ?? '' }}<br>
</span>
</div>
</body>
</html>
