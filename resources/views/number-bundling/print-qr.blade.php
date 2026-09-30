<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bundle QR Tags - {{ $cutOrder->cut_order_no }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 20px; background: #f3f4f6; }
        .print-container { max-width: 800px; margin: 0 auto; }
        .label { 
            width: 350px; 
            height: 200px; 
            background: #fff; 
            border: 2px dashed #9ca3af; 
            border-radius: 8px; 
            margin: 10px; 
            padding: 15px; 
            display: inline-block; 
            box-sizing: border-box; 
            position: relative;
        }
        .header { border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; margin-bottom: 10px; font-weight: 700; font-size: 14px; }
        .qr-placeholder { 
            width: 80px; height: 80px; background: #e5e7eb; border-radius: 4px; 
            display: flex; align-items: center; justify-content: center; font-size: 10px; color: #6b7280;
            position: absolute; right: 15px; top: 40px;
        }
        .info { font-size: 12px; margin-bottom: 5px; }
        .info strong { color: #374151; }
        .bundle-no { font-size: 16px; font-weight: 800; color: #0284c7; margin-top: 15px; }
        body { color: #edf3ee; background: radial-gradient(ellipse at 80% 0%, rgba(53,99,78,0.15), transparent 30rem), #0b1113; }
        .label { box-shadow: 0 14px 36px rgba(0,0,0,0.22); }
        .no-print button { background: #c4f06b !important; color: #17200e !important; border-radius: 6px !important; font-weight: 700; }
        .no-print a { color: #c4f06b !important; }
        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none; }
            .label { border: 1px solid #000; page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="no-print" style="margin-bottom: 20px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #0284c7; color: #fff; border: none; border-radius: 6px; cursor: pointer;">Print All Tags</button>
            <a href="{{ route('number-bundling.index') }}" style="margin-left:10px; color: #4b5563; text-decoration: none;">Back</a>
        </div>
        
        @foreach($bundles as $bundle)
        <div class="label">
            <div class="header">TRACK TECH - BUNDLE TAG</div>
            <div class="info">Cut Order: <strong>{{ $cutOrder->cut_order_no }}</strong></div>
            <div class="info">Size: <strong style="font-size:16px;">{{ $bundle->size }}</strong></div>
            <div class="info">Quantity: <strong>{{ $bundle->quantity }} pcs</strong></div>
            
            <div class="bundle-no">{{ $bundle->bundle_no }}</div>
            
            <!-- In a real app, generate real QR using a library like simple-qrcode -->
            <div class="qr-placeholder">
                [QR CODE]
                <br>{{ $bundle->bundle_no }}
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
