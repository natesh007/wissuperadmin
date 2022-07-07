<option disabled selected value>Select Multiple Branches</option>
<?php foreach($branches as $branch){
    echo '<option value="' . $branch['BrID'] . '">' . $branch['BrName'] . '</option>' ;

} ?>