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
    @foreach ($categories as $categorie)
         <?php echo $categorie ?>
         @endforeach
</body>
</html>
