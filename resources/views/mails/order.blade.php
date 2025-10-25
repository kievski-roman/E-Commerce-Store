<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение заказа</title>
</head>
<body>

<h1>Спасибо за ваш заказ, {{ $order->user->name }}!</h1>
<p>Ваш заказ №{{ $order->id }} успешно оформлен.</p>
<p>Детали заказа:</p>
<ul>
    @foreach ($order->items as $item)
        <li>{{ $item->product->name }} - {{ $item->quantity }} шт. - {{ $item->unit_price }} $.</li>
    @endforeach
</ul>
<p>Общая сумма: {{ $order->total_price }} $.</p>
<p>Дата заказа: {{ now()->format('d.m.Y H:i') }}</p> 
<p>Если у вас есть вопросы, свяжитесь с нами: support@yourshop.com</p>
</body>
</html>
