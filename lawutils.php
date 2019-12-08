<?php

// Function create the DB connection

function connectToDB()
{   
    global $conn;
    
    $servername = "localhost";
    $username = "root";         // Username for your phpMyAdmin account. Change to the password for your local account
    $password = "newpassword";  // Password for your phpMyAdmin account. Change to the password for your local account
    $dbname = "lawfirmdb";     // phpMyAdmin database name. Does not need to be changed.

	$conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  
   
}

// Function for inserting client records to the database
function insertClientRecord()
{
    global $conn;
    
    $cid = $_POST['cid'];
    $cfname = $_POST['cfname'];
    $clname = $_POST['clname'];
    $clawid = $_POST['clawid'];
        
    if (!empty($cid) && !empty($cfname) && !empty($clname) && !empty($clawid)){
        $sql = "insert into LAWCLIENT (CLIENT_ID, CLIENT_FNAME, CLIENT_LNAME, LAWYER_ID)" .
                    " values ('$cid', '$cfname', '$clname', '$clawid')";
        if ($conn->query ($sql) == TRUE) {
           
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    } 
    else
    {
        echo "Invalid <br>";
        $action = 'showInsertForm';
    }
}

//function for deleting the client records
function deleteClientRecord()
{
    global $conn;
    $cid = $_POST['cid'];
    if (!empty($cid)){
        $sql = "delete from LAWCLIENT where CLIENT_ID = '$cid'";
        
        if ($conn->query ($sql) == TRUE) {
            
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    }
    else
    {
        echo "Must provide a CLIENT_ID to delete a record <br>";
    }
}

//function for deleting the case records
function deleteCaseRecord()
{
    global $conn;
    $cid = $_POST['cid'];
    if (!empty($cid)){
        $sql = "delete from LAWCASE where CASE_ID = '$cid'";
        
        if ($conn->query ($sql) == TRUE) {
            //echo "DEBUG: Record deleted <br>";
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    }
    else
    {
        echo "Must provide a CASE_ID to delete a record <br>";
    }
}


//function for displaying the main screen
function showClientRecords()
{
    global $conn;
    global $thisPHP;
    
 
    
    
    
    //shows the button for adding a new client
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>Click to Insert New Client to Database</legend>";
    echo "<input type='submit' name='showInsertForm' value='Add New Client'>";
    echo "</form></fieldset>";
    
    //displays the table LAWCLIENT in the database
    $sql = "SELECT * FROM LAWCLIENT";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) 
    {         
        echo "<h4>Your Clients</h4>";
        echo "<table>";
        echo "<thead><tr><td>Client Id</td> <td>Client First Name </td> <td>Client Last Name</td><td>Lawyer Id</td> ";
        echo " <td> Delete? </td></tr></thead>";   
        while($row = $result->fetch_assoc()) 
        {
            echo "<tbody><tr>";
            $cid = $row["CLIENT_ID"];
            echo  "<td>" . $cid . "  </td> <td> " . $row["CLIENT_FNAME"] . 
                  " </td> <td> " . $row["CLIENT_LNAME"] . 
    		      " </td> <td> " . $row["LAWYER_ID"] .  
                  "</td> <td> "; 
    
            //delete button
            echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
            echo "<input type='hidden' name='cid' value='{$cid}'>";
            echo "<input type='submit' name='btnDelete' value='Remove'></form>";
            echo "</td></tr></tbody>";
        }
        
      echo "</table>";
        
    } 
    else 
    {
        echo "0 results";
    }
    
    echo "<br>";
    
    //creates the button for adding new cases to the database
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>Click to Insert New Case to Database</legend>";
    echo "<input type='submit' name='showCaseInsertForm' value='Add New Case'>";
    echo "</form></fieldset>";
    
    //shows the contents of the LAWCASE table
    $casesql = "SELECT * FROM LAWCASE";
    $caseresult = $conn->query($casesql);
    
    if ($caseresult->num_rows > 0) 
    {         
        echo "<h4>Your Cases</h4>";
        echo "<table>";
        echo "<thead><tr><td>Case Id</td> <td>Client Id </td> <td>Case Description</td><td>Lawyer Expenses</td> ";
        echo "<td>Lawyer Fee</td> <td> Delete? </td></tr></thead>";   
        while($row = $caseresult->fetch_assoc()) 
        {
            echo "<tbody><tr>";
            $cid = $row["CASE_ID"];
            echo  "<td>" . $cid . "  </td> <td> " . $row["CLIENT_ID"] . 
                  " </td> <td> " . $row["CASE_DESC"] . 
    		      " </td> <td> " . $row["LAWYER_EXPENSES"] .  
                  " </td> <td> " . $row["LAWYER_FEE"] .
                  "</td> <td> "; 
    
            //delete button
            echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
            echo "<input type='hidden' name='cid' value='{$cid}'>";
            echo "<input type='submit' name='btnCaseDelete' value='Close'></form>";
            echo "</td></tr></tbody>";
        }
        
        echo "</table>";
    } 
    else 
    {
        echo "0 results";
    }
    
    
    
}

//function for inputting data for new cases
function displayCaseInsertForm()
{
    global $thisPHP;
    
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Case Data Entry</legend> Case Id:
        <input type="text" name="caseid" size="5">
        <br> Client Id:
        <input type="text" name="clientid" size="5">
        <br> Case Description:
        <input type="text" name="casedesc" size="30">
        <br> Lawyer Expenses:
        <input type="text" name="lawexp" size="15">
        <br> Lawyer Fee:
        <input type="text" name="lawf" size="15">
        <input type="submit" name="btnCaseInsert" value="Insert"><br>
    </fieldset>
    </form>
EOD;

    echo $str;
}

//function for inserting the new case data into the database
function insertCaseRecord()
{
    global $conn;
    
    $caseid = $_POST['caseid'];
    $clientid = $_POST['clientid'];
    $casedesc = $_POST['casedesc'];
    $lawexp = $_POST['lawexp'];
    $lawf = $_POST['lawf'];
        
    if (!empty($caseid) && !empty($clientid) && !empty($casedesc) && !empty($lawexp)){
        $sql = "insert into LAWCASE (CASE_ID, CLIENT_ID, CASE_DESC, LAWYER_EXPENSES, LAWYER_FEE)" .
                    " values ('$caseid', '$clientid', '$casedesc', '$lawexp', '$lawf')";
        if ($conn->query ($sql) == TRUE) {
           
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    } 
    else
    {
        echo "Invalid <br>";
        $action = 'showCaseInsertForm';
    }
}
//function for inputting data for new clients
function displayInsertForm()
{
    global $thisPHP;
    
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Client Data Entry</legend> Client Id:
        <input type="text" name="cid" size="10">
        <br> First Name:
        <input type="text" name="cfname" size="30">
        <br> Last Name:
        <input type="text" name="clname" size="20">
        <br> Lawyer Id:
        <input type="text" name="clawid" size="15">
        <input type="submit" name="btnInsert" value="Insert"><br>
    </fieldset>
    </form>
EOD;

    echo $str;
}
?>
