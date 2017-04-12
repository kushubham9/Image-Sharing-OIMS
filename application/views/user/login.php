<div class="container">
	<div class="page_content">
		<div class="row">
			<div class="col-md-offset-2 col-md-8 col-sm-12">
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
				<formset>
					<legend> User Login </legend>
					
					
					<?php 
					$form_style = array('class'=>'form-horizontal', 'id'=>'login_form');

					echo form_open('user/login',$form_style);
						
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
						<label for="password" class="control-label col-sm-3">Password </label>

						<div class="col-sm-9 ">
							<input type="password" name="password" class="form-control required" placeholder="Enter Password" size="50" id="password"/>
							<span class="help-block"><?php echo form_error('password'); ?></span>
						</div>
					</div>

				
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<input type="submit" value="Login" class="btn btn-default"/>
						</div>
					</div>
				</formset>

			</div>
		</div>
	</div>
</div>