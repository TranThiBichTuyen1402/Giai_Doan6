<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeddingRsvp;
use App\Models\WeddingTable;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $allCards = Auth::user()
            ->weddingCards()
            ->latest()
            ->get();

        $recentCards = $allCards->take(3);

        $selectedCardId = $request->query('card_id', $allCards->first()?->id);
        $selectedCard = $allCards->firstWhere('id', $selectedCardId);

        $rsvps = collect();
        $stats = [
            'total_rsvps' => 0,
            'attending' => 0,
            'total_guests' => 0,
            'declined' => 0,
        ];

        if ($selectedCard) {
            $rsvps = $selectedCard->rsvps()->latest()->get();

            $stats['total_rsvps'] = $rsvps->count();
            $stats['attending'] = $rsvps->where('is_attending', true)->count();
            $stats['total_guests'] = $rsvps->where('is_attending', true)->sum('guest_count');
            $stats['declined'] = $rsvps->where('is_attending', false)->count();
        }

        return view('client.dashboard', compact(
            'allCards',
            'recentCards',
            'selectedCard',
            'rsvps',
            'stats'
        ));
    }

    public function myCards()
    {
        $cards = Auth::user()
            ->weddingCards()
            ->latest()
            ->get();

        return view('client.my-cards', compact('cards'));
    }

    public function rsvpList(Request $request)
    {
        $allCards = Auth::user()->weddingCards()->latest()->get();
        $selectedCardId = $request->query('card_id', $allCards->first()?->id);
        $selectedCard = $allCards->firstWhere('id', $selectedCardId);

        $rsvps = collect();
        $tables = collect();
        $unassignedGuests = collect();

        $stats = [
            'total_rsvps' => 0, 
            'attending' => 0, 
            'total_guests' => 0, 
            'declined' => 0
        ];

        if ($selectedCard) {
            $rsvps = $selectedCard->rsvps()->latest()->get();
            
            $stats['total_rsvps'] = $rsvps->count();
            $stats['attending'] = $rsvps->where('is_attending', true)->count();
            $stats['total_guests'] = $rsvps->where('is_attending', true)->sum('guest_count');
            $stats['declined'] = $rsvps->where('is_attending', false)->count();

            // Lấy danh sách bàn tiệc
            $tables = WeddingTable::where('wedding_card_id', $selectedCard->id)
                        ->with('rsvps')
                        ->get();

            // Khách xác nhận ĐI (is_attending = true) nhưng CHƯA xếp bàn (table_id = null)
            $unassignedGuests = WeddingRsvp::where('wedding_card_id', $selectedCard->id)
                        ->where('is_attending', true)
                        ->whereNull('table_id')
                        ->get();
        }

        return view('client.rsvp-list', compact('allCards', 'selectedCard', 'rsvps', 'stats', 'tables', 'unassignedGuests'));
    }

    public function storeTable(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required',
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1'
        ]);

        WeddingTable::create([
            'wedding_card_id' => $request->wedding_card_id,
            'name' => $request->name,
            'capacity' => $request->capacity ?? 10,
        ]);

        return redirect()->back()->with('success', 'Đã thêm bàn tiệc thành công!');
    }

    public function assignTable(Request $request, $id)
    {
        $rsvp = WeddingRsvp::findOrFail($id);
        $rsvp->table_id = $request->table_id;
        $rsvp->save();

        return redirect()->back()->with('success', 'Đã cập nhật vị trí bàn!');
    }
}