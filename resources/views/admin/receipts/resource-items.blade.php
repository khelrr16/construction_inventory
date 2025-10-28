<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Items Receipt</title>
    <style>
        /* Print Styles */
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
            .receipt-container { box-shadow: none !important; border: none !important; }
        }

        /* General Styles */
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #fff; 
            color: #000;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 30px;
            background: white;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-logo{
            height: 130px;
        }
        
        /* .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }*/
        
        .company-address {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }
        
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .info-section {
            flex: 1;
            min-width: 200px;
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .info-value {
            padding: 8px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
        
        /* Table Styles */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th {
            background: #333;
            color: white;
            padding: 12px;
            text-align: left;
            border: 1px solid #000;
        }
        
        .items-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .items-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .total-section {
            margin-top: 30px;
            border-top: 2px solid #000;
            padding-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .grand-total {
            font-size: 20px;
            font-weight: bold;
            /* border-top: 1px solid #000; */
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            font-size: 12px;
            color: #666;
        }
        
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }
        
        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Receipt
    </button>

    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">
                <img src="{{ asset('img/logo/full-logo.png') }}"
                    class="company-logo"
                    > 
            </div>
            <div class="company-address">
                Blk 4 Lot 33, Amber Street, San Pedro, Laguna 4023<br>
                Phone: (+63) 970-212-4061 | Email: info@contrucktor.com
            </div>
            <div class="receipt-title">RESOURCE RECEIPT</div>
        </div>

        <!-- Receipt Information -->
        <div class="receipt-info">
            <div class="info-section">
                <div class="info-label">Receipt Number:</div>
                <div class="info-value">#{{ $receiptNumber ?? 'REC-'.date('Ymd-His') }}</div>
            </div>
            <div class="info-section">
                <div class="info-label">Date Issued:</div>
                <div class="info-value">{{ $issueDate ?? now()->format('F j, Y g:i A') }}</div>
            </div>
            <div class="info-section">
                <div class="info-label">Prepared By:</div>
                <div class="info-value">{{ $preparedBy ?? 'System Administrator' }}</div>
            </div>
        </div>

        <!-- Resource Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">Item Name</th>
                    <th width="20%">Category</th>
                    <th width="10%">Quantity</th>
                    <th width="15%">Unit Cost</th>
                    <th width="20%">Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                    $itemCount = 1;
                @endphp
                
                @foreach($resourceItems as $item)
                @php
                    $totalCost = $item->completed * ($item->details->cost ?? 0);
                    $grandTotal += $totalCost;
                @endphp
                <tr>
                    <td class="text-center">{{ $itemCount++ }}</td>
                    <td>{{ $item->name ?? $item->details->name ?? 'N/A' }}</td>
                    <td>{{ $item->category ?? ucwords($item->details->category) ?? 'General' }}</td>
                    <td class="text-center">{{ $item->completed ?? 0 }}</td>
                    <td class="text-right">₱{{ number_format($item->details->cost ?? 0, 2) }}</td>
                    <td class="text-right">₱{{ number_format($totalCost, 2) }}</td>
                </tr>
                @endforeach

                <!-- Empty rows for printing -->
                @for($i = count($resourceItems); $i < 10; $i++)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="total-section">
            {{-- <div class="total-row">
                <div>Subtotal:</div>
                <div>${{ number_format($grandTotal, 2) }}</div>
            </div>
            <div class="total-row">
                <div>Tax (0%):</div>
                <div>$0.00</div>
            </div> --}}
            <div class="total-row grand-total">
                <div>GRAND TOTAL:</div>
                <div>₱{{ number_format($grandTotal, 2) }}</div>
            </div>
        </div>

        <!-- Notes Section -->
        <div style="margin-top: 30px;">
            <div style="font-weight: bold; margin-bottom: 10px;">Notes:</div>
            <div style="border: 1px solid #ddd; padding: 15px; background: #f9f9f9; min-height: 80px;">
                All items are subject to verification. Please check quantities upon receipt.
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div>
                <div class="signature-line">Prepared By</div>
            </div>
            <div>
                <div class="signature-line">Received By</div>
            </div>
            <div>
                <div class="signature-line">Authorized By</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>Thank you for your business!</div>
            <div>This is a computer-generated receipt. No signature required.</div>
            <div>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <script>
        // Auto-print option
        @if(request()->has('autoprint'))
        window.onload = function() {
            window.print();
        }
        @endif

        // Add page breaks for long lists
        function addPageBreaks() {
            const tables = document.querySelectorAll('.items-table');
            tables.forEach((table, index) => {
                if (index > 0) {
                    table.classList.add('page-break');
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', addPageBreaks);
    </script>
</body>
</html>