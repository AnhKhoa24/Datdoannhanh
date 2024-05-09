<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\ProductChagesEvent;
use App\Events\ProductUpdateEvent;
use Illuminate\Foundation\Events\Dispatchable;

class Product extends Model
{
    use HasFactory, Dispatchable;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $dispatchesEvents = [
        'created'=> ProductChagesEvent::class,
        'updated'=> ProductUpdateEvent::class,
    ];
    
}
