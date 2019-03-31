<?php // Create Session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />
<meta name="author" content="" />
<!-- css -->
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/fancybox/jquery.fancybox.css" rel="stylesheet"> 
<link href="css/flexslider.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
 
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
    <![endif]-->

</head>
<body id = "center">


		<?php
			function mail_to_yourself($message_test,$fname_test,$address_test)
			{
				$to = 'jiesun@siemens-healthineers.com';
				
				//include './_email.php';
				$f = "WEBSITE COMMENT\n========================\n\n";
				$f .= "\nName: " . $_POST['Full_name'];
				$f .= "\nEmail: " . $_POST['Email'];			
				$f .= "\nmessage: " . $_POST['Message'];
				
				$headers = "from ChangShaKangDi Company";
				mail($to, $headers,$f);
			}
			function  check_information($fname_test,$address_test,$message_test)
			{
			    $avaiable_flag = 1;
				$fname_len = strlen($fname_test);
				$address_len = strlen($address_test);
				$message_len = strlen($message_test);
				$email_flag01 = '@';
				$email_flag02 = '.';
				if (($message_len < "7") || ($fname_len < "3") || ($address_len < "5")  ) 
				{
					echo "The message format is wrong.";
				}
				else
				{
					$pos01 = strpos($address_test, $email_flag01);
					$pos02 = strpos($address_test, $email_flag02);
					if(($pos01  != false) && ($pos02  != false))
					{
						echo "<script type='text/javascript'>alert('This question will be dealt with as soon as possible!');</script>";
						$avaiable_flag = 0;
						mail_to_yourself($message_test ,$fname_test,$address_test);
						
						//store the date in mysql
						$link = mysqli_connect('localhost', 'mydb2689sj', 'wi2hyj', 'mydb2689') or die ("connection failure");
						// Check connection
						if ($link->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						
						// sql to create table
						$sql = "CREATE TABLE KDStore (
							PK INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
							name VARCHAR(30) NOT NULL,
							email VARCHAR(50),
							message VARCHAR(100) NOT NULL
						)";
						
						//if the sql exists, do not create it again
						/*
						if ($link->query($sql) === TRUE) {
							echo "Table MyGuests created successfully";
						} else {
							echo "Error creating table: " . $conn->error;
						}*/
						
						
						
						$sql = "INSERT INTO KDStore (name, email, message) VALUES
					    ('{$fname_test}','{$address_test}','{$message_test }');";
						$link->query($sql);
						
						$sql = "SELECT PK FROM KDStore WHRER message='$message_test'";
						$PK = $link->query($sql);
						
						$_SESSION['PK'] = $PK;
						$_SESSION['name'] = $fname_test;
						$_SESSION['email'] = $address_test;
						$_SESSION['message'] = $message_test;
					}
				}
				
				return $avaiable_flag;
			}
			$message = $_POST['Message'];
			$fname = $_POST['Full_name'];
			$address = $_POST['Email'];
			
	
			
			$test_flag = check_information($fname,$address,$message);
			$url = './contact.html';
			//header('Location:'.$url);
			header('Refresh: 0; url=./contact.html'); 
		?>






<div id="wrapper">
	<!-- start header -->
	<header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                  <a class="navbar-brand" href="index.html"><img src="img/logo.png" alt="logo"/></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
						<li ><a href="index.html">首页</a></li>
						<li ><a href="about.html">关于长沙康地</a></li>
						<li ><a href="news.html">长沙康地动态</a></li>
						<li ><a href="feed.html">长沙康地饲料</a></li>
						<li><a href="service.html">养殖技术</a></li>
						<li class="active"><a href="contact.html">联系我们</a></li>
                    </ul>
                </div>
            </div>
        </div>
	</header><!-- end header -->
	<section id="inner-headline">
		<div class = "about_inner_headline">	
			<img src="img/slides/contact01.jpg"  /> 
		</div>
	</section>
	<section id="content" style = "background:#F5FFFA;">
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div><h2>Get In Touch</h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt eius magni provident, doloribus omnis minus ovident, doloribus omnis minus temporibus perferendis nesciunt..</div>
				<br>
			</div>
		</div>
	<div class="row">
						<div class="col-md-5">
							   <!-- Form itself -->
          <form name="sentMessage" id="contactForm"  action="contact_server.php" method = "post">
	       <h3>Contact me</h3>
		    <div class="control-group">
            <div class="controls">
			<input type="text" class="form-control" name="Full_Name"
			   	   placeholder="Full Name" id="name" required
			           data-validation-required-message="Please enter your name" />
			  <p class="help-block"></p>
		   </div>
	       </div> 	
                <div class="control-group">
                <div class="controls">
			<input type="email" class="form-control" placeholder="Email" name="Email"
			   	            id="email" required
			   		   data-validation-required-message="Please enter your email" />
				</div>
				</div> 	
			  
				 <div class="control-group">
                 <div class="controls">
				 <textarea rows="10" cols="100" class="form-control"   name="Message"
                       placeholder="Message" id="message" required
		       data-validation-required-message="Please enter your message" minlength="5" 
                       data-validation-minlength-message="Min 5 characters" 
                        maxlength="999" style="resize:none"></textarea>
				</div>
                </div> 		 
	     <div id="success"> </div> <!-- For success/fail messages -->
	    <button type="submit" class="btn btn-primary pull-right">Send</button><br />
          </form>	
					</div>
							</div>
	</div>
 
	</section>
	<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="widget">
					<h5 class="widgetheading">Our Contact</h5>
					<address>
					<strong>Overtake company Inc</strong><br>
					JC Main Road, Near Silnile tower<br>
					 Pin-21542 NewYork US.</address>
					<p>
						<i class="icon-phone"></i> (123) 456-789 - 1255-12584 <br>
						<i class="icon-envelope-alt"></i> email@domainname.com
					</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="widget">
					<h5 class="widgetheading">Quick Links</h5>
					<ul class="link-list">
						<li><a href="#">Latest Events</a></li>
						<li><a href="#">Terms and conditions</a></li>
						<li><a href="#">Privacy policy</a></li>
						<li><a href="#">Career</a></li>
						<li><a href="#">Contact us</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="widget">
					<h5 class="widgetheading">Latest posts</h5>
					<ul class="link-list">
						<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></li>
						<li><a href="#">Pellentesque et pulvinar enim. Quisque at tempor ligula</a></li>
						<li><a href="#">Natus error sit voluptatem accusantium doloremque</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
					<div class="widget">
					<h5 class="widgetheading">Recent News</h5>
					<ul class="link-list">
						<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></li>
						<li><a href="#">Pellentesque et pulvinar enim. Quisque at tempor ligula</a></li>
						<li><a href="#">Natus error sit voluptatem accusantium doloremque</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="sub-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="copyright">
						<p>
							Copyright &copy; 2017.Company name All rights reserved.<a target="_blank" href="http://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a>
						</p>
					</div>
				</div>
				<div class="col-lg-6">
					<ul class="social-network">
						<li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
						<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	</footer>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script> 
<script src="js/portfolio/jquery.quicksand.js"></script>
<script src="js/portfolio/setting.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/animate.js"></script>
<script src="js/custom.js"></script> 
 <script src="contact/jqBootstrapValidation.js"></script>
 <script src="contact/contact_me.js"></script>
</body>
</html>
