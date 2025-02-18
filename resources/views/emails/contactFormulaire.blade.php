<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Données soumises :</h1>
        <table border="1" cellpadding="10">
            @foreach($formData as $key => $value)
                <tr>
                    <td><strong>{{ ucfirst($key) }}</strong></td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </table>
</body>
</html>