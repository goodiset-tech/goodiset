<!DOCTYPE html>
<html>
<head>
    <title>Product Sales Report</title>
    <style>
        @font-face {
            font-family: currencyFontStyle;
            src: url('{{ public_path('front/font/currency.woff2') }}') format('woff2');
            font-display: swap;
            font-weight: 600;
            font-style: normal;
        }
        .icon-aed {
            font-family: 'currencyFontStyle', sans-serif !important;
        }
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Product Sales Report</h1>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Sales (<span class="icon-aed">{{ getSetting('currency') }}</span>)</th>
                <th>Total Quantity Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesData as $data)
                <tr>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['total_sales'] }}</td>
                    <td>{{ $data['total_quantity'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>