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
								echo '<p class="edit_pro"> <a href="'.site_url('album/editalbum/').'/'.$albumdetails['albumid'].'"> Modify Album </a>
									&nbsp;&nbsp;&nbsp; <a style="color:red; font-style:italic" href="'.site_url('album/deletemultiplealbum?albumid=').''.$albumdetails['albumid'].'"> Delete Album </a>

								</p>';
								?>
						</div>

						<div class="col-sm-6">
							<div class="social_buttons pull-right" style="padding-right: 0px">
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
									<h5 style="text-align:right"> <strong> Share Album </strong></h5>

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

	            <div class="row">
				<fieldset>
					<legend style="position:relative"><?php echo $albumdetails['album_name'].'\'s Images '; echo '<p class="album_description"><small>'.$albumdetails['description'].'</small></p>';?>
							<p style="text-align:right; position:absolute; top:0px; right:0px" class="album_img_num">
								<a class="select_all" href="#"> Select All </a>&nbsp;&nbsp;
								<a class="unselect_all" href="#"> Unselect </a>&nbsp;&nbsp;&nbsp;
									<?php 
										if (isset($albumdetails['image_num']))
											echo $albumdetails['image_num'].' Images';
									?>
								</p>
					</legend>
					<form method="get" class="form-horizontal" action="<?php echo site_url()?>";>

					<div class="col-sm-8">
						<div class="form-group">
						          <label for="albumlink" class="control-label col-sm-3"> Share Album </label>

							<div class="col-sm-9">
							     <input class="form-control" type="text" id="albumlink" value="<?php echo site_url('album/view').'/'.$albumdetails['albumid'];?>"/>
						     </div>
				        </div>
				     </div>

				    <div class="col-sm-4">
						<div class="control_tools pull-right">
							<div class="">
								<div class="btn-group"> 
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Actions <span class="caret"></span> </button>
										<ul class="dropdown-menu"> 
											<li><a class="embed_img" href="#">Get Embed Codes</a></li> 
											<?php if (!$control_perm)
												goto skipcontrol;

												?>
											<li><?php echo anchor_popup('album/createalbum', 'Create an Album', $atts); ?> </li>
											<li><a class="mv_album" data-toggle="modal" data-target="#myModal"> Move to Album</a> </li>
											<li><a class="del_img" href="#">Delete</a></li> 
											<?php
												skipcontrol:
											?>
										</ul> 
								</div>
							</div>
						</div>
					</div>
					


					<?php
						// var_dump($userimages);
						echo '<div class="image_grid col-xs-12" >';

									foreach ($imagedetails as $key => $value) {
										echo '
											<div class="col-md-3 col-sm-4 col-xs-6 text-center">
												<div class="image_grid_item ">
													<div class="view view-third">
															<img alt="'.$value['imageid'].'" title="'.$value['title'].'" class="grid_img img-thumbnail" src="'.base_url().''.$value['src'].'" />
															<input type="checkbox" value="'.$value['imageid'].'" style="display:none" name="imageid[]"/>
															<div class="mask">
										                        <h2>'.$value['title'].'</h2>
										                    </div>
													</div>

													<div class="img_tools text-center">
														<a href="'.site_url('viewimage/id/'.$value['imageid']).'"> 
															<img style="height:14px;" src="'.base_url('assets/images/view.png').'">
														</a>';

														if ($control_perm)
														{
															echo '
																<a href="'.site_url('viewimage/editimage/'.$value['imageid']).'"> 
																	<img src="'.base_url('assets/images/edit.png').'">
																</a>
																
																<a class="pic_mv_album" data-toggle="modal" data-target="#myModal">
																	<img src="'.base_url('assets/images/move.png').'">
																</a>
																<a href="'.site_url('viewimage/deleteimage/'.$value['imageid']).'"> 
																	<img src="'.base_url('assets/images/del.png').'">
																</a>';
														}
											echo '			
													</div>
												</div>
											</div>
										';
									}

								echo '</div>';
						// var_dump($useralbums);
					?>


				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="myModalLabel">Move to Album</h4>
				      </div>
				      <div class="modal-body">
				      	<p>Select an existing album to move the images. You can also <a href="<?php echo site_url('album/createalbum');?>" >create a new album </a>and move the images there.</p>
				      
				       	<select name="albumid" class="form-control">
				       			<option value="0" selected >Select an Album </option>
				       		<?php
				       			foreach ($useralbums as $value) {
				       				echo '<option value="'.$value['albumid'].'">'.$value['album_name'].'</option>';
				       			}
				       		?>
				       	</select>
				      
				       </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="mov_btn btn btn-primary">Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>


				</form>
					
				</fieldset>


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

	$('.mov_btn').click(function()
	{
		var def_act = $('form').attr('action');
		def_act = def_act + "/album/movetoalbum/";
		$('form').attr("action", def_act);
		$('form').submit();
	})

	$('.del_img').click(function()
	{
		var def_act = $('form').attr('action');
		def_act = def_act + "/viewimage/deletemultiple/";
		$('form').attr("action", def_act);
		$('form').submit();
	})

	$('a.select_all').click(function()
		{
			$('.grid_img').each(function()
			{
				$(this).next('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
	        	this.style.border = '2px solid #38A';
	       	 	this.style.margin = '0px';
			})
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

	$(window).load(function()
	{
		$('a.pic_mv_album').click(function()
		{
			$(this).parent().parent().find('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
		})

		
	});

	$('.embed_img').click(function()
	{
		var def_act = $('form').attr('action');
		def_act = def_act + "/viewimage/embeded_code/";
		$('form').attr("action", def_act);
		$('form').submit();
	})
	

</script>