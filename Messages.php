<!DOCTYPE html>
<html>
<head>
	<title>Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <style>
		/* css in case of a short page */
		@media (min-width: 995px) {
		body{
			height:100vh
		}
		.footer{
			position: absolute;
			bottom:0;
		}
	}
	</style>
</head>
<body>
<?php
include "navbar.php";
  ?>     
        
	    <div class="search-box">
        <input type="text" placeholder="Search..." />
        <div class="result"></div>
    </div>
    <h6>Last conversation:</h6>
     <?php
         $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "webproject";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $lastMessage = "SELECT DISTINCT Sender_ID FROM messages WHERE Receiver_ID = ".$_SESSION['ID_Person'];
$lastMessageResult = mysqli_query($conn,$lastMessage) or die(mysqli_error($conn));
if(mysqli_num_rows($lastMessageResult) > 0) {
    while($lastMessageRow = mysqli_fetch_array($lastMessageResult)) {
        $sent_by = $lastMessageRow['Sender_ID'];
        $getSender = "SELECT * FROM person WHERE ID_Person = '$sent_by'";
        $getSenderResult = mysqli_query($conn,$getSender) or die(mysqli_error($conn));
        $getSenderRow = mysqli_fetch_array($getSenderResult);
        ?>
        <div>
        <img src = "./images/<?=$getSenderRow['Profile_Picture']?>" class="img-circle" width = "40"/> 
        <?=$getSenderRow['Username'];?>
        <a href="./message.php?receiver=<?=$sent_by?>">Send message</a>
        </div><br>
<?php }
} 
else {
    echo "No conversations yet!";
}
     ?>
     <h6>Searching on:</h6>
    <div id="searchresult"></div>
    <script>
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        if(inputVal!=""){
            $.ajax({
                       url:"livesearch.php",
					   method:"POST",
					   data:{term:inputVal}, 
					   success:function(data){
						   $("#searchresult").html(data);
					   }

            });
        } else{
            $("#searchresult").empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>
		<?php

include "footer.php";        
?>
</body>
</html>