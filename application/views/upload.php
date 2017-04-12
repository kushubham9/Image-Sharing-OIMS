<div id="upload_bg">
  <div class="container">
  
    <div class="row">
      <div class="col-md-offset-2 col-md-8 col-sm-12">

        <div class="upload_area_content">
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
          <h1 class="text-center">Upload and share your images.</h1>
        
          <fieldset>


            <?php
                $form_style = array('class'=>'form-horizontal', 'id'=>'imgupload_form');

                 echo form_open_multipart('upload/do_upload',$form_style);
                  
                if (isset($customerror))
                {
                  echo '<p class="has-error">'.$customerror.'</p>';
                }

                if (isset($error))
                  var_dump($error);

            ?>

            <div class="form-group">
              <label class="control-label col-sm-3"> Image Source </label>

              <div class="col-sm-9">
                <input type="file" class="form-control" placeholder="Specify image location" onchange="fileSelectHandler()" name="file" id="imagefield"/>
                <span class="help-block"><p class="has-error text-danger"></p></span>
              </div>
            </div>

            <div class="customize_items" style="display:none">
              <div class="form-group">
                <label for="title" class="control-label col-sm-3"> Title </label>

                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Image Title" name="title" id="title">
                </div>
              </div>

              <div class="form-group">
                <label for="category" class="control-label col-sm-3"> Category </label>

                <div class="col-sm-9">
                  <select class="form-control" name="categoryid">
                    <option value=""> Select Category </option>
                    <?php 
                    $categories = $this->session->userdata('globalcategory');

                      foreach ($categories as $key => $value) {
                        echo '<option value="'.$value['categoryid'].'">'.$value['categoryname'].'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>


              <div class="form-group">
                <label for="optsize" class="control-label col-sm-3"> Resize Image </label>

                <div class="col-sm-9">
                  <select name="imagesize" class="form-control" id="optsize">
                    <option value="0">Do not resize my image</option>
                    <option value="100*75">100 x 75 (avatar)</option>
                    <option value="150*112">150 x 112 (thumbnail)</option>
                    <option value="320*240">320 x 240 (for websites and email)</option>
                    <option value="640*480">640 x 480 (for message boards)</option>
                    <option value="800*600">800 x 600 (15-inch monitor)</option>
                    <option value="1024*768">1024 x 768 (17-inch monitor)</option>
                    <option value="1280*1024">1280 x 1024 (19-inch monitor)</option>
                    <option value="1600*1200">1600 x 1200 (21-inch monitor)</option>
                    <option value="9">Custom Size </option>
                  </select>
                </div>
              </div>
              <div class="form-group img_dimension" style="display:none;">
              <label for="dimension" class="control-label col-sm-3"> Image Dimension</label>

              <div class="col-sm-9">
                <input type="text" class="input-sm" placeholder="Width" name="width" id="img_width">
                <input type="text" class="input-sm" placeholder="Height" name="height" id="img_height">
              </div>
            </div>
            </div>

            
        
            <div class="form-group">
              <div class="text-center">
                <button type="button" class="btn btn_red btn-lg customize_btn">Customize</button>
                <input type="submit" class="btn btn_red btn-lg" value="Upload" name="submit"/>
              </div>
            </div>

          </form>
          </fieldset>
        </div>
      </div>
    </div>


  </div>
</div>

<?php 
  if ($this->session->userdata('userid'))
    goto skip_register;

?>
<div>
  <div class="container">
    <div class="row">

      <div id="home-join" class="text-center">
        <h1>Sign up to unlock all the features</h1>
        <p>Manage your content, create private albums, customize your profile and more.</p>
        <div class="home-button">
         <a href="<?php echo site_url('user/registration');?>" class="btn_custom"> Register Now </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  skip_register:
  ?>


<script>
  $('.customize_btn').click(function()
  {
    $('.customize_items').slideToggle('slow');
  })

  $('select#optsize').change(function()
  {
    var relvalue = $('select#optsize option:selected').attr('value');
    if (relvalue=='9')
    {
      $('div.img_dimension').fadeIn();
    }

    else
    {
      $('div.img_dimension').fadeOut();
    } 
  })
</script>


<script>
    // hide all errors
    $('.text-danger').hide();

function fileSelectHandler() {

    // get selected file
    var oFile = $('#imagefield')[0].files[0];
    $('.text-danger').hide();
// check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/bmp|image\/jpg)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.text-danger').html('Please select a valid image file (jpg, jpeg, bmp, png are allowed)').show();
        return false;
    }

    // check for file size
    if (oFile.size > 5 * 1024 * 1024) {
        $('.text-danger').html('You have selected too big file, please select a one smaller image file').show();
        return false;
    }
    return true;
  }

  $('#imgupload_form').submit(function()
  {
    if ($('input:file').val()=='')
    {
      alert ('Please select an image');
      return false;
    }

    var relvalue = $('select#optsize option:selected').attr('value');
    if (relvalue=='9')
    {
      if ($('#img_width').val()=='' || $('#img_height').val()=='')
        {
          alert('Please specify Image width & height');
          return false;
        }
    }

    return true;
      
  })

</script>