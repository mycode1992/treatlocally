        
<?php 
$da = date_default_timezone_set('Asia/Kolkata');
$date='newsletter_signup-'.date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");

?>
    
<table cellpadding="1" cellspacing="1" border="1" class="display table table-bordered" id="hidden-table-info"  >
  <thead>
    <tr>
      <th class="center hidden-phone">Sr.No.</th>
      <th class="center hidden-phone">Email</th>
      <th class="center hidden-phone">Date</th>
    </tr>
  </thead>
  <tbody>
<?php 


  $data = DB::table('tbl_tl_subscribe')->select('tl_subscribe_id','tl_subscribe_email','tl_subscribe_date')->orderBy('tl_subscribe_id', 'desc')->get();

 if(count($data)>0)
    {

     $q=0;
         foreach($data as $data_val)
            {
                    $q++;
			$id = $data_val->tl_subscribe_id;
			$tl_subscribe_email = $data_val->tl_subscribe_email;
			$tl_subscribe_date = $data_val->tl_subscribe_date;
          
          ?>

        <tr>
                              <td><?php echo $q ?></td>
                              <td><?php echo $tl_subscribe_email;?></td>                           
                              <td><?php echo $tl_subscribe_date;?></td>
                          </tr>
            <?php
            	 }          
              } 

            ?>        
  </tbody>
</table>
