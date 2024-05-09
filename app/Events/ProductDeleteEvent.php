<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductDeleteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $product;
    public $message;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->message = Auth::user()->name . " đã xóa sản phẩm : " . $this->product->product_name;
        $this->user_id = Auth::user()->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return ['khoalatui'];
    }
    public function broadcastAs()
    {
        return 'khoalatui';
    }
}
