<html>
<body>
   	<h1>Awkward Astrology</h1>
	<p> Input your birthday to see what astrological sign you are!</p>
	<p> Try with "MM-DD", "MM/DD" or "MM DD"

    <form method="post" action="">
        <label for="inputText">Birthdate</label><br>
        <textarea name="inputText" id="inputText" rows="1" cols="15"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Capture input text from the form
        $inputText = $_POST['inputText'];

	// Make sure to escape the output so they can not inject to get our flag.txt file!
        $escapedInput = escapeshellarg($inputText);
        $command = "echo $escapedInput | awk -f parse.awk";
        $parsed_date = shell_exec($command);

	list($month, $day) = explode(',', $parsed_date);

	// Removes whitespace that likes to tag along
	$month = preg_replace("/\s+/", "", $month);
    	$day = preg_replace("/\s+/", "", $day);

	// These dates are LLM generated as I do not care to look them up, if they are incorrect my apologies.
	if (($month == 3 && $day >= 21) || ($month == 04 && $day <= 19)) {
        	echo 'Aries <br>';
    	} elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
        	echo 'Taurus <br>';
    	} elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
        	echo 'Gemini <br>';
    	} elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
        	echo 'Cancer <br>';
    	} elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
        	echo 'Leo <br>';
    	} elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
        	echo 'Virgo <br>';
    	} elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
        	echo 'Libra <br>';
    	} elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
        	echo 'Scorpio <br>';
    	} elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
        	echo 'Sagittarius <br>';
    	} elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) {
        	echo 'Capricorn <br>';
    	} elseif (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
        	echo 'Aquarius <br>';
    	} elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
        	echo 'Pisces <br>';
    	} else {
        	echo 'Invalid date <br>';
    	}
	// If $day is error.txt (from the parse script) then display it as an error message
        $error_out = file_get_contents($day);
	echo $error_out;
    }
    ?>

</body>
</html>
