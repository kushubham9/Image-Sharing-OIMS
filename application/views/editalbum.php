<div class="container">
	<div class="page_content">

		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> Edit Album Details </legend>
						
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

						<?php 
							$form_style = array('class'=>'form-horizontal', 'id'=>'edit_album_form');
							echo form_open('album/editalbum/'.$albumdetails['albumid'],$form_style);
							
							if (isset($customerror))
								echo '<p class="has-error">'.$customerror.'</p>';
						?>

						<div class="form-group">
							<label for="albumname" class="control-label col-sm-3">Album Name </label>

							<div class="col-sm-9 ">
								<input type="text" name="albumname"  value="<?php echo $albumdetails['album_name']; ?>" class="form-control required" placeholder="Unique Album Name" size="100" id="albumname"/>
								<span class="help-block"><?php echo form_error('albumname'); ?></span>
							</div>
						</div>

						<div class="form-group">
							<label for="description" class="control-label col-sm-3">Album Description </label>

							<div class="col-sm-9 ">
								<textarea name="description" class="form-control required" id="description"/><?php echo $albumdetails['description']; ?></textarea>
								<span class="help-block">Optional</span>
							</div>
						</div>

						<div class="form-group">
							<label for="privacy" class="control-label col-sm-3">Album Privacy </label>

							<div class="col-sm-9 ">
								<select class="form-control" name="privacy">
									<option <?php if ($albumdetails['private']==0) echo 'selected '; ?>value="0"> Public </option>
									<option <?php if ($albumdetails['private']==1) echo 'selected '; ?> value="1"> Private </option>
								</select>
							</div>
						</div>

						<input type="hidden" value="<?php echo $albumdetails['albumid'];?>" name="albumid"/>
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




				