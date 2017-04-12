<div class="container">
	<div class="page_content">

		<div class="row">
			<div class="col-md-offset-1 col-md-10 col-sm-12">

				<formset>
					<legend> Settings </legend>
					
					
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
						<div class="col-sm-10 col-sm-offset-1">

							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
							  <li class="active"><a href="#account" role="tab" data-toggle="tab"> Account </a></li>
							  <li><a href="#profile" role="tab" data-toggle="tab">Profile</a></li>
							  <li><a href="#password" role="tab" data-toggle="tab">Password</a></li>
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
							  <div class="tab-pane active" id="account">
									<?php 
										$form_style = array('class'=>'form-horizontal', 'id'=>'account_settings_form');

										echo form_open('settings',$form_style);
										
									?>
									<br/><br/>
							  		<div class="form-group">
										<label for="profileid" class="control-label col-sm-3">User Name</label>

										<div class="col-sm-9 ">
											<input type="text" value="<?php echo $userdetails['profileid']; ?>" name="profileid" class="form-control required" placeholder="User Name" size="15" id="profileid"/>
											<span class="help-block"><?php echo site_url('user/p/'.$userdetails['profileid']); ?></span>
											<span class="help-block"><?php echo form_error('profileid'); ?></span>
										</div>
									</div>

									<div class="form-group">
										<label for="email" class="control-label col-sm-3">Email </label>

										<div class="col-sm-9 ">
											<input type="text" name="email"  value="<?php echo $userdetails['email']; ?>" class="form-control required" placeholder="Enter valid Email" size="100" id="email"/>
											<span class="help-block"><?php echo form_error('email'); ?></span>
										</div>
									</div>

									<div class="form-group text-center">
										<input type="submit" class="btn btn-default" value="Save Changes"/>
									</form>
									</div>
							  </div>


							  <div class="tab-pane" id="profile">
							  	<?php 
										$form_style = array('class'=>'form-horizontal', 'id'=>'profile_settings_form');

										echo form_open('settings/profile',$form_style);
										
									?>
									<br/><br/>
							  		<div class="form-group">
										<label for="firstname" class="control-label col-sm-3">First Name </label>

										<div class="col-sm-9 ">
											<input type="text" value="<?php echo $userdetails['first_name']; ?>" name="firstname" class="form-control required" size="50" placeholder="First Name" id="firstname"/>
											<span class="help-block"><?php echo form_error('firstname'); ?></span>
										</div>
									</div>

									<div class="form-group">
										<label for="lastname" class="control-label col-sm-3">Last Name </label>

										<div class="col-sm-9 ">
											<input type="text" value="<?php echo $userdetails['last_name']; ?>" name="lastname" class="form-control" size="50" placeholder="Last Name" id="lastname"/>
											<span class="help-block"><?php echo form_error('lastname'); ?></span>
										</div>
									</div>

									<div class="form-group">
										<label for="gender" class="control-label col-sm-3">Gender </label>

										<div class="col-sm-9 ">
											<label class="checkbox-inline">
												<input type="radio" name="gender" id="gender" value='M' <?php
													if ($userdetails['gender'] == 'M')
														echo "checked='checked'";
													?> > Male </input>
											</label>
											<label class="checkbox-inline">
												<input type="radio" name="gender" id="gender" value='F' <?php
													if ($userdetails['gender'] == 'F')
														echo "checked='checked'";
													?> > Female </input> 
											</label>
										</div>
									</div>

									<div class="form-group text-center">
										<input type="submit" class="btn btn-default" value="Save Changes"/>
									</form>
									</div>
							  </div>




							  <div class="tab-pane" id="password">
							  	<?php 
										$form_style = array('class'=>'form-horizontal', 'id'=>'password_settings_form');

										echo form_open('settings/password',$form_style);
										
									?>
									<br/><br/>
									<div class="form-group">
										<label for="current_password" class="control-label col-sm-3">Current Password </label>

										<div class="col-sm-9 ">
											<input type="password" name="current_password" class="form-control required" placeholder="Enter Current Password" size="50" id="current_password"/>
											<span class="help-block"><?php echo form_error('current_password'); ?></span>
										</div>
									</div>
									<br/><br/>

							  		<div class="form-group">
										<label for="password" class="control-label col-sm-3">New Password </label>

										<div class="col-sm-9 ">
											<input type="password" name="password" class="form-control required" placeholder="Enter New Password" size="50" id="password"/>
											<span class="help-block"><?php echo form_error('password'); ?></span>
										</div>
									</div>

									<div class="form-group">
										<label for="password" class="control-label col-sm-3">Confirm New Password</label>
										
										<div class="col-sm-9 ">
											<input type="password" name="password_conf" class="form-control required" placeholder="Enter Password Again" size="50" id="password_conf"/>
											<span class="help-block"><?php echo form_error('password_conf'); ?></span>
										</div>
									</div>
									<div class="form-group text-center">
										<input type="submit" class="btn btn-default" value="Save Changes"/>
									</form>
									</div>
							  </div>
							  
							</div>
						</div>
					</div>

					
				</formset>

			</div>
		</div>
	</div>
</div>

<script>

$(window).load(function()
{ 
	setTimeout(function(){ $('.has-success').fadeOut(1000) }, 5000);
})

</script>