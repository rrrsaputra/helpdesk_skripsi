<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <div>
        <label for="input1">Input 1:</label>
        <input type="text" id="input1" name="input1">
    </div>
    <div>
        <label for="input2">Input 2:</label>
        <input type="text" id="input2" name="input2">
    </div>
    <div>
        <label for="input3">Input 3:</label>
        <input type="text" id="input3" name="input3">
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>

    </form>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>