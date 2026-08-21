<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeddingCard;
use Illuminate\Http\Request;
class WeddingCardController extends Controller
{
 public function index(Request $request)
{
    $query = WeddingCard::with('user');

    // Tìm kiếm
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('groom_name', 'like', "%{$search}%")
              ->orWhere('bride_name', 'like', "%{$search}%")
              ->orWhereHas('user', function ($userQuery) use ($search) {
                  $userQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Lọc gói
    if ($request->filled('package')) {
        if ($request->package === 'vip') {
            $query->where('is_vip', true);
        }

        if ($request->package === 'free') {
            $query->where('is_vip', false);
        }
    }

    $cards = $query
                ->latest()
                ->paginate(10)
                ->withQueryString();

    return view('admin.wedding-cards.index', compact('cards'));
}
    public function show(WeddingCard $card)
{
    return redirect()->route('wedding.show', $card->slug);
}
public function edit(WeddingCard $card)
{
    return redirect()->route('card.builder', [
        'template_id' => $card->template_id,
        'card_id' => $card->id,
    ]);
}
public function destroy(WeddingCard $card)
{
    $card->delete();

    return redirect()
        ->route('admin.wedding-cards.index')
        ->with('success', 'Đã xóa thiệp cưới thành công.');
}
}