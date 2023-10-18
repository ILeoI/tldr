<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="TLDR Landing Page">
    <meta name="authors" content="KRIS0143">
    <link rel="stylesheet" href="style/landing.css">
    <title>SA GOVERNMENT TLDR</title>
    <style>
        
.Header {
    background-color: #CFFCFF;
    font-size: large;
    padding-top: 10px;
    padding-left: 5px;
}

.Lbanner {

border-style: inset;
padding-left: 15px;
width: 55%;
padding-bottom: 50px;
}

.subtitle {
    font-size: 30px;
    font-family: Arial, Helvetica, sans-serif;
    color: black;
}

.ssubtitle {
    font-size: 20px;
    font-family: Arial, Helvetica, sans-serif;
    color: black;
}

.title {
    font-family: Arial, Helvetica, sans-serif;
    padding-left: 15px;

}

.link {
    background-color: #141301;
  border: none;
  font-size: 18px;
  color: #FFFFFF;
  padding-top: 15px;
  padding-bottom: 15px;
  padding-left: 30px;
  padding-right: 30px;
  width: 20px;
  text-align: center;
  transition-duration: 0.4s;
  text-decoration: none;
  overflow: hidden;
  cursor: pointer;
  
}

.Rbanner {




    position:relative; left: 850px; bottom: 210px;
    text-justify: auto;
    border-style: inset;

}

.container {
    display: flex;
    justify-content: space-between; /* Adjust as needed for spacing between columns */
}

.column {
    flex: 1; /* Each column takes up an equal amount of space */
    padding: 10px;
    border: 5px solid #CCC;
    border-style: inset;
    box-sizing: border-box;
}



</style>

</head>


<body>

<div class="Header">
<img src="Images/ausgov.png" alt="Australian Government Logo"> 
<h1 class="title"> SA Government TLDR</h1>

</div>




<body>
    <div class="container">
        <div class="column">
            <p class="subtitle" >Begin Completing Your Leaner Logbook Online</p>
            <p class = "ssubtitle">Login or Sign Up to Get Started</p>
            <img src="Images/promo2.png" alt="Image Description">
            <a id="login-link" class="link" href="login-page.php">Login</a> <a id="signup-link" class="link" href="signup-page.php">Sign Up</a>

        </div>
        <div class="column">
            <p class="subtitle" > You Can Now Complete Your Learners Test Online</p>
            <p class="ssubtitle" >Click the Image Below To Get Started</p>
            <img src="Images/promo1.jpeg" alt="Image Description">
        </div>
    </div>
</body>
    


</body>
</html>