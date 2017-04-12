<div class="container">
	<div class="page_content">
		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> User Registration </legend>
					
					
					<?php 
					$form_style = array('class'=>'form-horizontal', 'id'=>'register_form');


					echo form_open('user/registration',$form_style);
					?>

						<!-- <?php echo validation_errors(); ?> -->
					
					<div class="form-group">
						<label for="firstname" class="control-label col-sm-3">First Name </label>

						<div class="col-sm-9 ">
							<input type="text" value="<?php echo set_value('firstname'); ?>" name="firstname" class="form-control required" size="50" placeholder="First Name" id="firstname"/>
							<span class="help-block"><?php echo form_error('firstname'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="lastname" class="control-label col-sm-3">Last Name </label>

						<div class="col-sm-9 ">
							<input type="text" value="<?php echo set_value('lastname'); ?>" name="lastname" class="form-control" size="50" placeholder="Last Name" id="lastname"/>
							<span class="help-block"><?php echo form_error('lastname'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="gender" class="control-label col-sm-3">Gender </label>

						<div class="col-sm-9 ">
							<label class="checkbox-inline">
								<input type="radio" name="gender" id="gender" value='M' checked='checked'> Male </input>
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="gender" id="gender" value='F'> Female </input> 
							</label>
						</div>
					</div>



					
				</formset>

				<formset>
					<legend> Login Information </legend>

					<div class="form-group">
						<label for="profileid" class="control-label col-sm-3">User Name</label>

						<div class="col-sm-9 ">
							<input type="text" value="<?php echo set_value('profileid'); ?>" name="profileid" class="form-control required" placeholder="User Name" size="15" id="profileid"/>
							<span class="help-block"><?php echo form_error('profileid'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="control-label col-sm-3">Email </label>

						<div class="col-sm-9 ">
							<input type="text" name="email"  value="<?php echo set_value('email'); ?>" class="form-control required" placeholder="Enter valid Email" size="100" id="email"/>
							<span class="help-block"><?php echo form_error('email'); ?></span>
						</div>
					</div>

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
							<input type="submit" value="Register Me!" class="btn btn-default"/>
						</div>
					</div>
				</formset>

			</div>
		</div>
	</div>
</div>