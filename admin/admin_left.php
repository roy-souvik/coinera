    <!--<div class="left_menu">
    
        <p><a href="admin_main.php">Home</a>
        <p><a href="admin_changepwd.php">Change Password</a></p>
        <p><a href="admin_mailid.php">Change E-mail Id</a></p>
        <p><a href="javascript:logout();">Logout</a></p>-->
        <!--<p><a href="admin_banner.php">Manage Banner</a></p>-->
        <!--<p><a href="admin_project.php">Manage Projects</a></p>
        <p><a href="admin_event.php">Manage Events</a></p>
        <p><a href="admin_gallery.php">Gallery</a></p>
    
    </div>-->
    
    <link rel="StyleSheet" href="css/tree.css" type="text/css">
<script type="text/javascript" src="js/tree.js"></script>
<script type="text/javascript">
    var Tree = new Array;
    // nodeId | parentNodeId | nodeName | nodeUrl
    Tree[0] = "1|0| Home |admin_main.php";
	Tree[1] = "2|0| Admin User |#";
    Tree[2] = "3|2| Change Password| admin_changepwd.php";
	Tree[3] = "4|2| Change Email Id| admin_mailid.php";
	Tree[4] = "5|2| Logout|javascript:logout(); ";
    Tree[5] = "6|0| Products |#";
	Tree[6] = "7|6| Manage Categories |admin_category.php";
	Tree[7] = "8|6| Manage Products |admin_products.php";
	Tree[8] = "9|6| Product Confirmation |admin_product_confirmation.php";
	Tree[9] = "10|0| Users |#";
	Tree[10] = "11|10| Manage User Profile |admin_profile.php";
	Tree[11] = "12|0| Web Views |admin_page_views.php";
	
	
	
	
</script>
 
<div class="tree">
	<script type="text/javascript">
        createTree(Tree);
    </script>
</div>