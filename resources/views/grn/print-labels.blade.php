<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>QR Labels — {{ $grn->grn_number }}</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #fff; padding: 10mm; }
        .print-header {
            text-align: center; margin-bottom: 6mm; padding-bottom: 4mm;
            border-bottom: 2px solid #0891b2;
        }
        .print-header h2 { font-size: 14pt; color: #0891b2; }
        .print-header p  { font-size: 8pt; color: #555; }
        .labels-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5mm;
        }
        .label {
            border: 1.5px solid #0891b2;
            border-radius: 5px;
            padding: 4mm;
            page-break-inside: avoid;
            text-align: center;
        }
        .label canvas { display: block; margin: 0 auto 2mm; }
        .label .grn-no   { font-size: 8pt; font-weight: 700; color: #0891b2; }
        .label .roll-no  { font-size: 10pt; font-weight: 700; color: #111; }
        .label .fabric   { font-size: 7pt; color: #555; margin-top: 1mm; }
        .label .supplier { font-size: 7pt; color: #777; }
        .label .status   { font-size: 7pt; background:#e0f2fe;color:#0891b2;border-radius:3px;padding:1px 5px;display:inline-block;margin-top:1mm; }
        .no-print { margin-bottom: 6mm; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 5mm; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="padding:8px 0;">
        <button onclick="window.print()" style="background:#0891b2;color:#fff;border:none;padding:8px 20px;border-radius:8px;cursor:pointer;font-size:14px;">
            🖨 Print Labels
        </button>
        <a href="{{ route('grn.show', $grn) }}" style="margin-left:12px;color:#0891b2;font-size:14px;">← Back to GRN</a>
    </div>

    <div class="print-header">
        <h2>QR Labels — {{ $grn->grn_number }}</h2>
        <p>
            Invoice: {{ $grn->invoice_number }} &nbsp;|&nbsp;
            Supplier: {{ $grn->supplier_name }} &nbsp;|&nbsp;
            Fabric: {{ $grn->fabric?->fabric_code }} &nbsp;|&nbsp;
            Date: {{ $grn->received_date->format('d M Y') }}
        </p>
    </div>

    <div class="labels-grid">
        @foreach($grn->rolls as $roll)
        <div class="label">
            <canvas id="qr-{{ $roll->id }}"></canvas>
            <div class="grn-no">{{ $grn->grn_number }}</div>
            <div class="roll-no">{{ $roll->roll_number }}</div>
            <div class="fabric">{{ $grn->fabric?->fabric_code }} — {{ $grn->fabric?->fabric_name }}</div>
            <div class="supplier">{{ $grn->supplier_name }}</div>
            @if($roll->roll_weight || $roll->roll_length)
            <div class="fabric">
                @if($roll->roll_weight) Wt: {{ $roll->roll_weight }}kg @endif
                @if($roll->roll_length) Len: {{ $roll->roll_length }}m @endif
            </div>
            @endif
            <div class="status">{{ $roll->statusLabel() }}</div>
        </div>
        @endforeach
    </div>

    <script>
        const rolls = @json($grn->rolls->map(fn($r) => ['id'=>$r->id,'qr'=>$r->qr_code]));
        rolls.forEach(function(roll) {
            QRCode.toCanvas(
                document.getElementById('qr-' + roll.id),
                roll.qr,
                { width: 100, margin: 1, color: { dark: '#0c4a6e', light: '#ffffff' } },
                function(err) { if(err) console.error(err); }
            );
        });
    </script>
</body>
</html>
