<?php

namespace App\Http\Controllers;

use App\Models\ProjectResourceItem;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function printResourceItems($resource_id)
    {
        // Get resource items - adjust based on your model
        $resource = ProjectResourceItem::findOrFail($resource_id);
        $resourceItems = ProjectResourceItem::with('details')->where('resource_id', $resource_id)
        ->whereIn('status', ['received', 'incomplete'])
        ->get();
        
        $data = [
            'receiptNumber' => 'REC-' . date('Ymd') . '-' . str_pad($resourceItems->count(), 4, '0', STR_PAD_LEFT),
            'issueDate' => now()->format('F j, Y g:i A'),
            'preparedBy' => auth()->guard()->user()->name ?? 'System',
        ];

        return view('admin.receipts.resource-items', compact(['resource', 'resourceItems','data']));
    }

    // public function downloadPDF(Request $request)
    // {
    //     // For PDF download using DomPDF
    //     $resourceItems = ProjectResourceItem::with(['category', 'resource'])->get();
        
    //     $data = [
    //         'resourceItems' => $resourceItems,
    //         'receiptNumber' => 'REC-' . date('Ymd-His'),
    //         'issueDate' => now()->format('F j, Y g:i A'),
    //         'preparedBy' => auth()->guard()->user()->name ?? 'System',
    //     ];

    //     $pdf = Pdf::loadView('receipts.resource-items', $data);
        
    //     return $pdf->download('resource-items-receipt-'.date('Y-m-d').'.pdf');
    // }
}