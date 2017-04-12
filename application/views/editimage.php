<div class="container">
	
	<div class="page_content">
		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> Edit Image Details </legend>
						
					<?php
						if (!$this->session->flashdata('success_mess'))
							goto skipsuccess;
					?>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 text-center">
							<div class="alert alert-success">
							    <a href="#" class="close" data-dismiss="alert">&times;</a>
							    <strong>Success!</strong> <?php echo $this->session->flashdata('success_mess');?>
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
							<div class="alert alert-error">
							    <a href="#" class="close" data-dismiss="alert">&times;</a>
							    <strong>Success!</strong> <?php echo $this->session->flashdata('failure_mess');?>
							</div>
						</div>
					</div>

					<?php
						skipfailure:
					?>

					<div class="row">
						<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
							<img title="<?php echo $imagedetails['title'];?>" class="img-thumbnail" src="<?php echo base_url().''.$imagedetails['src'];?>" />
							<br/><br/>
						</div>
					</div>

					<div class="row">

						<?php 
							$form_style = array('class'=>'form-horizontal', 'id'=>'edit_image_form');
							echo form_open('viewimage/editimage_doedit',$form_style);
							
							if (isset($customerror))
								echo '<p class="has-error">'.$customerror.'</p>';
						?>

						<div class="form-group">
							<label for="category" class="control-label col-sm-3">Category </label>

							<div class="col-sm-9 ">
								<select name="categoryid" class="form-control" id="category">
									<option value="" selected>Select Category</option> 

									<?php 
										foreach ($categories as $value) {
											echo '<option ';
												if ($imagedetails['categoryid']==$value['categoryid'])
													echo ' selected ';
											echo 'value="'.$value['categoryid'].'">'.$value['categoryname'].'</option>';
										}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="album" class="control-label col-sm-3">Album </label>

							<div class="col-sm-9 ">
								<select name="albumid" class="form-control" id="album">
									<option value="" selected>Select Album</option> 
									<?php 
										foreach ($useralbum as $value) {
											echo '<option ';
												if ($imagedetails['albumid']==$value['albumid'])
													echo ' selected ';
											echo 'value="'.$value['albumid'].'">'.$value['album_name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="title" class="control-label col-sm-3">Title / Description </label>

							<div class="col-sm-9 ">
								<textarea name="title" class="form-control required" id="title"/><?php echo $imagedetails['title']; ?></textarea>
								
							</div>
						</div>
						<input type="hidden" value="<?php echo $imagedetails['imageid'];?>" name="imageid"/>
						<div class="form-group">
						<div class="col-sm-12 text-center">
							<input type="submit" value="Save" class="btn btn-primary"/>
						</div>
					</div>
					</div>
				</form>
				</formset>
			</div>
		</div>
	</div>
	
</div>




				