<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hóa đơn bán hàng</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .page-body {
            padding: 20px;
            max-width: 80mm;
            margin: 0 auto;
            border: 1px solid #ddd;
        }

        .company-info,
        .customer-info {
            margin-bottom: 10px;
        }

        h3,
        p,
        address {
            margin: 0;
            padding: 5px 0;
        }

        h3 {
            font-size: 16px;
            font-weight: bold;
        }

        p,
        address {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 5px;
            border-bottom: 1px dashed #ddd;
            font-size: 12px;
        }

        th {
            text-align: left;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .strong {
            font-weight: bold;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }

        a {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="page-body">
        <!-- Thông tin công ty -->
        <div class="company-info">
            <h3> Công ty TNHH giải pháp phần mềm Việt Nam Tiên Phong </h3>
            <address>
                Tầng 12, toà nhà Etown5, số 364 Cộng Hoà, Phường 13, Quận Tân Bình, TP. Hồ Chí Minh
                <br />
                Điện thoại: 0987654321 <br />
                Email: contact@nextarea.vn
            </address>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="customer-info">
            <h3>Thông tin khách hàng</h3>
            <address>
                Tên: {{ $order->name }} <br>
                SĐT: {{ $order->phone }} <br>
                Email: {{ $order->email }} <br>
                Địa chỉ: {{ $order->address }}
            </address>
        </div>

        <!-- Mã hóa đơn -->
        <div>
            <h3>Mã hóa đơn: {{ $order->order_code }}</h3>
        </div>

        <!-- Bảng sản phẩm -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sản phẩm</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-end">Đơn giá</th>
                    <th class="text-end">Tạm tính</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">{{ format_price($item->price) }}</td>
                        <td class="text-end">{{ format_price($item->quantity * $item->price) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="strong text-end">Tạm tính</td>
                    <td class="text-end">{{ format_price($order->subtotal) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="strong text-end">Giảm giá</td>
                    <td class="text-end">{{ format_price($order->discount) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="strong text-end">Phí vận chuyển</td>
                    <td class="text-end">{{ format_price($order->shipping_fee) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="strong text-end">Tổng tiền</td>
                    <td class="strong text-end">{{ format_price($order->total) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Lời cảm ơn -->
        <div class="footer-text">
            <p>Cảm ơn quý khách đã mua hàng.</p>
            <p>Nếu có thắc mắc, vui lòng liên hệ qua số điện thoại hoặc email trên.</p>
            <p>Website: <a href="https://nextarea.vn">https://nextarea.vn</a></p>
        </div>
    </div>
</body>

</html>
