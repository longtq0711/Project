<select class="country_select" name="district">
<option value="">District</option>

<?php
    include "connection.php";
    $sql = "SELECT * FROM district WHERE _province_id =". $_POST['provinceid'];
    $query = $connection->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($result AS $key){
        echo '<option value="'.$key['_province_id'].'">'.$key['_name'].'</option>';
    }
?>
</select>
