<br>
<?php 

$proSelectedRefListArray = array();
$selectProSelectedRef = mysqli_query($localhost, "SELECT `reference_id` FROM `ref_pro_one2one` WHERE `product_id` = '$product_id' ");

if(mysqli_num_rows($selectProSelectedRef) > 0){

    while($fetchProSelectedRef = mysqli_fetch_array($selectProSelectedRef)){
        array_push($proSelectedRefListArray, $fetchProSelectedRef['reference_id']);
    }

}

$referencesMasterList = array();
$selectMasterRefList = mysqli_query($localhost, "SELECT * FROM `references_master_list` ");
while($fetchMasterRefList = mysqli_fetch_array($selectMasterRefList)){

    $tempMasterRefList = $fetchMasterRefList['id'];
    $subRefListArray = array();
    $selectSubRef = mysqli_query($localhost, "SELECT * FROM `ref_one_dimension` WHERE `master_id` = '$tempMasterRefList' ");
    while ($fetchSubRef = mysqli_fetch_array($selectSubRef)) {
        array_push($subRefListArray, [
            'name' => $fetchSubRef['name'],
            'id' => $fetchSubRef['id'],
        ]);
    }

    array_push($referencesMasterList, [
        'name' => $fetchMasterRefList['name'],
        'id' => $tempMasterRefList,
        'code' => $fetchMasterRefList['code'],
        'list' => $subRefListArray,
    ]);
}

?>

<div class="col-12">
    <h4>References</h4>
    
    <div class="form-group col-5">
        <div class="row">
            
            <?php 
            foreach ($referencesMasterList as $key => $tempMastList) { ?>

                <div class="col-4">
                    <label><?php echo $tempMastList['name'] ?></label>
                </div>
                <div class="col-8">
                    <select id="" class="select2 w-100" onchange="updateOneReference(this, '<?php echo $product_id ?>')">
                        <option value="0" selected disabled>Select <?php echo $tempMastList['name'] ?></option>
                        <?php 
                        foreach ($tempMastList['list'] as $key => $tempSubList) { ?>
                        
                            <option value="<?php echo $tempSubList['id'] ?>" <?php echo comboboxDataArray($tempSubList['id'], $proSelectedRefListArray) ?> ><?php echo $tempSubList['name'] ?></option>

                        <?php } ?>
                        
                    </select>
                    <br>
                </div>

            <?php } ?>

        </div>
    </div>

</div>