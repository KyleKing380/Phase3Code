<!doctype html>
<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    //Creates the session
    session_start();
    include "adminutils.php";
    
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
    if (isset($_POST['btnLawyerInsert']))
        $databaseAction = 'doLawyerInsert';
    if (isset($_POST["btnDelete"]))
        $databaseAction = 'doDelete';
    if (isset($_POST["btnCaseDelete"]))
        $databaseAction = 'doCaseDelete';
    if (isset($_POST["btnLawyerDelete"]))
        $databaseAction = 'doLawyerDelete';
    if (isset($_POST["btnEdit:"]))
        $databaseAction = 'doEdit';
    
    if (isset($_POST['showInsertForm']))
        $displayAction = 'showInsertForm';
    
    elseif (isset($_POST['showCaseInsertForm']))
        $displayAction = 'showCaseInsertForm';
    
    elseif (isset($_POST['showLawyerInsertForm']))
        $displayAction = 'showLawyerInsertForm';
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
    
    if ($databaseAction == 'doLawyerInsert')
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
    
    else if ($databaseAction == 'doLawyerDelete')
    {
        deleteLawyerRecord();
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
    
    if ($displayAction == 'showLawyerInsertForm')
    {
        
        displayLawyerInsertForm();
    }

    // Default action: show always be true since inialized at script start
    // Display tables showing all lawyers, clients, and cases
    
    else if ($displayAction == 'showRecords')
    {
        showClientRecords();
    }
    $conn->close();
?>
</body>

</html>
