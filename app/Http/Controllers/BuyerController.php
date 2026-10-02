<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $buyers = Buyer::all();
        $query = PurchaseOrder::with('buyer');
        
        // basic filtering
        if ($request->search) {
            $query->where('po_number', 'like', "%{$request->search}%")
                  ->orWhere('style_name', 'like', "%{$request->search}%")
                  ->orWhere('style_code', 'like', "%{$request->search}%");
        }
        if ($request->buyer_id) {
            $query->where('buyer_id', $request->buyer_id);
        }
        
        $purchaseOrders = $query->latest()->paginate(15);
        
        return view('buyers.index', compact('buyers', 'purchaseOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buyer_id' => 'required|exists:buyers,id',
            'po_number' => 'required|unique:purchase_orders,po_number',
            'style_name' => 'required|string|max:255',
            'style_code' => 'required|string|max:255',
            'season' => 'required|string',
            'order_qty' => 'required|integer',
            'delivery_date' => 'required|date',
        ]);

        PurchaseOrder::create($validated);

        return redirect()->route('buyers.index')->with('success', 'Purchase order created successfully.');
    }

    public function update(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $validated = $request->validate([
            'buyer_id' => 'required|exists:buyers,id',
            'po_number' => 'required|unique:purchase_orders,po_number,' . $po->id,
            'style_name' => 'required|string|max:255',
            'style_code' => 'required|string|max:255',
            'season' => 'required|string',
            'order_qty' => 'required|integer',
            'delivery_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $po->update($validated);

        return redirect()->route('buyers.index')->with('success', 'Purchase order updated successfully.');
    }

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->delete();
        return redirect()->route('buyers.index')->with('success', 'Purchase order deleted successfully.');
    }
}
