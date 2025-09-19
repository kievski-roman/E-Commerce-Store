<?php

namespace App\Models;

use App\Policies\AdminProductPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


#[UsePolicy(AdminProductPolicy::class)]
class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'slug',
        'image',
    ];

    //В Model уже есть свой метод boot(), который настраивает базовые возможности Eloquent
    // (например, наблюдатели за событиями). Вызов parent::boot() говорит:
    //   "Сначала выполни стандартную настройку из родительского класса Model,
    // а потом добавь мои кастомные правила". Без этого Laravel может потерять базовые функции Eloquent.
    protected static function boot()
    {
        parent::boot();

//        creating: Срабатывает до создания записи в
//        базе (например, когда ты вызываешь Product::create()).
        static::creating(function ($product) {
            $product->slug = static::generateSlug($product->name);
        });


//        updating: Срабатывает до обновления существующей записи
//    (например, когда ты вызываешь $product->update()).
        static::updating(function ($product) {
            // isDirty - проверяет изменилось ли значение в полях
            if ($product->isDirty('name')) {
                $product->slug = static::generateSlug($product->name, $product->id);
            }
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    static function generateSlug($name, $excId = null)
    {
        $slug = Str::slug($name);
        $count = 1;
        while (static::where('slug', $slug)
            ->where('id', '!=', $excId)
            ->exists()) {
            $slug = $slug . '-' . $count;
            $count++;
        }
        return $slug;
    }
}
