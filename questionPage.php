<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>

  <script language="javascript">
    function processQuestion()
    {
      //alert("Here in processQuestion");
      var theCorrectAnswer = document.getElementById('correctAnswer').value;     
      var radioBtnAnswers = document.getElementsByName('Answers');
      var userAnswerIs = "";

      for (var i = 0, length = radioBtnAnswers.length; i < length; i++) {
        if (radioBtnAnswers[i].checked) {
          // do whatever you want with the checked radio
          //alert('User selected value: ' + radioBtnAnswers[i].value);
          userAnswerIs = radioBtnAnswers[i].value;

          // only one radio can be logically checked, don't check the rest
          break;
        }
      }  
      
      if (userAnswerIs == "") {
        alert('User must make an answer choice');
        return false;
      }
      
      var correctCount = document.getElementById('numberCorrectAnswers').value;
      var wrongCount = document.getElementById('numberWrongAnswers').value;
      
      
      if (userAnswerIs == theCorrectAnswer) {
        alert('You have selected wisely, you got answer correct.');
        correctCount = parseInt(correctCount) + 1;
        document.getElementById('numberCorrectAnswers').value = parseInt(correctCount);
      }
      else {
        alert('Sorry you have selected an incorrect response.');
        wrongCount = parseInt(wrongCount) + 1;
        document.getElementById('numberWrongAnswers').value = wrongCount;      
      }
      
      // decrement the number of questions remaining in the quiz
      var questionCount = document.getElementById('numberOfQuestions').value;
      document.getElementById('numberOfQuestions').value = parseInt(questionCount) - 1;
      
      // Now calculate the current score
      var totalQuestions = parseInt(correctCount) + parseInt(wrongCount);
      //alert('TotalQ: ' + totalQuestions);
      var newScore = (correctCount / totalQuestions) * 100.0;
      newScore.toFixed(1);  // Fix decimal to 2 places
      //alert('newScore: ' + newScore);
      document.getElementById('fScore').value = newScore.toFixed(1);

      var theQuestionNumber = document.getElementById('questionNumber').value; 
      // Increment by one so the next question will be used 
      document.getElementById('questionNumber').value = parseInt(theQuestionNumber) + parseInt(1);

      if(questionCount == 1) {
        // Then this was the last question so change the action page to quizGrade.pdp page
        alert('Quiz is complete');
        var frm = document.getElementById('theForm');
        frm.action = 'quizGrade.php';
      }
      
      //alert('This is just a pause before going to next question or score page');
      theForm.submit();
      
    }
    
  </script>

</head>

<body>

<form id="theForm" action="questionPage.php" method="post">

  <input type="hidden" id="fFirstName" name="fFirstName" value="<?php echo $_POST["fFirstName"]; ?>" /><br />
  <input type="hidden" id="fLastName" name="fLastName" value="<?php echo $_POST["fLastName"]; ?>" /><br />
  <input type="hidden" id="fSchoolComp" name="fSchoolComp" size="40" value="<?php echo $_POST["fSchoolComp"]; ?>" /><br />
  <input type="hidden" id="numberCorrectAnswers" name="numberCorrectAnswers" value="<?php echo $_POST["numberCorrectAnswers"]; ?>" />
  <input type="hidden" id="numberWrongAnswers" name="numberWrongAnswers" value="<?php echo $_POST["numberWrongAnswers"]; ?>" />
  <input type="hidden" id="numberOfQuestions" name="numberOfQuestions" value="<?php echo $_POST["numberOfQuestions"]; ?>" />
  <input type="hidden" id="fScore" name="fScore" value="<?php echo $_POST["fScore"]; ?>" />
  <input type="hidden" id="questionNumber" name="questionNumber" value="<?php echo $_POST["questionNumber"]; ?>" />


<?php

$dbcon = mysqli_connect('fdb12.awardspace.net','2259205_usuquiz','Derek22USU','2259205_usuquiz');
if (!$dbcon) {
    die('Could not connect to Scores db: ' . mysqli_error($dbcon));
}

$sqlQ="SELECT QuestionText FROM Questions WHERE QuestionID = " . $_POST['questionNumber'] . ";";
$sqlA="SELECT AnswerID, AnswerText, CorrectAnswer FROM Answers WHERE QuestionID = " . $_POST['questionNumber'] . ";";
$resultQ = mysqli_query($dbcon,$sqlQ);

if (!$resultQ) {
    printf("Database Error reading Question: %s\n", mysqli_error($dbcon));
    exit();
}
$resultA = mysqli_query($dbcon,$sqlA);

if (!$resultA) {
    printf("Database Error reading Answers: %s\n", mysqli_error($dbcon));
    exit();
}

$getQuestionRow = mysqli_fetch_array($resultQ);

echo "<h1> Question:</h1><br /><h2> " . $getQuestionRow['QuestionText'] . "</h2>";

$loopCtr=1;
while($row = mysqli_fetch_array($resultA)) {
    if ($loopCtr == 1) { $letterChoice = "A"; }
    if ($loopCtr == 2) { $letterChoice = "B"; }
    if ($loopCtr == 3) { $letterChoice = "C"; }
    if ($loopCtr == 4) { $letterChoice = "D"; }
    if ($loopCtr == 5) { $letterChoice = "E"; }
    
      

    echo $letterChoice . " : <input type='radio' id='Answers_" . $row['AnswerID'] . "' name='Answers' value='" . $row['AnswerText'] . "' />" . $row['AnswerText'] . "<br />";
    
    if ($row['CorrectAnswer'] == "Y") {
      echo "<input type='hidden' id='correctAnswer' name='correctAnswer' value='" . $row['AnswerText'] . "' />";
    }
    $loopCtr++;
}
mysqli_close($dbcon);
?>
<br />
<input type="button" id="btnStartQuiz" name="btnStartQuiz" value="Submit Answer" onClick="processQuestion();" />

</form>

</body>
</html>