
<?php 
$da = date_default_timezone_set('Asia/Kolkata');
$date='Contact_queries-'.date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");

?>
    
<table cellpadding="1" cellspacing="1" border="1" class="display table table-bordered" id="hidden-table-info"  >
  <thead>
    <tr>
      <th class="center hidden-phone">Sr.No.</th>
      <th class="center hidden-phone">Name</th>
      <th class="center hidden-phone">Email</th>
      <th class="center hidden-phone">Phone no</th>
      <th class="center hidden-phone">Message</th>
     
    </tr>
  </thead>
  <tbody>
<?php 


 $data = DB::table('tbl_tl_contactuses')->select('tl_contactus_id','tl_contactus_name','tl_contactus_email','tl_contactus_phone','tl_contactus_company','tl_contactus_message','tl_contactus_created_at')->orderBy('tl_contactus_id','desc')->get();

 if(count($data)>0)
    {

     $q=0;
         foreach($data as $data_val)
            {
                    $q++;
			$id = $data_val->tl_contactus_id;
			$tl_contactus_name = $data_val->tl_contactus_name;
			$tl_contactus_email = $data_val->tl_contactus_email;
			$tl_contactus_phone = $data_val->tl_contactus_phone;
			$tl_contactus_company = $data_val->tl_contactus_company;
			$tl_contactus_message = $data_val->tl_contactus_message;
          
          ?>

        <tr>
                              <td><?php echo $q ?></td>
                              <td><?php echo $tl_contactus_name;?></td>                           
                              <td><?php echo $tl_contactus_email;?></td>
                              <td> <?php echo $tl_contactus_phone;?></td>
                              <td><?php echo $tl_contactus_company; ?></td>
                              <td><?php echo $tl_contactus_message; ?></td>
                             
                          </tr>
            <?php
            	 }          
              } 

            ?>        
  </tbody>
</table>
