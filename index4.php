<!DOCTYPE html>
<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    require_once("lib/database.inc.php");

    $db = init_db();
    include('./api/api.php');
    // var_dump(kw_forum_content('小米', 11));
    $result;
    $keyword = isset($_GET["k"])?strtolower($_GET["k"]):"";
    if (isset($keyword) && $keyword  != "") {
       // var_dump(kw_forum_content($keyword, 11));
        $result = kw_forum_content($keyword, 10);
    }
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

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
                <a class="navbar-brand" href="#">Start Bootstrap</a>
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

        <div class="row">
          
            <div class="col-md-6">
                <form class="form-inline global-search" role="form">
                    <div class="form-group" style="vertical-align: middle;">
                        <label class="sr-only" for="">請輸入關鍵字</label>
                        <input type="search" class="form-control" id="k" name="k" value="<?php echo $keyword  ?>" placeholder="請輸入關鍵字">
                        <input id="cn" name="cn" type="hidden" value="false">
                    </div>
                    <button type="submit" id="s" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>

                    </button>  

                </form>
            </div>
            
            
        </div>
        <div class="row">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>title</th> 
                  <th>網友覺得</th> 
                  <th>回應數</th> 
                  <th>相關產品</th> 
                </tr>
              </thead>
              <tbody>
                <?php if (isset($result) && sizeof($result )>0 ): ?>
                    <?php foreach ($result as $key => $value): ?>
                      <tr>
                          <td><input type="checkbox" /></td>
                          <!-- <td><?php $value[0]->titile ?></td>  -->
                           <td><a href="<?php echo $value[0]->url; ?>"><?php print_r($value[0]->title) ?></a></td> 
                           <td>
                            <?php 
                                $num1 = rand(0,40);
                                $num2 = rand(0, 30);
                             ?>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: <?php echo $num1; ?>%">
                                    <!-- <span class="sr-only">35% Complete (success)</span> -->
                                    超讚的
                                </div>
                                <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: <?php echo $num2; ?>%">
                                    <!-- <span class="sr-only">20% Complete (warning)</span> -->
                                    沒感覺
                                </div>
                                <div class="progress-bar progress-bar-danger" style="width: <?php echo 100 - $num1 - $num2; ?>%">
                                    <!-- <span class="sr-only">10% Complete (danger)</span> -->
                                    超爛的
                                </div>
                            </div>
                           </td>
                           <td><?php print_r($value[0]->reply_count) ?></td>
                          <td>

                            <?php 

                            $get_prod_sql = " SELECT word FROM prod_word WHERE source_word = '$keyword' OR word LIKE '%$keyword%' ";


                            $res_words = $db->get_results($get_prod_sql,ARRAY_A); 

                            if(isset($res_words))
                                foreach ($res_words as $key => $word) {
                                    //echo strpos($value[0]->title, $value["word"]);
                                    if( strpos(strtolower($value[0]->title), $word["word"]) !== false ){
                                        echo $word["word"].",";
                                    }
                                }
                             ?>


                          </td> 
                      </tr>
                      <?php 

                        $title = $value[0]->title;
                        $url = $value[0]->url;
                        $time = $value[0]->time;
                        $forum = $value[0]->forum;
                        $board = $value[0]->board;
                        $reply_count = $value[0]->reply_count;
                        $is_reply = $value[0]->is_reply;
                        $weight = $value[0]->weight;


                        $insert_sql = "insert into prodkw_forum (title,url,time,forum,board,reply_count,is_reply,weight) 
                                     values ('$title','$url','$time','$forum','$board','$reply_count','$is_reply','$weight')";

                        $update_sql = "update prodkw_forum set title='$title',time='$time',forum='$forum',
                        board='$board',reply_count='$reply_count',is_reply='$is_reply',weight='$weight' where url='$url' ";

                        $select_sql = "select count(*) from prodkw_forum where url='$url' ";
                        $count = $db->get_var($select_sql);
                        if ($count > 0) {
                            $db->query($update_sql);
                        }else{
                            $db->query($insert_sql);
                        }

                       ?>
                    <?php endforeach ?>
                <?php endif ?>
              
             
              </tbody>
            </table>
        </div>
        <div class="row">
            <!-- <button type="submit" id="s" class="btn btn-primary" value="產生">產生</button> -->
            <a class="btn btn-primary" href="index2.php">產生導購頁面</a>
        </div>
    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
