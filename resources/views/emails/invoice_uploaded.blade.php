<!DOCTYPE html>
<html>
<head>
    <title>Invoice Uploaded</title>
</head>
<body>
    <p>Hello {{ $invoice->person->full_name }},</p>

    <p>A new invoice (Invoice #: {{ $invoice->invoice_number }}) has been uploaded for you.</p>

    <p>Amount: €{{ number_format($invoice->total, 2) }}</p>
    <p>Due Date: {{ $invoice->due_date }}</p>

    <p>You can download your invoice from the portal.</p>
     <p>Payment Plan and Options are Included in the Invoice</p>

    <p>Best regards,<br>SkillProFinder</p>
</body>
</html>
