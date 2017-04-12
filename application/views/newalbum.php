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
		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> Make an Album </legend>
					
					
					<?php 
					$form_style = array('class'=>'form-horizontal', 'id'=>'album_form');

					echo form_open('album/createalbum',$form_style);
						
					if (isset($customerror))
					{
						echo '<p class="has-error">'.$customerror.'</p>';
					}

					?>

					<p> Create a new album, and associate images to the album. </p>

					<div class="form-group">
						<label for="albumname" class="control-label col-sm-3">Album Name </label>

						<div class="col-sm-9 ">
							<input type="text" name="albumname"  value="<?php echo set_value('albumname'); ?>" class="form-control required" placeholder="Unique Album Name" size="100" id="albumname"/>
							<span class="help-block"><?php echo form_error('albumname'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="description" class="control-label col-sm-3">Album Description </label>

						<div class="col-sm-9 ">
							<textarea name="description" class="form-control required" id="description"/></textarea>
							<span class="help-block">Optional</span>
						</div>
					</div>

					<div class="form-group">
						<label for="privacy" class="control-label col-sm-3">Album Privacy </label>

						<div class="col-sm-9 ">
							<select class="form-control" name="privacy">
								<option value="0"> Public </option>
								<option value="1"> Private </option>
							</select>
						</div>
					</div>

				
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input type="submit" value="Create Album" class="btn btn-default"/>
						</div>
					</div>
				</formset>

			</div>
		</div>
	</div>
</div>
