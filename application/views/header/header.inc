<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
	    
	    <title> 
	    	<?php
				if (isset($title))
					echo $title. ' | ';

				if (isset($globalsettings))
				{
					echo $globalsettings['optionvalue'];
				}
			?>
		</title>
		<link rel="stylesheet" type="text/css" href=' <?php echo base_url().'assets/bootstrap/css/bootstrap.css'; ?> '/>
		<link rel="stylesheet" type="text/css" href=' <?php echo base_url().'assets/style.css'; ?> '/>
	
		<script type="text/javascript" src=" <?php echo base_url().'assets/jquery.js'; ?> "></script>
		<script type="text/javascript" src=" <?php echo base_url().'assets/bootstrap/js/bootstrap.min.js'; ?> "></script>
		<?php
		if (isset($additional_js))
			echo $additional_js;
		?>
	</head>

	<body>
		<div id="header">
			<div class="container">
				<div class="row">
					

					<div class="col-sm-5">

						<div class="logo">
							<a href="<?php echo site_url();?>"> OIMS <img class="logo_img" src=""/></a>
						</div>
					</div>

					<div class="col-sm-7">
						<nav class="navbar pull-right" role="navigation"> 
							<div class="navbar-header"> 
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse"> 
									<span class="sr-only"></span> 
									<span class="icon-bar"></span> 
									<span class="icon-bar"></span> 
									<span class="icon-bar"></span> 
								</button> 

							</div> 

							<div class="collapse navbar-collapse" id="example-navbar-collapse"> 
								<ul class="nav navbar-nav"> 

									<li class="dropdown"> 
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Explore <b class="caret"></b> </a> 

											<ul class="dropdown-menu"> 
												<?php
													$categories = $this->session->userdata('globalcategory');
												
													foreach ($categories as $value) {
														echo '<li ><a href="'.site_url('viewimage/category/'.$value['categoryid']).'"> '.$value['categoryname'].' </a></li>';
													}
												?>
											</ul>
									</li>
									<li ><a href="<?php echo site_url('viewimage/random');?>"> Random </a></li> 

									<li class="active"><a href="<?php echo site_url();?>"> Upload </a></li> 
									<?php 
										if (!$this->session->userdata('userid'))
										{
											echo '<li><a href="'.site_url("user/login").'" > Login</a></li> ';
											echo '<li><a class="btn btn-primary" href="'.site_url("user/registration").'" > Register </a></li> ';
										}
										
										else
										{
											echo '<li class="dropdown"> 
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Account <b class="caret"></b> </a> 

										<ul class="dropdown-menu"> 
											<li><a href="'.site_url("user").'">My Profile</a></li>
											
											<li><a href="'.site_url("album").'">My Albums</a></li> 
											
											<li><a href="'.site_url("settings").'">Account Settings</a></li> 
										</ul> 
									</li>';
											echo '<li><a href="'.site_url("user/logout").'" > Log Out </a></li> ';
										}
									?>


									
									
							</div> 
						</nav>
					</div>
				</div>
			</div>
		</div>


