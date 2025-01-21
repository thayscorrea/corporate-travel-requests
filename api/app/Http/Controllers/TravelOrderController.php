<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelOrder;
use Illuminate\Support\Facades\Auth;

class TravelOrderController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(TravelOrder::query()->get());

        // $query = TravelOrder::query()->where('user_id', Auth::id());

        // if ($request->has('status')) {
        //     $query->where('status', $request->status);
        // }

        // if ($request->has('start_date') && $request->has('end_date')) {
        //     $query->whereBetween('departure_date', [$request->start_date, $request->end_date]);
        // }

        // if ($request->has('destination')) {
        //     $query->where('destination', 'like', "%{$request->destination}%");
        // }

        // return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        $order = TravelOrder::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'solicitado',
        ]));

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = TravelOrder::findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $travelOrder = TravelOrder::find($id);

        if (!$travelOrder) {
            return response()->json(['error' => 'Travel order not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:aprovado,cancelado',
        ]);

        // $order = TravelOrder::where('user_id', Auth::id())->findOrFail($id);

        if ($travelOrder->status === 'aprovado' && $validated['status'] === 'cancelado') {
            return response()->json(['message' => 'Não é possível cancelar um pedido aprovado!'], 422);
        }

        $travelOrder->update(['status' => $validated['status']]);

        return response()->json($travelOrder);
    }

    public function destroy($id)
    {
        $order = TravelOrder::where('user_id', Auth::id())->findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
