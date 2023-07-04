<?php
function project_settings($name){
  ob_start();
// if 1==1 then do the function.
$toggle = "false";
if($name == "signup" && $toggle=="true"){
  echo "signup";
}
if($name == "index" && $toggle=="true"){
header("location: ".base_url()."Account/login");
}
if($name == "captcha" && $toggle=="false"){
echo "captcha";
}
if($name == "delete_account" && $toggle=="true"){
echo "delete_account";
}
if($name == "delete_database" && $toggle=="false"){
echo "delete_database";
}
if($name == "devolpment" && $toggle=="true"){
echo "devolpment";
}

  return ob_get_clean();
}
?>
<?php
function delete_ac($id,$type){
  ob_start();
  session_start();

  $CI = get_instance();

  // You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Comman_model');

if($type == "delete_account"){
	$remeveAccount_sql = "DELETE FROM signup WHERE id= $id";
	$IDeleted=$CI->Comman_model->run_query($remeveAccount_sql);
}


	$remeveAccount_sql = "DELETE FROM settings WHERE id= $id";
	$IsRun=$CI->Comman_model->run_query($remeveAccount_sql);

  $remeveAccount_sql = "DELETE FROM transaction WHERE user_id= $id";
	$IsRun=$CI->Comman_model->run_query($remeveAccount_sql);

  return ob_get_clean();
}
?>
<?php
function file_upload($path,$name,$accept,$size){
	$image = addslashes(file_get_contents($_FILES[$name]['tmp_name']));
	$image_name = addslashes($_FILES[$name]['name']);
	$image_size = getimagesize($_FILES[$name]['tmp_name']);

	$post_fileName = $_FILES[$name]["name"];
	$post_fileTmpLoc = $_FILES[$name]["tmp_name"];
	$post_fileType = $_FILES[$name]["type"];
	$post_fileSize = $_FILES[$name]["size"];
	$post_fileErrorMsg = $_FILES[$name]["error"];
	$post_fileName = preg_replace('#[^a-z.0-9]#i', '', $post_fileName);
	$post_kaboom = explode(".", $post_fileName);
	$post_fileExt = end($post_kaboom);
	$post_fileName = "logo.ico";

	if (!$post_fileTmpLoc) {
		$location = '<p class="error_msg">'.lang('errorPost_n2').'</p>';
	}else{
		//================[ if image size more than 8Mb ]================
		if($size != NULL && $post_fileSize > $size) {
			$location = '<p class="error_msg">'.lang('errorPost_n3').'</p>';
			unlink($post_fileTmpLoc);
		} else {
			//================[ if image format not supported ]================
			if ($accept != NULL && !preg_match("/.($accept)$/i", $post_fileName) ) {
				$location = '<p class="error_msg">'.lang('errorPost_n4').'</p>';
				unlink($post_fileTmpLoc);
			} else {
				//================[ if an error was found ]================
				if ($post_fileErrorMsg == 1) {
					$location = '<p class="error_msg">'.lang('errorPost_n5').'</p>';
				}else{

					move_uploaded_file($_FILES[$name]["tmp_name"], "$path/" .$post_fileName);
					$location = "$path" .$post_fileName;
				}}}}
	return $location;
}
?>
<?php
function browsing($table_name,$column,$id){
  ob_start();
  session_start();

  $CI = get_instance();

  // You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Comman_model');

  if($id != NULL){
  $id = "user_id = '".$_SESSION['id']."'";
  }
  echo "<datalist id='br_$column'>";

  $browsing = "SELECT DISTINCT $column FROM $table_name WHERE 1 $id";
	$FetchData=$CI->Comman_model->get_all_data_by_query($browsing);
	foreach ($FetchData as $postsfetch ) {
	$value = $postsfetch[$column];
  echo "<option value='$value'>";
	}
echo "</datalist>";
  return ob_get_clean();
}
?>
<?php
function count_table($table_name,$column,$value,$id){
  ob_start();
  session_start();

  $CI = get_instance();

  // You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Comman_model');

  $CI->load->helper(
    array('numkmcount')
);

  if($id != NULL){
  $where = " AND user_id = '$id'";
  }
  if($value != NULL){
  $where_to = "AND column = '$value'";
  }
  $emExist = "SELECT $column FROM $table_name WHERE 1 $where";
  $FetchData=$CI->Comman_model->get_all_data_by_query($emExist);
  foreach ($FetchData as $postsfetch) {
  $value = $postsfetch['account_type'];
  ${"count_" . $value} =+ 1;
  }
  $emExist = "SELECT DISTINCT $column FROM $table_name WHERE 1 $where $where_to";
  $FetchData=$CI->Comman_model->get_all_data_by_query($emExist);
  foreach ($FetchData as $postsfetch) {
  $value = $postsfetch['account_type']; ?>
  <div class="col-xl-3 col-md-6 col-12 ">
      <div id="container_<?php echo $value; ?>" class="box box-inverse">
        <div class="box-body">
          <div class="flexbox">
            <h5><?php echo $value; ?></h5>
            <div class="dropdown">
              <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ion-android-more-vertical rotate-90"></i></span>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#"><i class="ion-android-refresh"></i> Refresh</a>
              </div>
            </div>
          </div>

          <div class="text-center my-2">
            <div class="font-size-60"><?php if(${"count_" . $value} == "" ){echo "0";}else{echo thousandsCurrencyFormat(${"count_" . $value});} ?></div>
            <span><?php echo $value; ?></span>
          </div>
        </div>
      </div>
  </div>
  <script>
          function setup_<?php echo $value; ?>(){

              var container = document.getElementById("container_<?php echo $value; ?>");

              for (var i = 0; i < 1; i++) {
                  var colors = random_bg_color();
                  container.style.backgroundColor = colors;

              }
          }
  setup_<?php echo $value; ?>()
  </script>
  <?php } ?>
<?php
  return ob_get_clean();
}
?>
<?php
function settings($type,$access,$value){
  ob_start();
  session_start();

  $CI = get_instance();

  // You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Comman_model');

  $shop_id = $_SESSION['shop_id'];
  $boss_id = $_SESSION['boss_id'];
  $sid = $_SESSION['id'];
  if($access == "boss"){
  $access_id = $boss_id;
  }elseif($access == "shop"){
    $access_id = $shop_id;
  }else{
    $access_id = $sid;
  }
  $uisql = "SELECT * FROM settings WHERE user_id= '$sid' AND type='$type'";
  $udata=$CI->Comman_model->get_all_data_by_query($uisql);
  $count_set = count($udata);
  if($count_set > 0){
  $data = array(
  'value'   => $value,
  );
  $where=array('user_id' => $access_id, 'type' => $type);
  $update_info=$CI->Comman_model->update_entry("settings",$data,$where);
  }else{
  $iptdbsqli = "INSERT INTO settings
  (user_id,type,value,access)
  VALUES
  ( $access_id, $type, $value, $access)
  ";
  $insert_post_toDBi = $CI->Comman_model->run_query($iptdbsqli);
  }
  $_SESSION[$type] = $value;

  return ob_get_clean();
}
?>
<?php
function table_view($table_name,$column,$filter){
  ob_start();
  session_start();

  $CI = get_instance();

  // You may need to load the model if it hasn't been pre-loaded
  $CI->load->model('Comman_model');
?>
  <div class="table-responsive">
  <table id="reports_1" class="table table-lg invoice-archive reports_1">
  <thead>
  <tr>
    <th><?php echo lang('customer'); ?></th>
    <th><?php echo lang('Username'); ?></th>
<?php
if($column != NULL){
  foreach($column as $column_name => $value){?>
    <th><?php echo lang($value); ?></th>
  <?php }
}else{
  $fields = $CI->db->field_data($table_name);
  foreach ($fields as $postsfetchi)
  {
    if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
  echo "<th>".lang($postsfetchi->name)."</th>";
}
  }
}
 ?>
  <th><span class="fa fa-cog"></span></th>
  </tr>
  </thead>
  <tbody>
  <?php

  $vpsql = "SELECT * FROM $table_name WHERE 1 $filter ORDER BY id DESC";
  $result=$CI->Comman_model->get_all_data_by_query($vpsql);
  foreach ($result as $postsfetch)
  {
    $post_id = $postsfetch['id'];
    $user_id = $postsfetch['user_id'];
    if($column != NULL){
      foreach($column as $column_name => $value){
        ${"var".$value} = $postsfetch[$column_name];
       }
    }else{
      $fields = $CI->db->field_data($table_name);
      foreach ($fields as $postsfetchi)
      {
        if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
      ${"var".$postsfetchi->name} = $postsfetch[$postsfetchi->name];
    }
      }
}
    $vpsql = "SELECT * FROM signup WHERE id='$user_id'";
    $result=$CI->Comman_model->get_all_data_by_query($vpsql);
    foreach ($result as $postsfetchi)
    {
      $username = $postsfetchi['Username'];
}
  $acc_colum += 1;
  echo"<tr id='tr_$post_id'>
  <td> $acc_colum</td>
  <td> $username</td>
";
  if($column != NULL){
    foreach($column as $column_name => $value){
      echo "<td>".${"var".$value}."</td>";
     }
  }else{
    $fields = $CI->db->field_data($table_name);
    foreach ($fields as $postsfetchi)
    {
  if($postsfetchi->name == "user_id" || $postsfetchi->name == "id"){}else{
    echo "<td>".${"var".$postsfetchi->name}."</td>";
  }
    }
}
  echo"
  <td class='text-center'>
  <div class='list-icons d-inline-flex'>
  <div class='list-icons-item dropdown'>
  <a href='#' class='list-icons-item dropdown-toggle' data-toggle='dropdown'><i class='fa fa-file-text'></i></a>
  <div class='dropdown-menu dropdown-menu-right'>
  <a href='#' onclick=\"print_co('$post_id')\" class='dropdown-item'><i class='fa fa-print'></i> ".lang('print')."</a>
  <div class='dropdown-divider'></div>
  <a href='#' onclick=\"delete_transaction('$table_name','$post_id')\" style='color:#d71717' class='dropdown-item'><i class='fa fa-remove'></i> ".lang('delete')."</a>
  </div>
  </div>
  </div>
  </td>
  </tr>";
  }
  ?></tbody>
  </table>

  </div>

<?php
  return ob_get_clean();
}
?>
