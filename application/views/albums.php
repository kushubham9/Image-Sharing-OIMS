<div class="container">
	<div class="page_content">
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
						<div class="col-sm-6">
							<img class="profilepic img-circle pull-left" src="<?php echo base_url().'/'.$userdetails['profilepic'];?>"/>

							<h3 class="user_name"> <?php echo $userdetails['first_name'].' '.$userdetails['last_name']; ?> </h3>
							<h5 class="user_id"> <a href="<?php echo site_url('user/view').'/'.$userdetails['profileid']; ?>"> <?php echo $userdetails['profileid'];?></a> </h5>
							<br/>

							<?php if ($control_perm)
								echo '<p class="edit_pro"> <a href="'.site_url('settings').'"> Edit Profile </a></p>';
							?>
						</div>

						<div class="col-sm-6">
							<div class="social_buttons pull-right">
								<p style="text-align:right"> <a href="<?php echo site_url('user/view').'/'.$userdetails['profileid']; ?>" >
																<?php if (isset($userdetails['image_num']))
																		echo $userdetails['image_num'].' '; 
																	else
																		echo '0 ';
																?> Images </a>&nbsp;&nbsp;|&nbsp;&nbsp;
														<a href="<?php echo site_url('album'); ?>" >
																<?php if (isset($userdetails['album_num']))
																		echo $userdetails['album_num'].' '; 
																	else
																		echo '0 ';
																?> Albums </a>
								</p>
							
								<div class="">
									<h5 style="text-align:right"> <strong> Share Albums </strong></h5>

									<span class='st_facebook_large' displayText='Facebook'></span>
									<span class='st_twitter_large' displayText='Tweet'></span>
									<span class='st_googleplus_large' displayText='Google +'></span>
									<span class='st_linkedin_large' displayText='LinkedIn'></span>
									<span class='st_pinterest_large' displayText='Pinterest'></span>
									<span class='st_email_large' displayText='Email'></span>
								</div>
							</div>


						</div>
					</div>

				</div>
				<div class="row">
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
					<fieldset>
						<legend><?php echo $userdetails['first_name'].'\'s Albums - ';?></legend>
						<form method="get" action="<?php echo site_url()?>";
						<div class="control_tools">
							<div class="pull-right">
								<div class="btn-group"> 
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Actions <span class="caret"></span> </button>
										<ul class="dropdown-menu"> 
											
											<li><?php echo anchor_popup('album/createalbum', 'Create an Album', $atts); ?> </li>
											<?php if ($control_perm)
												echo '<li><a class="del_album" href="#">Delete Album</a></li>';
											?>
											 
											 
										</ul> 
								</div>
							</div>
						</div>
						
						<?php
							// var_dump($userimages);
							echo '<div class="image_grid col-xs-12" >';

								if (sizeof($albumdetails) == 0)
									echo '<h3> No Album Created </h3>';

								foreach ($albumdetails as $key => $value) {
									echo '
										<div class="col-md-4 col-sm-4 col-xs-6 text-center">
											<div class="image_grid_item album_grid">
												<div class="view view-first">
								                    
								                	';
												if (!isset($imagedetails[$value['albumid']][0]['imageid']))
												{
													echo '<img alt="No Image" class="grid_img img-thumbnail" src="'.base_url('assets/images/noimg.jpg').'"/>';
													echo '<input type="checkbox" value="'.$value['albumid'].'" style="display:none" name="albumid[]"/>';
												}

												else
												{
													echo '
													<img alt="'.$imagedetails[$value['albumid']][0]['title'].'" title="'.$imagedetails[$value['albumid']][0]['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$imagedetails[$value['albumid']][0]['src'].'" />
													';
													
													echo '<div class="album_mask">';
														if (isset($imagedetails[$value['albumid']][1]['imageid']))	
														{
															echo '
															<img alt="'.$imagedetails[$value['albumid']][1]['title'].'" title="'.$imagedetails[$value['albumid']][1]['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$imagedetails[$value['albumid']][1]['thumb_src'].'" />
															';
														}		

														if (isset($imagedetails[$value['albumid']][2]['imageid']))	
														{
															echo '
															<img alt="'.$imagedetails[$value['albumid']][2]['title'].'" title="'.$imagedetails[$value['albumid']][2]['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$imagedetails[$value['albumid']][2]['thumb_src'].'" />
															';
														}

														if (isset($imagedetails[$value['albumid']][3]['imageid']))	
														{
															echo '
															<img alt="'.$imagedetails[$value['albumid']][3]['title'].'" title="'.$imagedetails[$value['albumid']][3]['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$imagedetails[$value['albumid']][3]['thumb_src'].'" />
															';
														}		
													echo '</div>';																										
												}


											
											echo '
													<div class="mask">
								                        <h2>'.$value['album_name'].'</h2>
								                        <p>'.$value['description'].'</p>
								                        <a class="info" href="'.site_url('album/view/'.$value['albumid']).'"> View Images </a>
								                    </div>
												</div>

											<div class="img_tools text-center">
												<input type="checkbox" value="'.$value['albumid'].'"   name="albumid[]"/>
												
														<a href="'.site_url('album/view/'.$value['albumid']).'"> 
															<img title="View Album" alt="View Album" style="height:14px;" src="'.base_url('assets/images/view.png').'">
														</a>';

														if ($control_perm)
															echo '
														<a href="'.site_url('album/editalbum/'.$value['albumid']).'"> 
															<img title="Edit Album" alt="Edit Album" src="'.base_url('assets/images/edit.png').'">
														</a>
														

												<a href="'.site_url('album/deletemultiplealbum?albumid='.$value['albumid']).'"> 
													<img title="Delete Album" src="'.base_url('assets/images/del.png').'">
												</a>';
												echo '
											</div>
											
											</div>
										</div>
										
									';
								}

							echo '</div>';
							// var_dump($useralbums);
						?>


					</form>
						
					</fieldset>


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


	$('.del_album').click(function()
	{
		var def_act = $('form').attr('action');
		def_act = def_act + "/album/deletemultiplealbum/";
		$('form').attr("action", def_act);
		$('form').submit();
	})

	

</script>