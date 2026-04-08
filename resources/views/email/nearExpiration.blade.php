<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Reminder: Your ticket expires in {{ $nearDateCount }} days </h3>
    <ol type="1">
        @foreach ($nearExpirationTickets as $data )
            <li style="font-weight:600;">{{ $data['title'] }} - {{ date('j F, Y',strtotime($data['expiration_date'])) }}</li>
        @endforeach
    </ol >
</body>
</html>
