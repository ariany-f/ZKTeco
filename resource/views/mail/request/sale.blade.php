<!DOCTYPE html>
<html lang="{{ config('app.lang') }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Houve uma solicitação orçamento</title>
</head>
<body>
<section style="margin-bottom: 40px;">
    <div style="padding: 20px; border: 1px solid #bfbfbf; border-radius: 5px;">
        <p style="font-size: 20px;"> Orçamento Solicitado</p>
        
        <h3 style="margin-bottom: 10px; margin-top: 30px;">Dados do Cliente</h3><hr />
        <b>Nome</b> {{ $cliente->name }}<br/>
        <b>Email</b> {{ $cliente->email }}<br/>
        <b>Telefones</b> {{ $cliente->telephone }} {{ $cliente->cell }}<br/>
        <b>CNPJ</b> {{ $cliente->cnpj }}

        <h3 style="margin-bottom: 10px; margin-top: 30px;">Produtos</h3><hr />
        <table style="margin-top: 5px; border-collapse: collapse; border: 1px solid black; width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 10px; border: 1px solid black;">Nome</th>
                    <th style="padding: 10px; border: 1px solid black;">Preço(R$)</th>
                    <th style="padding: 10px; border: 1px solid black;">Quantidade</th>
                    <th style="padding: 10px; border: 1px solid black;">Subtotal(R$)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart_products as $product)
                <tr>
                    @if($product->product->visible)
                    <td style="max-width: 200px; padding: 10px; border: 1px solid black;"><a href="{{ route('site.products.show', ['slug' => $product->product->slug]) }}" title="Página do produto: {{ $product->product->name }}" target="_blank">{{ $product->product->name }} <i class="fa fa-external-link"></i></a></td>
                    @else
                    <td style="padding: 10px; border: 1px solid black;">{{ $product->product->name }}</td>
                    @endif
                    <td style="padding: 10px; border: 1px solid black;">{{ number_format(current(current($product->product->sizes))->price, 2, ',', '.') }}</td>
                    <td style="padding: 10px; border: 1px solid black;">{{ $product->quantity }}</td>
                    <td style="padding: 10px; border: 1px solid black;">{{ number_format(current(current($product->product->sizes))->price * $product->quantity, 2, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="2">R$ {{ $amount }}</td>
                </tr>
            </tbody>
        </table>
        </div>
    </section>
</body>
</html>