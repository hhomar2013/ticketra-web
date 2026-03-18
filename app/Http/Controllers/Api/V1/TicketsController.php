<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'This is the tickets endpoint.',
        ]);
    }

    public function show(Request $request)
    {
        $id      = $request->user()->id;
        $tickets = Ticket::where('user_id', $id)->get();
        return response()->json([
            'message' => 'Tickets retrieved successfully',
            'data'    => $tickets,
            'count'   => $tickets->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'user_id'     => $request->user()->id,
            'title'       => $request->title,
            'category_id' => $request->user()->category_id,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Ticket created successfully',
            'data'    => $ticket,
        ], 201);
    }

}
