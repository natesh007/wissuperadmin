<option disabled selected value hidden>Select Branch</option>
<?php foreach($branches as $branch){
    echo '<option value="' . $branch['BrID'] . '">' . $branch['BrName'] . '</option>' ;

} ?>