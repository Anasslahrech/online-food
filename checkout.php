<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();
if(empty($_SESSION["user_id"]))
{
    header('location:login.php');
}
else{
    if(isset($_POST['submit'])){
        foreach ($_SESSION["cart_item"] as $item) {
            $item_total += ($item["price"]*$item["quantity"]);
            $SQL="insert into users_orders(u_id,title,quantity,price) values('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."')";
            mysqli_query($db,$SQL);
        }
        
        if($_POST['mod'] == 'credit_card'){
            $cc_name = $_POST['cc_name'];
            $cc_number = $_POST['cc_number'];
            $cc_expiry = $_POST['cc_expiry'];
            $cc_cvv = $_POST['cc_cvv'];
            
            $SQL = "INSERT INTO credit_card_info (u_id, cc_name, cc_number, cc_expiry, cc_cvv) VALUES ('".$_SESSION["user_id"]."', '$cc_name', '$cc_number', '$cc_expiry', '$cc_cvv')";
            mysqli_query($db, $SQL);
        }
        
        $success = "Merci! Votre commande passée avec succès !";
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Starter Template for Bootstrap</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="site-wrapper">
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.html"> <img class="img-rounded" src="" alt=""> </a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>
                            
                            <?php
                        if (empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">se connecter</a> </li>
                                  <li class="nav-item"><a href="registration.php" class="nav-link active">inscription</a> </li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Vos Commandes</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Se déconnecter</a> </li>';
                        }
                        ?>    
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="top-links">
                <div class="container">
                    <ul class="row links">
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choisir un Restaurant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Choisissez votre plat préféré</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Commandez et payez en ligne</a></li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <span style="color:green;">
                    <?php echo $success; ?>
                </span>
            </div>
            <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="cart-totals-title">
                                            <h4>Récapitulatif du panier</h4>
                                        </div>
                                        <div class="cart-totals-fields">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Sous-total du panier</td>
                                                        <td><?php echo "MAD".$item_total; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Expédition & Manutention</td>
                                                        <td>livraison gratuite</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-color"><strong>Total</strong></td>
                                                        <td class="text-color"><strong><?php echo "MAD".$item_total; ?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <ul class="list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Paiement à la livraison</span>
                                                    <br>
                                                    <span>Votre paiement sera avec le livreur.Merci</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio m-b-10">
                                                    <input name="mod" type="radio" value="credit_card" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description">Carte de crédit </span>
                                                </label>
                                            </li>
                                        </ul>
                                        <div id="credit-card-info" style="display:none;">
                                            <div class="form-group">
                                                <label for="cc_name">Nom sur la carte</label>
                                                <input type="text" class="form-control" id="cc_name" name="cc_name" placeholder="Nom sur la carte">
                                            </div>
                                            <div class="form-group">
                                                <label for="cc_number">Numéro de carte</label>
                                                <input type="text" class="form-control" id="cc_number" name="cc_number" placeholder="Numéro de carte">
                                            </div>
                                            <div class="form-group">
                                                <label for="cc_expiry">Date de Expiration</label>
                                                <input type="text" class="form-control" id="cc_expiry" name="cc_expiry" placeholder="MM/YY">
                                            </div>
                                            <div class="form-group">
                                                <label for="cc_cvv">CVV</label>
                                                <input type="text" class="form-control" id="cc_cvv" name="cc_cvv" placeholder="CVV">
                                            </div>
                                        </div>
                                        <p class="text-xs-center">
                                            <input type="submit" onclick="return confirm('vous êtes sur?');" name="submit" class="btn btn-outline-success btn-block" value="Commandez maintenant">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <section class="app-section">
                <div class="app-wrap">
                    <div class="container">
                        <div class="row text-img-block text-xs-left">
                            <div class="container">
                                <div class="col-xs-12 col-sm-5 right-image text-center">
                                    <figure>
                                        <img src="images/app.png" alt="Right Image" class="img-fluid">
                                    </figure>
                                </div>
                                <div class="col-xs-12 col-sm-7 left-text">
                                    <h3>La meilleure application de livraison</h3>
                                    <p>Maintenant, vous pouvez faire venir de la nourriture où que vous soyez grâce à l'application de livraison et de plats à emporter gratuite et facile à utiliser.</p>
                                    <div class="social-btns">
                                        <a href="#" class="app-btn apple-button clearfix">
                                            <div class="pull-left"><i class="fa fa-apple"></i></div>
                                            <div class="pull-right">
                                                <span class="text">Disponible sur </span>
                                                <span class="text-2">App Store</span>
                                            </div>
                                        </a>
                                        <a href="#" class="app-btn android-button clearfix">
                                            <div class="pull-left"><i class="fa fa-android"></i></div>
                                            <div class="pull-right">
                                                <span class="text">Disponible sur </span>
                                                <span class="text-2">Play store</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="footer">
                <div class="container">
                    <div class="row top-footer">
                        <div class="col-xs-12 col-sm-3 footer-logo-block color-gray"></div>
                        <div class="col-xs-12 col-sm-2 about color-gray">
                            <h5>About Us</h5>
                            <ul>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">History</a></li>
                                <li><a href="#">Our Team</a></li>
                                <li><a href="#">We are hiring</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                            <h5>How it Works</h5>
                            <ul>
                                <li><a href="#">Enter your location</a></li>
                                <li><a href="#">Choose restaurant</a></li>
                                <li><a href="#">Choose meal</a></li>
                                <li><a href="#">Pay via credit card</a></li>
                                <li><a href="#">Wait for delivery</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-2 pages color-gray">
                            <h5>Pages</h5>
                            <ul>
                                <li><a href="#">Search results page</a></li>
                                <li><a href="#">User Sing Up Page</a></li>
                                <li><a href="#">Pricing page</a></li>
                                <li><a href="#">Make order</a></li>
                                <li><a href="#">Add to cart</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                            <h5>Popular locations</h5>
                            <ul>
                                <li><a href="#">Sarajevo</a></li>
                                <li><a href="#">Split</a></li>
                                <li><a href="#">Tuzla</a></li>
                                <li><a href="#">Sibenik</a></li>
                                <li><a href="#">Zagreb</a></li>
                                <li><a href="#">Brcko</a></li>
                                <li><a href="#">Beograd</a></li>
                                <li><a href="#">New York</a></li>
                                <li><a href="#">Gradacac</a></li>
                                <li><a href="#">Los Angeles</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 payment-options color-gray">
                                <h5>Payment Options</h5>
                                <ul>
                                    <li>
                                        <a href="#"><img src="images/paypal.png" alt="Paypal"></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/mastercard.png" alt="Mastercard"></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/maestro.png" alt="Maestro"></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/stripe.png" alt="Stripe"></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/bitcoin.png" alt="Bitcoin"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-4 address color-gray">
                                <h5>Address</h5>
                                <p>Concept design of oline food order and deliveye,planned as restaurant directory</p>
                                <h5>Phone: 06-02-74-77-60 <a href="#"></a></h5>
                            </div>
                            <div class="col-xs-12 col-sm-5 additional-info color-gray">
                                <h5>Addition informations</h5>
                                <p>Join the thousands of other restaurants who benefit from having their menus on TakeOff</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script>
        $('input[name="mod"]').on('change', function() {
            if ($(this).val() == 'credit_card') {
                $('#credit-card-info').show();
            } else {
                $('#credit-card-info').hide();
            }
        });
    </script>
</body>
</html>
