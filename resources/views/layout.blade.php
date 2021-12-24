<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/css/layout.css" />
    <title>User</title>
</head>

<body>
    <table>
        <tr>
            <th>Nom complet</th>
            <th>Sujet</th>
            <th>Message</th>
        </tr>
        @foreach ($emails as $mail)
            <tr>
                <td>{{ $mail->getSender()->getEmailAddress()->getName() }}</td>
                <td>{{ $mail->getsubject() }}</td>
                <td> {!! html_entity_decode(strip_tags($mail->getBody()->getContent())) !!} <br><br></td>
            </tr>
        @endforeach
    </table>
</body>

</html>
