<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Rsvp;
use App\Models\WeddingCard;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $allCards = WeddingCard::where('user_id', $userId)->get();
        $cardId = $request->get('card_id', $allCards->first()?->id);
        
        $selectedCard = $allCards->where('id', $cardId)->first();
        $tables = [];
        $unassignedGuests = [];

        if ($selectedCard) {
            $tables = Table::where('wedding_card_id', $selectedCard->id)->with('rsvps')->get();
            // Lấy danh sách khách đã xác nhận đi nhưng chưa xếp bàn
            $unassignedGuests = Rsvp::where('wedding_card_id', $selectedCard->id)
                ->where('status', 'yes')
                ->whereNull('table_id')
                ->get();
        }

        return view('client.tables.index', compact('allCards', 'selectedCard', 'tables', 'unassignedGuests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Table::create($request->all());

        return redirect()->back()->with('success', 'Thêm bàn tiệc mới thành công!');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        return redirect()->back()->with('success', 'Đã xóa bàn tiệc!');
    }

    public function assignGuest(Request $request)
    {
        $request->validate([
            'rsvp_id' => 'required',
            'table_id' => 'nullable',
        ]);

        $rsvp = Rsvp::findOrFail($request->rsvp_id);
        $rsvp->table_id = $request->table_id;
        $rsvp->save();

        return redirect()->back()->with('success', 'Đã cập nhật chỗ ngồi cho khách!');
    }
}