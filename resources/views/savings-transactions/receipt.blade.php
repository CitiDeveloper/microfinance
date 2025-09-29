<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt - {{ $savingsTransaction->transaction_reference }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .receipt-title {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .transaction-details {
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .detail-label {
            font-weight: bold;
        }
        .amount-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #333;
            background: #f8f9fa;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        .type-badge {
            display: inline-block;
            padding: 3px 8px;
            background: {{ $savingsTransaction->type == 'deposit' ? '#28a745' : '#ffc107' }};
            color: white;
            border-radius: 3px;
            font-weight: bold;
            text-transform: uppercase;
        }
        @media print {
            body { margin: 0; padding: 15px; }
            .receipt-container { border: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">MICROFINANCE SYSTEM</div>
            <div class="receipt-title">SAVINGS TRANSACTION RECEIPT</div>
            <div>Transaction Reference: {{ $savingsTransaction->transaction_reference }}</div>
        </div>

        <!-- Transaction Details -->
        <div class="transaction-details">
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span>{{ $savingsTransaction->transaction_date->format('F d, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Time:</span>
                <span>{{ $savingsTransaction->created_at->format('g:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Receipt No:</span>
                <span>{{ $savingsTransaction->receipt_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Branch:</span>
                <span>{{ $savingsTransaction->branch->name }}</span>
            </div>
        </div>

        <!-- Account Details -->
        <div style="margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 3px;">
            <div class="detail-row">
                <span class="detail-label">Account No:</span>
                <span>{{ $savingsTransaction->account->account_number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Borrower:</span>
                <span>{{ $savingsTransaction->account->borrower->full_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Product:</span>
                <span>{{ $savingsTransaction->account->savingsProduct->name }}</span>
            </div>
        </div>

        <!-- Amount Section -->
        <div class="amount-section">
            <div style="margin-bottom: 10px;">
                <span class="type-badge">{{ strtoupper($savingsTransaction->type) }}</span>
            </div>
            <div class="amount">
                {{ $savingsTransaction->type == 'deposit' ? '+' : '-' }}{{ number_format($savingsTransaction->amount, 2) }}
            </div>
            <div style="font-size: 14px; margin-top: 5px;">
                {{ $savingsTransaction->type == 'deposit' ? 'Deposit to Account' : 'Withdrawal from Account' }}
            </div>
        </div>

        <!-- Balance Information -->
        <div style="margin-bottom: 20px;">
            <div class="detail-row">
                <span class="detail-label">Balance Before:</span>
                <span>{{ number_format($savingsTransaction->balance_before, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Balance After:</span>
                <span style="font-weight: bold;">{{ number_format($savingsTransaction->balance_after, 2) }}</span>
            </div>
        </div>

        <!-- Notes -->
        @if($savingsTransaction->notes)
        <div style="margin-bottom: 20px;">
            <div class="detail-label">Notes:</div>
            <div style="margin-top: 5px;">{{ $savingsTransaction->notes }}</div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div>Processed by: {{ $savingsTransaction->creator->name }}</div>
            <div>Printed on: {{ now()->format('F d, Y g:i A') }}</div>
            <div style="margin-top: 10px;">
                Thank you for your transaction!
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">
                Print Receipt
            </button>
            <button onclick="window.close()" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 3px; cursor: pointer; margin-left: 10px;">
                Close
            </button>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>