<?php

//connect to the db server
$cxn = mysql_connect('mysql.onepotcooking.com', 'scps', 'webdev2011!');

//select a database from the server
$db = mysql_select_db('classdb', $cxn);

//get the search term from the request
$s = $_REQUEST["searchterm"];
$d = $_REQUEST["category"];

//only run a query, if the user submitted the form
if (!empty($d)) {
	$query = "SELECT * FROM msellers_jobposts WHERE categories = '{$d}'";
	
	//run the query
	$result = mysql_query($query);

	//debug
	echo mysql_error();
	}
	
	
	
elseif (!empty($s)) {

	//assemble a parameterized query for the search term
	$query = "SELECT * FROM msellers_jobposts WHERE job_title LIKE '%{$s}%'";

	//run the query
	$result = mysql_query($query);

	//debug
	echo mysql_error();
	
}//endif

else {
	$query="SELECT * FROM msellers_jobposts WHERE 1 ORDER BY created DESC LIMIT 0,10" ;
					
	$result=mysql_query($query);
	echo mysql_error ();
					
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Final Project - Home Page</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="final_project.css"/>
		<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
		<script>
				$(document).ready(function(){  
			  
				$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  
			  
				$("ul.topnav li span").click(function() { //When trigger is clicked...  
			  
					//Following events are applied to the subnav itself (moving subnav up and down)  
					$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click  
			  
					$(this).parent().hover(function() {  
					}, function(){  
						$(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up  
					});  
			  
					//Following events are applied to the trigger (Hover events for the trigger)  
					}).hover(function() {  
						$(this).addClass("subhover"); //On hover over, add class "subhover"  
					}, function(){  //On Hover Out  
						$(this).removeClass("subhover"); //On hover out, remove class "subhover"  
				});  
			  
			});
		</script>
	</head>
	<body>
		

		<div id="container">
			<div id="logo">
				<h1 class="logotext">legally hired</h1>
			</div>
			<div id="nav">
			<div id="navlinkscontainer">
				<ul class="header_nav">
					<li><a class="nav_style" href="#">All Posts</a></li>
					<li><a class="nav_style" href="postjob.php">Post a Job</a></li>
					<li><a class="nav_style" href="#">Contact Us</a></li>
					<li><a class="nav_style" href="#">About Us</a></li>
				</ul>
			</div>
			</div>
				<div class="clear"></div>
			<div id="container_body">
				<div id="job_listings_container">
					<div id="search_container">
						<div id="dropdowns">
							<ul class="topnav"> 
								<li>  
									<a class="topnav_text" href="#">CATEGORIES</a> 
									<ul class="subnav">  
										<li><a class="subnav_textstyle" href="final_project.php?category=attorney">Attorney
											<h4 class="lawfirmdescrip">JD-required jobs</h4>
										</a>
											
										</li>  
										<li><a class="subnav_textstyle" href="#">Paralegal
											<h4 class="lawfirmdescrip">Doc review, contract drafting, etc.</h4>
										</a>
											
										</li> 
										<li><a class="subnav_textstyle" href="#">Academic
											<h4 class="lawfirmdescrip">Teaching gigs & law school admin roles</h4>
										</a>
											
										</li>
										<li><a class="subnav_textstyle" href="#">Internship
											<h4 class="lawfirmdescrip">Summer associate positions & others</h4>
										</a>
											
										</li>  		
									</ul>  
								</li>
								<li>  
									<a class="topnav_text" href="#">LOCATION</a>  
									<ul class="subnav">  
										<li class="zipcode">Enter zip code
											<input class="text" type="text">
										</li> 
									</ul>  
								</li>  
							</ul> 
						</div>
						 <form action="final_project.php" method="get">
						  <input type="text" name="searchterm" id="searchterm" value="<?= $searchTerm ?>" />
						  <input type="submit" value="Search" />
						</form>
						
					</div>
					
					<?php while($row = mysql_fetch_array($result)) :?>
					
					<table id='row1_border'><tbody>
							<tr class='job_listing'>
								<td class='job'>
									<div class='company_image'>
									<a href="jobposting.php?id=<?php echo $row['id']; ?>">
										<img src="<?php echo $row['image_url'] ?>" height="50" width="50" />
									</a>
									</div>

									<div class='job_title'>
										<span class='job_title_style'>
											<a href="jobposting.php?id=<?php echo $row['id']; ?>"><?php echo $row['job_title']; ?></a>
										</span>
									</div>
									<div class='company_name'>
										<span class='company_name_style'>
											<?php  echo $row['company_name']; ?>
										</span>
									</div>
									<div class='company_tagline'>
										<span class='company_tagline_style'>
										
										</span>
									</div>
								</td>
								<td class='location'>
									<div class='location_div'>
										<span class='location_style'>
										   <?php  echo $row['location']; ?>

									</span>
									</div>
								</td>
								<td class='job_type'>
									<div class='job_type_div'>
										<?php if($row['job_type']=='fulltime') {?>
											<span class='job_type_style'>
												<?php echo $row['job_type']; ?>
											</span>
									   <?php } elseif($row['job_type']=='parttime') {?>
											<span class='job_type_style2'>
												<?php echo $row['job_type']; ?>
											</span>
										<?php } ?>
										<?php if($row['job_type']=='internship') {?>
											<span class='job_type_style3'>
												<?php echo $row['job_type']; ?>
											</span>
									   <?php } elseif($row['job_type']=='freelance') {?>
											<span class='job_type_style4'>
												<?php echo $row['job_type']; ?>
											</span>
										<?php } ?>
									</div>
								</td>
							</tr>
							
							<?php endwhile ?>
							
						</tbody>
					</table>
						
					

				</div>	
		
				<div id="right_column">
					<div class="postajob_button"></div>
					<p class="copy2">starting at<span class="price"> $99</span>
					<hr>
					<p class="copy1"><span class="ourname">Legally Hired</span> is where companies and legal professionals meet to make a better world.<p>
				</div>
			</div>	
				<div class="clear"></div>
		</div><!--End Container-->
		<hr class="footerhr">
		<div id="footer">
			<div id="footer_links">
				<ul class="footer_nav">
					<li><a class="footerlinks_style" href="#">All Posts</li>
					<li><a class="footerlinks_style" href="postjob.html">Post a Job</li>
					<li><a class="footerlinks_style" href="#">Contact Us</li>
					<li><a class="footerlinks_style" href="#">About Us</li>
				</ul>
			</div>
		</div>
		
	</body>
</html>