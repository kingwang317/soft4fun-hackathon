<!DOCTYPE html>
<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    include('./api/api.php');
    // var_dump(kw_forum_content('小米', 11));
    $result;
    $keyword = isset($_GET["k"])?strtolower($_GET["k"]):"zenfone 5";
    if (isset($keyword) && $keyword  != "") {
       // var_dump(kw_forum_content($keyword, 11));
        $result = kw_forum_content($keyword, 10);
        $prod = yahoo_search_item($keyword);
        //print_r($prod->query->results->result->hits->ec_productid);
        $relate_prod = yahoo_get_relate_item($prod->query->results->result->hits->ec_productid);
        //print_r($relate_prod->query->results->json->result);

        $relate_prod = $relate_prod->query->results->json->result;
    }


 ?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Portfolio Item - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/portfolio-item.css" rel="stylesheet">
    <link href="css/shop-item.css" rel="stylesheet">
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">It4Fun 2014 Hackathon</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#">About</a>
                        </li>
                        <li>
                            <a href="#">Services</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Portfolio Item Heading -->

            <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">
                    <a href="#" class="list-group-item">ASUS</a>
                    <a href="#" class="list-group-item">小米</a>
                    <a href="#" class="list-group-item">華為</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">防潑水全頻新機！旗艦免萬熱賣

                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Portfolio Item Row -->
                <div class="row">

                    <div class="col-md-5">
                        <img class="img-responsive" src="https://tw.buy.yahoo.com/webservice/gdimage.ashx?id=5245649&s=400&t=0&sq=1" alt="">
                    </div>

                    <div class="col-md-7">
                        <h3>ASUS Zenfone 5 A500KL (2G/16G) 5吋4G LTE智慧手機</h3>
                        <h3><small>建議售價$6,990</small></h3>
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p> -->
                        <!-- <h3>Project Details</h3> -->
                        <ul >
                                <li>2G RAM / 16G ROM</li>
                                <li>5吋HD IPS+面板+16:9比例</li>
                                <li>高通1.2GHZ 四核心</li>
                                <li>800萬畫素+F2.0 光圈+四倍感光</li>
                                <li>獨家ASUS ZenUI</li>
                                <li>支援4G LTE台灣全頻段</li>
                                <li>完整型號:A500KL</li>
                        </ul>
                        <a class="btn btn-primary" target="_blank" href="https://tw.buy.yahoo.com/gdsale/gdsale.asp?gdid=5245649&hpp=hero_big04">我要購買</a>
                        <h3>網友都覺得</h3>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 35%">
                                <!-- <span class="sr-only">35% Complete (success)</span> -->
                                超讚的
                            </div>
                            <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%">
                                <!-- <span class="sr-only">20% Complete (warning)</span> -->
                                沒感覺
                            </div>
                            <div class="progress-bar progress-bar-danger" style="width: 45%">
                                <!-- <span class="sr-only">10% Complete (danger)</span> -->
                                超爛的
                            </div>
                        </div>
                    </div>



            </div>
            <!-- /.row -->

            <!-- Related Projects Row -->
            <div class="row">

                <div class="col-lg-12">
                    <h3 class="page-header">相關產品</h3>
                </div>

           <!--  <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="https://tw.buy.yahoo.com/webservice/gdimage.ashx?id=13678383&s=200&t=2" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="https://tw.m.yimg.com/res/gdsale/st_pic/5122/st-5122643-s200.jpg" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="https://tw.buy.yahoo.com/webservice/gdimage.ashx?id=13658663&s=200&t=2" alt="">
                </a>
            </div>

            <div class="col-sm-3 col-xs-6">
                <a href="#">
                    <img class="img-responsive portfolio-item" src="https://tw.m.yimg.com/res/gdsale/st_pic/4914/st-4914742-s200.jpg" alt="">
                </a>
            </div> -->
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class='item active'>
                        <!-- <img class="slide-image" src="http://placehold.it/800x300" alt=""> -->
                        <?php 

                        foreach ($relate_prod as $key => $value) {
                                
                            ?>
                        
                            
                                <div class="col-sm-3 col-xs-6">
                                    <a href="<?php echo $value->link ?>">
                                    <img class="img-responsive portfolio-item" src="<?php echo $value->imageLinks->medium ?>" alt="">
                                    </a>
                                </div>

                            <?php  
                            if($key%3 == 0 && $key !=0){
                                echo  '</div>';
                                   echo  '</div>';
                                   echo  '<div class="carousel-inner">';
                                   echo "<div class='item' >";
                            }
                        }

                         ?>

                   
                  </div>
                  </div>

               
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>

        </div>
        <!-- /.row -->

        <div class="row">


            <div class="row">
                <div class="col-md-12">
                  <div class="col-lg-12">
                    <h3 class="page-header">相關討論</h3>
                </div>

                  <!--   <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div> -->
                </div>
            </div>

                <?php if (isset($result) && sizeof($result )>0 ): ?>
                    <?php foreach ($result as $key => $value): ?>

                      <?php 

                        $title = $value[0]->title;
                        $url = $value[0]->url;
                        $time = $value[0]->time;
                        $forum = $value[0]->forum;
                        $board = $value[0]->board;
                        $reply_count = $value[0]->reply_count;
                        $is_reply = $value[0]->is_reply;
                        $weight = $value[0]->weight;


                       ?>

            <div class="row">
                <div class="col-md-12">
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <?php echo $forum.">>".$board; ?>
                    <span class="pull-right"><?php echo $time; ?></span>
                    <p><a href="<?php echo  $url; ?>"><?php echo $title; ?></a></p>
                </div>
            </div>
            <hr />
                    <?php endforeach ?>
                <?php endif ?>
              

        </div>
    </div>


</div>
<!-- /.container -->
  <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Soft4fun 2014 Hackathon</p>
                </div>
            </div>
        </footer>

    </div>

<!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
