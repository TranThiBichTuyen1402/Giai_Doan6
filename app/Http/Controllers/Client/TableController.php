<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeddingRsvp;
use Illuminate\Support\Facades\Schema;

class TableController extends Controller
{
    public function findSeat(Request $request)
    {
        try {
            $cardId = $request->query('card_id');
            $name = trim($request->query('name'));

            if (!$name) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập tên của bạn!'
                ]);
            }

            $model = new WeddingRsvp();
            $tableName = $model->getTable(); // Lấy tên bảng trong DB

            // 1. Kiểm tra danh sách các cột thực sự có trong bảng database
            $possibleColumns = ['guest_name', 'name', 'full_name', 'fullname', 'khach_moi', 'ten_khach'];
            $existingColumns = [];

            foreach ($possibleColumns as $col) {
                if (Schema::hasColumn($tableName, $col)) {
                    $existingColumns[] = $col;
                }
            }

            // Nếu không tìm thấy cột tên nào phù hợp
            if (empty($existingColumns)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy cột lưu tên khách trong bảng ' . $tableName
                ], 500);
            }

            // 2. Tạo truy vấn chỉ trên các cột ĐÃ TỒN TẠI
            $query = WeddingRsvp::query();

            if ($cardId && Schema::hasColumn($tableName, 'wedding_card_id')) {
                $query->where('wedding_card_id', $cardId);
            }

            $query->where(function ($q) use ($existingColumns, $name) {
                foreach ($existingColumns as $index => $col) {
                    if ($index === 0) {
                        $q->where($col, 'LIKE', '%' . $name . '%');
                    } else {
                        $q->orWhere($col, 'LIKE', '%' . $name . '%');
                    }
                }
            });

            $guests = $query->get();

            if ($guests->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thông tin bàn tiệc cho tên này.'
                ]);
            }

        // 3. Trả về kết quả
            $data = $guests->map(function ($item) use ($existingColumns) {
                // Tự lấy tên từ cột hợp lệ đầu tiên có dữ liệu
                $guestName = 'Khách mời';
                foreach ($existingColumns as $col) {
                    if (!empty($item->$col)) {
                        $guestName = $item->$col;
                        break;
                    }
                }

                // Xử lý lấy tên bàn (Tránh lỗi [object Object])
                $tableName = 'Chưa xếp bàn';
                if (is_object($item->table_name)) {
                    $tableName = $item->table_name->name ?? $item->table_name->table_name ?? 'Chưa xếp bàn';
                } elseif (is_string($item->table_name) || is_numeric($item->table_name)) {
                    $tableName = $item->table_name;
                } elseif (isset($item->table)) {
                    $tableName = is_object($item->table) ? ($item->table->name ?? $item->table->table_name) : $item->table;
                }

                return [
                    'table_name'  => $tableName,
                    'guest_name'  => $guestName,
                    'guest_count' => $item->guests_count ?? $item->amount ?? $item->number_of_guests ?? 1,
                    'note'        => $item->note ?? '',
                ];
            });

            return response()->json([
                'success' => true,
                'guests'  => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi Server: ' . $e->getMessage()
            ], 500);
        }
    }
}