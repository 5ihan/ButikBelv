<?php

namespace App\Http\Controllers;

use App\Models\StatusOrder;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function complete($id)
    {
        // Logic to mark the order as complete
        $statusorder = StatusOrder::findOrFail($id);
        $statusorder->status_paket = 'completed'; // Assuming you have a status field
        $statusorder->save();

        // Send success notification
        Notification::make()
            ->title('Order Completed')
            ->body('The order has been marked as completed.')
            ->success()
            ->send();

        return redirect()->back();
    }

    public function reject($id)
    {
        // Logic to reject the order
        $statusorder = StatusOrder::findOrFail($id);
        $statusorder->status_paket = 'Return'; // Assuming you have a status field
        $statusorder->save();

        // Send success notification
        Notification::make()
            ->title('Order Rejected')
            ->body('The order has been rejected.')
            ->danger()  
            ->send();

        return redirect()->back();
    }
}
