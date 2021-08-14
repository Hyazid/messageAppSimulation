
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Bootstrap core CSS -->
        <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

        <!-- Bootstrap core JavaScript -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="vendor-front/jquery/jquery.min.js"></script>
        <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>
        
        <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
    <title>Document</title>
</head>
<body>
<form action="" class="navbar-form navbar-left">
            <div class="input-group">
                <input type="text" class="form-control" id="search-bar" name="search-bar" placeholder="search..." autocomplete="off"/>
                
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" name="searchBtn" id="searchBtn">
                    <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
                    </button>
                </div>
                
            </div>
            <div class="countryList" id="countryList" style="position:absolute; width: 500px;z-index: 1001;">
            </div>      
        </form>
    <h2></h2>
<?php
    //include('profile.php');
    if (isset($_GET["query"])) {
        $query= urldecode($_GET["query"]);
        $query= preg_replace('#[^a-z 0-9?!]#i',"", $query);

        echo "good";

    }
    if (!isset($query)) {

        header('location:profile.php');

    }
    else {?>
    <h4> hellow </h4>
    <div class="row">
        <div class="col-md-9">
            <h3>search result for <b><?php echo $query?></b> </h3>
            <div id="search_result_area">
                <div class="wrapper-preview">
                     <i class="fas fa-circle-notch  fa-spin  " style="font-size: 24px;"></i>"

                </div>
            </div>

        </div>

    </div>

    <?php
    //to include his footer  
}
?>
    
</body>
</html>
<script>
    // $(document).ready(function(){

    //     var query_result="<?php echo $query ;?>";
    //     $("#search-bar").val(query_result);
        
    //     $.ajax({
    //      url:'search_action.php',
    //      method:'POST',
    //     data:{query_result:query_result},
    //     success:function(data){
    //      $("#search_result_area").html(data);

    //     }

    //     })
        

    // })

</script>

