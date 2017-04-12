<div class="container">
  
  	<div class="page_content">
		<div class="row">
	    	<div class="col-md-offset-2 col-md-8 col-sm-10 col-sm-offset-1 ">

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

	    		<div class="image_config">
	    			<div class="config_item">
	    				<p>	<strong> Title: </strong> <?php echo $imagedetails['title']; ?></p>
	    			</div>
	    			<div class="config_item">
	    				<p>	<strong> Date: </strong> <?php echo $imagedetails['date_uploaded']; ?></p>
	    			</div>
	    			<div class="config_item">
	    				<p>	<strong> Height: </strong> <?php echo $imagedetails['height']; ?>px</p>
	    			</div>
	    			<div class="config_item">
	    				<p>	<strong> Width: </strong> <?php echo $imagedetails['width']; ?>px</p>
	    			</div>
	    			

	    		</div>

	    		
	    		<div class="view_image text-center">
	    			<a href="<?php echo base_url().''.$imagedetails['src'];?>" target="_blank">
	    				<img class="img-thumbnail" src="<?php echo base_url().''.$imagedetails['src'];?>"/>
	    			</a>
	    		</div>

	    	</div>
	    </div>

    	<div class="row">
    		<div class="col-xs-12">
    			<div class="image_details">
							<?php 
								if (isset($img_owner_details))
								{
									echo '
									<div class="btn-group pull-right"> 
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> '.$img_owner_details['first_name'].' '.$img_owner_details['last_name'].' <span class="caret"></span> </button>
										<ul class="dropdown-menu"> 
											<li><a href="'.site_url("user/".$img_owner_details['profileid']).'"> User Profile </a> </li>
											<li><a href="'.site_url("user/".$img_owner_details['profileid']).'"> User Images </a> </li>
											<li><a href="'.site_url("user/album".$img_owner_details['profileid']).'"> User Albums </a> </li>
											 
										</ul> 
										<br/>
										
									</div>';
									

								}
							?>

							<?php
								echo '<h4 class="img_view_title">'.$imagedetails['title'].'</h4>';
								echo '<a href="#" class="img_view_views">'. $imagedetails['views'].' Views </a>';
							?>
				</div>
							 

	    		<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#about" role="tab" data-toggle="tab"> About </a></li>
				  	<li><a href="#share_code" role="tab" data-toggle="tab">Embed Code</a></li>
				</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<?php
							if (isset($success_mess))
								echo '<div class="has-success text-center"><br/>'.$success_mess.'<br/></div>';

							if (isset($customerror))
							{
								echo '<div class="has-error"><br/>'.$customerror.'<br/></div>';
							}

						?>

						
						<div class="tab-pane active" id="about">
							<div class="col-sm-7">
								<br/>
								<p><strong>Date Uploaded: </strong> <?php echo $imagedetails['date_uploaded'];?></p>
								<br/>
								<h4 class="comment_block_title">Comments: </h4>

								<?php
									foreach ($userreviews as $key => $value) {
										
										echo '
											<div class="row comment-box">
												<div class="avatar col-xs-2 text-center">
													<img class="img-thumbnail" src="'.base_url('assets/images/avatar.png').'"/>
												</div>
												<div class="col-xs-10">
													<div class="comment-author">
														<p class="author-name">'.$value['username'].' says </p>
														<p class="comment-time">'.$value['date_added'].'</p>
													</div>
													<div class="comment_des">
														<p>'.$value['description'].'
														</p>

													</div>';
											if ($delcomment)
												echo '<p> <a href="'.site_url("viewimage/deletecomment/".$value['reviewid']).'">Delete </a></p>';
										echo '
												</div>
											</div>

										';
									}

									if (sizeof($userreviews)==0)
										echo '<p><strong>No Comments</strong></p>';
								?>
								<div class="review_formset">
									<formset>
										<legend> Leave a Review </legend>
										<?php 
											$form_style = array('class'=>'form-horizontal', 'id'=>'comment_form');

											echo form_open('viewimage/addcomment',$form_style);
												
											if (isset($customerror))
											{
												echo '<p class="has-error">'.$customerror.'</p>';
											}

										?>
										<div class="form-group">
											<label for="username" class="control-label col-sm-3">Name </label>

											<div class="col-sm-9 ">
												<input type="text" value="<?php 
													if (isset($userdetails))
														echo $userdetails['first_name'];
													else 
														echo set_value('username'); ?>" name="username" class="form-control required" size="50" placeholder="Name" id="username"/>
												<span class="help-block"><?php echo form_error('firstname'); ?></span>
											</div>
										</div>

										<div class="form-group">
											<label for="email" class="control-label col-sm-3">Email </label>

											<div class="col-sm-9 ">
												<input type="text" name="email"  value="<?php 
													if (isset($userdetails))
														echo $userdetails['email'];
													else 
														echo set_value('email'); ?>" class="form-control required" placeholder="Enter valid Email" size="100" id="email"/>
												<span class="help-block"><?php echo form_error('email'); ?></span>
											</div>
										</div>

										<div class="form-group">
											<label for="description" class="control-label col-sm-3">Comment </label>

											<div class="col-sm-9 ">
												<textarea name="description"  value="<?php echo set_value('description'); ?>" class="form-control required" id="description"></textarea>
												<span class="help-block"><?php echo form_error('description'); ?></span>
											</div>
										</div>
										<input type="hidden" name="imageid" value="<?php echo $imagedetails['imageid'];?>"/>

										<div class="form-group">
											<div class="col-sm-12 text-center">
												<input type="submit" value="Submit" name="submit" class="btn btn-default"/>
											</div>
										</div>
									</form>
									</formset>
								</div>
							</div>

							<div class="col-sm-5">
								<div class="social_buttons">
									<h5> <strong> Share Image </strong></h5>

									<span class='st_facebook_large' displayText='Facebook'></span>
									<span class='st_twitter_large' displayText='Tweet'></span>
									<span class='st_googleplus_large' displayText='Google +'></span>
									<span class='st_linkedin_large' displayText='LinkedIn'></span>
									<span class='st_pinterest_large' displayText='Pinterest'></span>
									<span class='st_email_large' displayText='Email'></span>
								</div>

									

								<div class="other_album_images">
									<?php
					    			if ($delcomment)
					    			{
					    				$atts = array(
											              'width'      => '800',
											              'height'     => '600',
											              'scrollbars' => 'yes',
											              'status'     => 'yes',
											              'resizable'  => 'yes',
											              'screenx'    => '0',
											              'screeny'    => '0'
											            );
													
													
										echo '<h5><strong>You can <a href="#" data-toggle="modal" data-target="#myModal"> Move image to an Album </a> or '; echo anchor_popup('album/createalbum', 'Create an Album', $atts).'</strong></h5>';
					            	
					    			}
						    		?>


									<?php 
									if (isset($otheralbumimages))
									{
										echo '<h5> <strong> Other Images in this Album <a href="'.site_url("album/view/".$imagedetails['albumid']).'"> View Album </a></strong></h5>';
										foreach ($otheralbumimages as $value) {
											echo '<a href="'.site_url('viewimage/id/').'/'.$value['imageid'].'"><img class="img-thumbnail" src="'.base_url().'/'.$value['src'].'"></img></a>';
										}
									}
									?>
								</div>
							</div>

						</div>

						<div class="tab-pane" id="share_code">
	    					<div class="col-sm-8 col-sm-offset-2 image_code">
			    			<?php
			    			 	$form_style = array('class'=>'form-horizontal', 'id'=>'sharecode');
								echo form_open_multipart('upload/do_upload',$form_style);
							?>

							<div class="form-group">
					          <label for="viewimage" class="control-label col-sm-3"> View Image Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<?php echo site_url();?>/viewimage/id/<?php echo $imagedetails['imageid'];?>" id="viewimage">
					          </div>
					        </div>

					        <div class="form-group">
					          <label for="directimage" class="control-label col-sm-3"> Direct Image Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<?php echo base_url().''.$imagedetails['src'];?>" id="directimage">
					          </div>
					        </div>

					        <div class="form-group">
					          <label for="htmlembed" class="control-label col-sm-3"> HTML Embeded Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<a href='<?php echo site_url();?>/viewimage/id/<?php echo $imagedetails['imageid'];?>'><img src='<?php echo base_url().''.$imagedetails['src'];?>'></img></a>
					          " id="htmlembed"/></div>
					        </div>

					         <div class="form-group">
					          <label for="directimage" class="control-label col-sm-3"> Forum Share Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="[img]<?php echo base_url().''.$imagedetails['src'];?>[/img]" id="directimage">
					          </div>
				        </div>

				    	</form>
		    				</div>
		    			</div>
		   			</div>
		    </div>
	    </div>
    </div>
</div>

   
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
				      
				      	<form method="GET" action="<?php echo site_url('album/movetoalbum'); ?>">
				       	<select name="albumid" class="form-control">
				      			<option value="0" selected >Select an Album </option>
				       		<?php
				       			foreach ($useralbums as $value) {
				       				echo '<option value="'.$value['albumid'].'">'.$value['album_name'].'</option>';
				       			}
				       		?>
				       	</select>
				      
				      	<input type="hidden" name="imageid" value="<?php echo $imagedetails['imageid'];?>"/>
				       </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <input type="submit" value="Save Changes" class="btn btn-primary">
				      </div>
				  </form>
				    </div>
				  </div>
				</div>
