<?php

define ('DB', '/home/tom/Downloads/CRUD/test/db.txt');

function addStudents($firstname,$lastname,$roll){
   global $found ;
   $found = false;
    $unserializedData = file_get_contents (DB);
    $students = unserialize ($unserializedData);

    foreach ($students as $student) {
        if ($student['roll'] == $roll){
            $found = true;
            break;
     
        }
    }
    if (!$found) {
        $newId = count ($students) + 1;

        $student = array(
            "id" => $newId,
            "fname" => $firstname,
            "lname" => $lastname,
            "roll" => $roll
        );

        array_push ($students, $student);
        $serializedData = serialize ($students);
        file_put_contents (DB, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}




function seed(){
    $data = array(
            array(
                "id"    => 1,
                "fname" => "kamal",
                "lname" => "Ahmed",
                "roll" => "11"
            ),
            array(
                "id"    => 2,
                "fname" => "Jamal",
                "lname" => "Ahmed",
                "roll" => "12"
            ),
            array(
                "id"    => 3,
                "fname" => "sajib",
                "lname" => "khan",
                "roll" => "13"
            ),
            array(
                "id"    => 4,
                "fname" => "rahin",
                "lname" => "hasan",
                "roll" => "13"
            ),
    );

    $serializedData = serialize ($data);
    file_put_contents (DB, $serializedData,LOCK_EX);
}

function generateReport(){
    $unserializedData = file_get_contents (DB);
    $unserializedData = unserialize ($unserializedData);
?>
    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th width="25%">Action</th>
        </tr>
        
        <?php
        foreach ($unserializedData as $students) { ?>
            <tr>

                <td><?php printf ("%s %s",$students["fname"],$students["lname"])?></td>
                <td><?php printf ("%s",$students["roll"])?></td>
                <td><?php printf ("<a href='/index.php?task=edit&id=%s'>Edit</a> | <a href='/index.php?task=delete&id=%s'>Delete</a>",$students["id"],$students["id"])?></td>

            </tr>
       <?php } ?>
        
    </table>
<?php
}

