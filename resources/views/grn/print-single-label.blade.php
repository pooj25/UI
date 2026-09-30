<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Label — {{ $roll->roll_number }}</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:Arial,sans-serif; background:#fff; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .label {
            border: 2px solid #0891b2; border-radius: 10px;
            padding: 16px 20px; width: 240px; text-align: center;
        }
        .label canvas { display:block; margin:0 auto 8px; }
        .grn  { font-size:9pt; color:#0891b2; font-weight:700; }
        .roll { font-size:14pt; font-weight:700; color:#111; margin:2px 0; }
        .fab  { font-size:8pt; color:#555; margin-bottom:2px; }
        .sup  { font-size:7.5pt; color:#777; }
        .stat { font-size:8pt; background:#e0f2fe;color:#0891b2;border-radius:4px;padding:2px 8px;display:inline-block;margin-top:5px; }
        .wl   { font-size:7.5pt; color:#555; margin-top:3px; }
        .no-print { position:fixed; top:10px; left:10px; }
        body { color: #edf3ee; background: radial-gradient(ellipse at 80% 0%, rgba(53,99,78,0.15), transparent 30rem), #0b1113; }
        .label { box-shadow: 0 18px 48px rgba(0,0,0,0.28); }
        .no-print button { background: #c4f06b !important; color: #17200e !important; border-radius: 6px !important; font-weight: 700; }
        .no-print a { color: #c4f06b !important; }
        @media print { .no-print { display:none; } body { min-height:auto; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="background:#0891b2;color:#fff;border:none;padding:6px 14px;border-radius:6px;cursor:pointer;">🖨 Print</button>
        <a href="{{ route('grn.show', $roll->grn_id) }}" style="margin-left:8px;color:#0891b2;font-size:13px;">← Back</a>
    </div>

    <div class="label">
        <canvas id="qr-canvas"></canvas>
        <div class="grn">{{ $roll->grn->grn_number }}</div>
        <div class="roll">{{ $roll->roll_number }}</div>
        <div class="fab">{{ $roll->grn->fabric?->fabric_code }} — {{ $roll->grn->fabric?->fabric_name }}</div>
        <div class="sup">{{ $roll->grn->supplier_name }}</div>
        @if($roll->roll_weight || $roll->roll_length)
        <div class="wl">
            @if($roll->roll_weight) Wt: {{ $roll->roll_weight }} kg @endif
            @if($roll->roll_length) &nbsp; Len: {{ $roll->roll_length }} m @endif
        </div>
        @endif
        <div class="stat">{{ $roll->statusLabel() }}</div>
    </div>

    <script>
        QRCode.toCanvas(
            document.getElementById('qr-canvas'),
            '{{ $roll->qr_code }}',
            { width: 160, margin: 1, color: { dark: '#0c4a6e', light: '#ffffff' } }
        );
    </script>
</body>
</html>
