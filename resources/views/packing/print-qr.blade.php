<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carton Label - {{ $packing->carton_number }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 20px; background: #f3f4f6; }
        .print-container { max-width: 600px; margin: 0 auto; }
        .label { 
            width: 400px; 
            height: 250px; 
            background: #fff; 
            border: 2px dashed #9ca3af; 
            border-radius: 8px; 
            margin: 10px auto; 
            padding: 20px; 
            box-sizing: border-box; 
            position: relative;
        }
        .header { border-bottom: 2px solid #111827; padding-bottom: 10px; margin-bottom: 15px; font-weight: 800; font-size: 18px; text-align: center; letter-spacing: 1px; }
        .qr-placeholder { 
            width: 100px; height: 100px; background: #e5e7eb; border-radius: 4px; 
            display: flex; align-items: center; justify-content: center; font-size: 12px; color: #6b7280;
            position: absolute; right: 20px; top: 70px;
        }
        .info { font-size: 14px; margin-bottom: 8px; }
        .info strong { color: #111827; }
        .carton-no { font-size: 22px; font-weight: 900; color: #059669; margin-top: 25px; }
        body { color: #edf3ee; background: radial-gradient(ellipse at 80% 0%, rgba(53,99,78,0.15), transparent 30rem), #0b1113; }
        .label { box-shadow: 0 18px 48px rgba(0,0,0,0.28); }
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
            <button onclick="window.print()" style="padding: 10px 20px; background: #059669; color: #fff; border: none; border-radius: 6px; cursor: pointer;">Print Label</button>
            <a href="{{ route('packing.index') }}" style="margin-left:10px; color: #4b5563; text-decoration: none;">Back</a>
        </div>
        
        <div class="label">
            <div class="header">TRACK TECH - SHIPPING CARTON</div>
            <div class="info">Size: <strong style="font-size:20px;">{{ $packing->size }}</strong></div>
            <div class="info">Quantity: <strong>{{ $packing->quantity_packed }} pcs</strong></div>
            <div class="info">Source Bundle: <strong>{{ $packing->bundle->bundle_no }}</strong></div>
            
            <div class="carton-no">{{ $packing->carton_number }}</div>
            
            <div class="qr-placeholder">
                [QR CODE]
            </div>
        </div>
    </div>
</body>
</html>
