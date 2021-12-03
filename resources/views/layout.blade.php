<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
</head>
<body>
    <h1>User Page</h1>
    @foreach ($emails as $email )
    < <table>
        <tr>
          <th>{{$email->sender(getemailAddress())}}</th>
        </tr>
        <tr>
          <td>{{}}</td>
        </tr>
        <tr>
          <td>{{}}</td>
        </tr>
      </table>
    @endforeach
</body>
</html>
