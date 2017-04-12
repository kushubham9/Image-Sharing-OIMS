<div class="container">
  
  	<div class="page_content">

		<div class="row">
		    <div class="col-md-offset-1 col-md-10 col-sm-12">
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
		    	
	            <div class="upload_result">
	            	<?php
	            		if ($this->session->userdata('userid'))
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
									
									
									echo '<h4 class="text-center">Content added to <a href="'.site_url("user").'">'.$this->session->userdata('profileid').'\'s</a> images. You can also <a href="#" data-toggle="modal" data-target="#myModal"> Move to Album</a> or '; echo anchor_popup('album/createalbum', 'Create an Album', $atts).'</h4>';
	            		}
	            		else
	            			echo '<h4 class="text-center"><a href="'.site_url('user/registration').'"> Register here </a> to manage your images easily. </h4>';
	            	?>
	            	<br/>
			    	<div class="row image_code">

			    		
			    		<div class="col-sm-3">
			    			<a href="<?php echo site_url();?>/viewimage/id/<?php echo $imagedetails['imageid'];?>"><img title="<?php echo $imagedetails['title'];?>" class="img-thumbnail" src="<?php echo base_url().''.$imagedetails['thumb_img'];?>" /></a>
			    		</div>

			    		<div class="col-sm-9 share_code">
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
				        <input type="submit" value="Save Changes" class="btn btn-primary">Save changes</button>
				      </div>
				  </form>
				    </div>
				  </div>
				</div>

		    </div>
		</div>

	</div>
</div>

