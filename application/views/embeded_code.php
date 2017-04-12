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
	            	<br/>

	            	<?php foreach ($imagedetails as $value): ?>

			    	<div class="row image_code">
						<div class="col-sm-3">
			    			<a href="<?php echo site_url();?>/viewimage/id/<?php echo $value['imageid'];?>"><img title="<?php echo $value['title'];?>" class="img-thumbnail" src="<?php echo base_url().''.$value['thumb_src'];?>" /></a>
			    		</div>
			    		<form class="form-horizontal">
			    		<div class="col-sm-9 share_code">
			    			

							<div class="form-group">
					          <label for="viewimage" class="control-label col-sm-3"> View Image Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<?php echo site_url();?>/viewimage/id/<?php echo $value['imageid'];?>" id="viewimage">
					          </div>
					        </div>

					        <div class="form-group">
					          <label for="directimage" class="control-label col-sm-3"> Direct Image Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<?php echo base_url().''.$value['src'];?>" id="directimage">
					          </div>
					        </div>

					        <div class="form-group">
					          <label for="htmlembed" class="control-label col-sm-3"> HTML Embeded Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="<a href='<?php echo site_url();?>/viewimage/id/<?php echo $value['imageid'];?>'><img src='<?php echo base_url().''.$value['src'];?>'></img></a>
					          " id="htmlembed"/></div>
					        </div>

					         <div class="form-group">
					          <label for="directimage" class="control-label col-sm-3"> Forum Share Link </label>

					          <div class="col-sm-9">
					            <input type="text" class="form-control" value="[img]<?php echo base_url().''.$value['src'];?>[/img]" id="directimage">
					          </div>
					        </div>

			    		</div>
			    	</div>
			    		</form>

			    	<br/>
			    	<hr/>
			    	<br/>
			    <?php endforeach; ?>
			    </div>


		    </div>
		</div>

	</div>
</div>

