<html>
<head>
    <title>Code Note</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/home.css')}}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewp   ort" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php $num_art=5; ?>
    @include ('topnav')
    <div class="main">
        <div class="usernav">
            <a href="profile.php"><i><?php echo("username"); ?></i></a>
            <a href="logout.php"><i style="float:left;" class="material-icons md-18">exit_to_app</i></a>
        </div>
        <div class="header">
            <h1>Code Note</h1>
        </div>
        <div class="content">
            <?php
            foreach($articles as $article){
            ?>
                <div class="art_head">
                    <h2><a href="./article/id/{{$article["id"]}}"></a>{{$article["header"]}}</h2>
                </div>
                <div class="article" style="height: 250px; overflow: hidden;" ><p>{{$article['article']}}</p>
                </div>

                <div class="info">
                    <i style="float:left; " class="material-icons">date_range</i>
                    <a style="float:left;" href="./article/id/{{$article['id']}}"><?php echo("tarih"); ?></a>
                    <i style="float:left;" class="material-icons" >account_balance</i>
                    <a style="float:left;" href="./archive/category/{{$article['category']}}">PHP</a>
                    <i style="float:left;" class="material-icons" >account_circle </i>
                    <a style="float:left; " href="./profile/id/{{$article['aut_id']}}">Ahmet Anbar</a>
                    <a style="float:right;" href="./article/id/{{$article['id']}}" >Views:5</a>
                    <i style="float:right;" class="material-icons">assessment</i>
                    <a style="float:right;" href="./article/id/{{$article['id']}}">Comments:3</a>
                    <i style="float:right;" class="material-icons">comment</i>
                </div>
            <?php
            }
            ?>
        </div>
        @include ('footer')
    </div>
</body>
</html>