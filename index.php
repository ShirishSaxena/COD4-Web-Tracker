<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="Include/server_style/js/jquery-1.8.0.min.js"></script>
	<meta charset="utf-8" />
	<title>NcxHost Server List</title>
	 <script src='http://shirish.me/Ncx_Count.php'></script> 
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
	<script type="text/javascript">
$(document).ready(function(){
changePagination('0'); 
});
function changePagination(pageId){
     $(".flash").show();
     $(".flash").fadeIn(400).html
                ('<center>Loading..<br><img src="Include/server_style/img/ajax-loader.gif" /></center>');
     var dataString = 'pageId='+ pageId;
     $.ajax({
           type: "POST",
           url: "get.php<?php if(!empty($_GET['s'])){echo "?s=$_GET[s]";}?>",
           data: dataString,
           cache: false,
           success: function(result){
           $(".flash").hide();
                 $("#pageData").html(result);
           }
      });
}
</script>
<script>
    $(document).ready(function() {
        // SET AUTOMATIC PAGE RELOAD TIME TO 5000 MILISECONDS (5 SECONDS).
        setInterval('refreshPage()', 90000);
    });

    function refreshPage() { 
        location.reload(); 
    }
</script>
<link rel="stylesheet" href="Include/server_style/css/look.css">
<style type='text/css'>
	a {
    text-decoration: none;
}
a:link, a:visited {
    color: gray;
}
a:hover {
    color: red;
}
div.pagination {
padding: 3px;
margin: 3px;
text-align:center;
}
 
div.pagination a {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #AAAADD;
 
text-decoration: none; /* no underline */
color: #000099;
}
div.pagination a:hover, div.digg a:active {
border: 1px solid #000099;
 
color: #000;
}
div.pagination span.current {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #000099;
 
font-weight: bold;
background-color: #000099;
color: #FFF;
}
div.pagination span.disabled {
padding: 2px 5px 2px 5px;
margin: 2px;
border: 1px solid #EEE;
 
color: #DDD;
}
	</style>
	  </head>
<body>
<div id="pageData"></div>
<span class="flash"></span><br>
</body>
</html>