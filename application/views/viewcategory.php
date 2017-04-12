<div class="container">
	<div class="page_content">

						<?php
		              if (!$this->session->flashdata('success_mess') && !isset($success_mess))
		                goto skipsuccess;
		            ?>
		            <div class="row">
		              <div class="col-sm-8 col-sm-offset-2 text-center">
		                <div class="alert alert-success">
		                    <a href="#" class="close" data-dismiss="alert">&times;</a>
		                    <strong>Success!</strong> <?php echo $this->session->flashdata('success_mess'); if (isset($success_mess)) echo $success_mess;?>
		                </div>
		              </div>
		            </div>

		            <?php
		              skipsuccess:
		            ?>

		            <?php
		              if (!$this->session->flashdata('failure_mess'))
		                goto skipfailure;
		            ?>
		            
		            <div class="row">
		              <div class="col-sm-8 col-sm-offset-2 text-center">
		                <div class="alert alert-danger">
		                    <a href="#" class="close" data-dismiss="alert">&times;</a>
		                    <strong>Failure!</strong> <?php echo $this->session->flashdata('failure_mess');?>
		                </div>
		              </div>
		            </div>

		            <?php
		              skipfailure:
		            ?>
	<?php
												$atts = array(
									              'width'      => '800',
									              'height'     => '600',
									              'scrollbars' => 'yes',
									              'status'     => 'yes',
									              'resizable'  => 'yes',
									              'screenx'    => '0',
									              'screeny'    => '0'
									            );
	?>
		<div class="row">
			
			<div class="col-xs-12">
				<div class="profile_header">

					<div class="row">
						<?php if (!isset($userdetails))
							goto skipprofile;
						?>
						<div class="col-sm-6">
							<img class="profilepic img-circle pull-left" src="<?php echo base_url().'/'.$userdetails['profilepic'];?>"/>

							<h3 class="user_name"> <?php echo $userdetails['first_name'].' '.$userdetails['last_name']; ?> </h3>
							<h5 class="user_id"> <a href="<?php echo site_url('user/view').'/'.$userdetails['profileid']; ?>"> <?php echo $userdetails['profileid'];?></a> </h5>
							<br/>
							<p class="edit_pro"> <a href="<?php echo site_url('settings');?>"> Edit Profile </a></p>
						</div>

						<div class="col-sm-6">
							<p class="pull-right"> <a href="<?php echo site_url('user/view').'/'.$userdetails['profileid']; ?>" >
															<?php if (isset($userdetails['image_num']))
																	echo $userdetails['image_num'].' '; 
																else
																	echo '0 ';
															?> Images </a>&nbsp;&nbsp;|&nbsp;&nbsp;
													<a href="<?php echo site_url('album/show').'/'.$userdetails['userid']; ?>" >
															<?php if (isset($userdetails['album_num']))
																	echo $userdetails['album_num'].' '; 
																else
																	echo '0 ';
															?> Albums </a></p>
						</div>

						<?php
							skipprofile:
						?>
					</div>
				</div>


				<div class="random_images">

					<div class="row">
						<fieldset>
							<legend><?php echo $categorydetails['categoryname'].'\'s Category';?>
								<p style="text-align:right;" class="album_img_num">
									<a class="select_all" href="#"> Select All </a>&nbsp;&nbsp;
									<a class="unselect_all" href="#"> Unselect </a>&nbsp;&nbsp;&nbsp;
								</p>
							</legend>

							<form method="get" action="<?php echo site_url()?>";
							<div class="control_tools">
								<div class="pull-right">
									<div class="btn-group"> 
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Actions <span class="caret"></span> </button>
											<ul class="dropdown-menu"> 
												<li><a class="embed_img" href="#">Get Embed Codes</a></li> 
												
											</ul> 
									</div>
								</div>
							</div>
							
							<!-- Image Grid Begins -->
							<?php
								// Get the user image Grid
								// var_dump($userimages);
								echo '<div class="image_grid col-xs-12" >';

									foreach ($imagedetails as $key => $value) {
										echo '
											<div class="col-md-3 col-sm-4 col-xs-6 text-center">
												<div class="image_grid_item ">
													<div class="view view-third">
															<img alt="'.$value['imageid'].'" title="'.$value['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$value['thumb_src'].'" />
															<input type="checkbox" value="'.$value['imageid'].'" style="display:none" name="imageid[]"/>
															<div class="mask">
										                        <h2>'.$value['title'].'</h2>
										                    </div>
													</div>

													<div class="img_tools text-center">
														<a href="'.site_url('viewimage/id/'.$value['imageid']).'"> 
															<img style="height:14px;" src="'.base_url('assets/images/view.png').'">
														</a>
														
													</div>
												</div>
											</div>
										';
									}

								echo '</div>';

							?>


						</form>
						</fieldset>


						
					</div>
					<!-- Row Ends -->

				</div>

			</div>
		</div>
	</div>
</div>


<script>

	$(window).load(function()
	{
		var height = 0;
		$('.image_grid_item').each(function()
		{
			if ($(this).height() > height)
				height = $(this).height();
		})
		$('.image_grid_item').height(height);
	})

	$('.grid_img').on('click', function(){
	    if(!$(this).next('input[type="checkbox"]').prop('checked')){
	        $(this).next('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
	        this.style.border = '2px solid #38A';
	        this.style.margin = '0px';
	    }
	    else{
	        $(this).next('input[type="checkbox"]').prop('checked', false).removeAttr('checked');
	        this.style.border = '0';
	        this.style.margin = '2px';
	    }
	});

	

	$('a.select_all').click(function()
		{
			$('.grid_img').each(function()
			{
				$(this).next('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
	        	this.style.border = '2px solid #38A';
	       	 	this.style.margin = '0px';
			})
		})

	

	$('.embed_img').click(function()
	{
		var def_act = $('form').attr('action');
		def_act = def_act + "/viewimage/embeded_code/";
		$('form').attr("action", def_act);
		$('form').submit();
	})

	$('a.unselect_all').click(function()
		{
			$('.grid_img').each(function()
			{
				$(this).next('input[type="checkbox"]').prop('checked', false).removeAttr('checked');
		        this.style.border = '0';
		        this.style.margin = '2px';
			})
		})
	

</script>