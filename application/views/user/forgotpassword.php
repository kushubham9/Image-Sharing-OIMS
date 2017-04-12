<div class="container">
	<div class="page_content">
		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">

				<formset>
					<legend> Forgot Password Wizard</legend>
					
					
					<?php 
					$form_style = array('class'=>'form-horizontal', 'id'=>'login_form');

					echo form_open('user/forgotpassword',$form_style);
						
					if (isset($customerror))
					{
						echo '<p class="has-error">'.$customerror.'</p>';
					}

					?>


					
					<div class="form-group">
						<label for="email" class="control-label col-sm-3">Email </label>

						<div class="col-sm-9 ">
							<input type="text" name="email"  value="<?php echo set_value('email'); ?>" class="form-control required" placeholder="Enter valid Email" size="100" id="email"/>
							<span class="help-block"><?php echo form_error('email'); ?></span>
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