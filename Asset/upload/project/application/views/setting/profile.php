
  <div class="row">
  <div class="col-12">
  <div class="box">
  <div class="box-body">
  <p align="center" id="about_save_result"><?php echo $EditProfile_save_result; ?></p>
  <form action="<?php echo base_url();?>Setting/Saveprofile" method="post">

  <!-- name input -->
  <div class="form-group"><label><?php echo lang('name'); ?></label>
  <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" placeholder="<?php echo lang('name'); ?>" class="form-control">
  </div>

  <!-- shop input -->
  <?php if($_SESSION['type'] == "boss"){ ?>
  <div class="form-group"><label><?php echo lang('shop'); ?></label>
  <select name="shop" id="shopt" class="form-control">
  <?php
  $sid = $_SESSION['id'];
  foreach ($FetchedUser as $rows) {
  $id = $rows['id'];
  $username = $rows['Username'];
  echo"<option value='$id'";if($_SESSION['shop_id'] == $id){echo"selected";}echo">$username</option>";
  }
  ?>
  </select>
  </div>
  <?php } ?>

  <?php if($_SESSION['type'] == "boss"){ ?>
  <div class="form-group"><label><?php echo lang('main_currency'); ?></label>
  <select name="main_currency" id="main_currency" class="form-control">
  <option>Not selected</option>
  <option <?php if ($_SESSION['main_currency'] == 'USD') {echo 'selected';} ?>>USD</option>
  <option <?php if ($_SESSION['main_currency'] == 'LYD') {echo 'selected';} ?>>LYD</option>

  </select>
  </div>
  <?php } ?>
  <div class="form-group"><label><?php echo lang('home_transaction'); ?></label>
  <select name="home_transaction" id="home_transaction" class="form-control">
  <option value="1" <?php if ($_SESSION['home_transaction'] == '1') {echo 'selected';} ?>><?php echo lang('cash'); ?></option>
  <option value="2" <?php if ($_SESSION['home_transaction'] == '2') {echo 'selected';} ?>><?php echo lang('local'); ?></option>
  </select>
  </div>
<?php
$boss_id = $_SESSION['boss_id'];
$uisql = "SELECT * FROM settings WHERE user_id= '$boss_id' AND access='boss'";
$udata=$this->comman_model->get_all_data_by_query($uisql);
foreach($udata as $rowx){
  $value_n = $rowx['value'];
    $type_n = $rowx['type'];
    $_SESSION[$type_n] = $value_n;
}
 ?>
  <!-- help check -->
  <input name="titl" value="1"  type="checkbox" id="basicx-checkbox" class="mdc-checkbox__native-control" <?php if($_SESSION['title_h'] == "1"){echo "checked";} ?>/>
  <label class="fix-font" for="basicx-checkbox"><?php echo lang('help'); ?></label>

  <!-- hide treasury check -->
  <input name="hide_trsh" value="1" type="checkbox" id="basicx-checkbox1" class="mdc-checkbox__native-control" <?php if($_SESSION['hide_trsh'] == "1"){echo "checked";} ?>/>
  <label class="fix-font" for="basicx-checkbox1"><?php echo lang('hide_trsh'); ?></label>

  <div style="padding-top: 21px;">

  <!-- password input -->
  <div class="form-group"><label><?php echo lang('current_password'); ?></label>
  <input type="password"  name="EditProfile_current_pass" placeholder="<?php echo lang('current_password'); ?>" class="form-control">
  </div>

  <button name="EditProfile_save_changes" type="submit" class="btn btn-rounded btn-primary btn-outline">
  <?php echo lang('save_changes'); ?>
  </button>

  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
