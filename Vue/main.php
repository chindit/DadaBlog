<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Chindit">
        <!--Bootstrap (pour la pagination)-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!--JQuery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <!--CSS perso-->
        <link rel="stylesheet" href="Vue/style.css">
        <title>DadaBlog − Accueil</title>
    </head>
    <body>
        <header>
            <div class="connexion">
                <?php if(isset($_SESSION['admin'])){  ?><a href="index.php?controleur=admin/index">Administration</a> <?php } else { ?>
                    <a href="#" id="connectButton">Connexion</a>
                    <div id="connectBox">
                        <?php if(isset($_SESSION['login_msg'])){ echo $_SESSION['login_msg']; } ?>
                        <form method="post" action="index.php?controleur=admin/index">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" name="pseudo" maxlenght="50" required>
                            <label for="passwd">Mot de passe</label>
                            <input type="password" name="passwd" required>
                            <input type="submit" name="submit">
                        </form>
                    </div>
                    <?php } //Fin else login ?>
            </div>
            <h1 class="title">DadaBlog</h1>
            <h5 class="subtitle">DadaBlog, les <span class="barre">hommes</span> développeurs savent pourquoi</h5>
        </header>
        <nav id="ariane">
            <a href="index.php">Accueil</a>
        </nav>
        <section id="main">
            <?php require_once('Vue/'.$templateName); ?>
        </section>
    </body>
    <script type="text/javascript">
        $('#connectButton').click(function(event){
            event.preventDefault();
            if($('#connectBox').is(':visible')){
                $('#connectBox').hide();
            }
            else{
                $('#connectBox').show();
            }
        });
    </script>
</html>
