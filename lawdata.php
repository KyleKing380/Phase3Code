<!doctype html>
<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    //Creates the session
    session_start();
    include "lawutils.php";
    
    if (!isset($_SESSION['login']) || $_SESSION['login'] == '')
    {
        echo $_SESSION['login'];
        header ("Location: ./lawlogin.html");
    } 
    
    
    echo "<h2>Lawyer DB Manager</h2>";

    //************//
    
    connectToDB();
    
    ///**********//
    
    $thisPHP = $_SERVER['PHP_SELF'];
    $databaseAction = '';            
    $displayAction = 'showRecords';      // Default display 

    if (isset($_POST['btnInsert']))
        $databaseAction = 'doInsert';
    if (isset($_POST['btnCaseInsert']))
        $databaseAction = 'doCaseInsert';
    if (isset($_POST["btnDelete"]))
        $databaseAction = 'doDelete';
    if (isset($_POST["btnCaseDelete"]))
        $databaseAction = 'doCaseDelete';
    if (isset($_POST["btnEdit:"]))
        $databaseAction = 'doEdit';
    
    if (isset($_POST['showInsertForm']))
        $displayAction = 'showInsertForm';
    
    elseif (isset($_POST['showCaseInsertForm']))
        $displayAction = 'showCaseInsertForm';
    else
        $displayAction ='showRecords';

    
    ///*****************//
    // Database Actions
    ///*****************//
    // These two are pre-display database actions.
    // Insertion or Deletion will be done prior to showClientRecords()
    // And thus, showClientRecords() will show updated database
    
    //Insert Actions
             
    if ($databaseAction == 'doInsert')
    {
       insertClientRecord();
    }
    
    if ($databaseAction == 'doCaseInsert')
    {
       insertCaseRecord();
    }
    
    //Delete Actions
                  
    else if ($databaseAction == 'doDelete')
    {
        deleteClientRecord();
    }
    
    else if ($databaseAction == 'doCaseDelete')
    {
        deleteCaseRecord();
    }
    
    //Displaying the screens for entering the data
    if ($displayAction == 'showInsertForm')
    {
        
        displayInsertForm();
    }
    
    if ($displayAction == 'showCaseInsertForm')
    {
        
        displayCaseInsertForm();
    }

    // Default action: show always be true since inialized at script start
    // Display tables showing all client records and all cases
    
    else if ($displayAction == 'showRecords')
    {
        showClientRecords();
    }
    $conn->close();
?>
</body>

</html>
