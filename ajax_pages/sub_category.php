<?php
include("../includes/config.php");
include("../includes/dbcon.php");






?>

<table>
<tr>
    <td style="padding-right:11px;">Sub Category</td>
    <td>:</td>
    <td>
    	<select name="sub_category">
            <option value="">--Select Subcategory--</option>
            <?php
            $sql=mysql_query("select * from category_info where p_id=".$_GET['id']." and status='Y'");
            while($sql_rec=mysql_fetch_array($sql)){ ?>
            <option value="<?=$sql_rec['id']?>"><?=$sql_rec['name']?></option>
            <?php    
            }
            ?>
        </select>
    </td>
</tr>
</table>