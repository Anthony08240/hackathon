<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                <div class="m-auto w-lg-75 w-xl-50">
                    <h2 class="text-info font-weight-light mb-5">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Inscription</h2>
                    <?php 
                    if(isset($_GET['success'])){
                            if($_GET['success'] == 1 ) {?><br><br>
                            <center><div class="alert alert-success" role="success">
                            Votre inscription a bien etait prise en compte.
                            </div></center>
                    <?php }
                    if($_GET['success'] == 2 ) {?><br><br>
                          <center><div class="alert alert-danger" role="alert">
                           Vos mot de passe ne sont pas identique.
                          </div></center>
                    <?php }
                    if($_GET['success'] == 3 ) {?><br><br>
                          <center><div class="alert alert-danger" role="alert">
                           Cet email est deja pris.
                          </div></center>
                    <?php }} ?>
                    <form method="post" action="traitement/inscription.php">
                        <div class="form-group"><label class="text-secondary">Email</label><input class="form-control" type="text" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$" inputmode="email" name="email"></div>
                        <div class="form-group"><label class="text-secondary">Mot de passe</label><input class="form-control" type="password" required="" name="password"></div>
                        <div class="form-group"><label class="text-secondary">Confirmer le mot de passe</label><input class="form-control" type="password" required="" name="password-repeat"></div>
                        <button class="btn btn-info mt-2" type="submit">Valider</button></form>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image:url(&quot;assets/img/place.jpg&quot;);background-size:cover;background-position:center center;">
               
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
</body>

</html>