<div class="container">
	<div class="page_content">

		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> New Password </legend>
					
					
					<?php 
					$form_style = array('class'=>'form-horizontal', 'id'=>'login_form');

					echo form_open('user/change_reset_pass',$form_style);
						
					if (isset($customerror))
					{
						echo '<p class="has-error">'.$customerror.'';
					}

					?>

					<div class="form-group">
						<label for="password" class="control-label col-sm-3">Password </label>

						<div class="col-sm-9 ">
							<input type="password" name="password" class="form-control required" placeholder="Enter Password" size="50" id="password"/>
							<span class="help-block"><?php echo form_error('password'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="control-label col-sm-3">Password Confirmation</label>
						
						<div class="col-sm-9 ">
							<input type="password" name="password_conf" class="form-control required" placeholder="Enter Password Again" size="50" id="password_conf"/>
							<span class="help-block"><?php echo form_error('password_conf'); ?></span>
						</div>
					</div>

				
					
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input type="submit" value="Submit" class="btn btn-default"/>
						</div>
					</div>
				</formset>

			</div>
		</div>
	</div>
</div>