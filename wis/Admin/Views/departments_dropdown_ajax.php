
    <option disabled selected value>Select Department</option>
    
    <?php if (!empty($total_cats)) {
        foreach ($total_cats as $departments) { ?>
            <option value="<?= $departments['DeptID']; ?>" style="font-weight:800;background-color:#e9ebed;font-size:18px"><?= $departments['DeptName']; ?></option>
            <?php if (isset($departments['children'])) {
                for ($i = 0; $i <= count($departments['children']); $i++) {
                    if (isset($departments['children'][$i])) { ?>
                        <option value="<?= $departments['children'][$i]['DeptID']; ?>" style="font-weight:400;font-size:14px"> <?= $departments['children'][$i]['DeptName'] ?></option>
                        <?php if (isset($departments['children'][$i]['children'])) {
                            for ($j = 0; $j <= count($departments['children'][$i]['children']); $j++) {
                                if (isset($departments['children'][$i]['children'][$j])) { ?>
                                    <option value="<?= $departments['children'][$i]['children'][$j]['DeptID']; ?>" style="background-color:#bcbfc2;font-size:12px"><?= $departments['children'][$i]['children'][$j]['DeptName']; ?></option>
                            <?php  }
                            }
                        }
                    }
                }
            }
        }
    } ?>
