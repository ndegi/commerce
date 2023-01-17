<?php
include 'tinypesa.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mpesa Payment</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .mpesa{
            width: 100%;
            height: 100vh;
          
            
        }
        .centerm{
            width: 30%;
            margin: auto;
            padding-top: 60px;
            
        }
        .centerm form{
            width: 100%;
            padding: 20px;
            box-shadow: 4px 0px 8px rgba(0, 0, 0,0.3);
         
        
        }

        .centerm form input[type=text]{
           width: 80%;
           padding: 10px 18px;
           display: inline;
           border: 1.5px solid black;
           outline: none;
           border-radius: 4px;
           margin: 5px 0px 20px;
        }
        .centerm form button{
            width: 90%;
            padding:12px 0;
            border: none;
            outline: none;
            background-color: green;
            color: white;
            border-radius: 20px;
        }
        .image{
            width: 90%;
            height: 200px;
        }
        .image img{
            width: 100%;
            height: 100%;
        }
        form::after{
            content: "";
            clear: both;
            display: table;
        }
        
    </style>

</head>
<body>
    <div class="mpesa">
        <div class="centerm">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>"method="POST">
            <div class="image">
                <img src="mpesa.png" alt="">
            </div>
            <label for="">Amount</label>
             <input type="text"  name="amount" value="">
             <label for="">phonenumber</label>
             <input type="text" name="number" placeholder="Enter your phone number">
            <button type="submit" name="submit">continue</button>
          </form>
        </div>
    </div>
</body>
</html>