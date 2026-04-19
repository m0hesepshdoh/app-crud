<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>create a product</h1>
    <a href="{{ route('products.index') }}">Return Back</a>
    <div>
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        @endif

    </div>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        @method('post')

        <div>
            <label>name</label>
            <input type="text" name="name" placeholder="Name">
        </div>
        <div>
            <label>qty</label>
            <input type="text" name="qty" placeholder="Qty">
        </div>
        <div>
            <label>Price</label>
            <input type="text" name="price" placeholder="Price">
        </div>
        <div>
            <label>Description</label>
            <input type="text" name="description" placeholder="Description">
        </div>
        <div>
            <input type="submit" value="Save A New Product" />
        </div>
    </form>
</body>

</html>
