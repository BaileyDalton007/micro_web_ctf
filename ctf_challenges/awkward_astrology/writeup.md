# Awkward Astrology

Here, we are given a web interface with a text input that takes a date as text and outputs an astrological sign that the birthdate falls under.

![image](https://github.com/user-attachments/assets/9490fd42-fcbb-49f1-bffc-064525c19ac3)

Upon submitting `08/05`, we get the output:

![image](https://github.com/user-attachments/assets/2731c15c-71f3-4e06-aa7b-04e412bc9f55)

I do not care enough to validate the sign is correct since I reckon the vulnerability will be within the text parsing. Since this challenge gives us the source, let's begin looking at that.

Starting with `page.php`, we see that the webpage takes the text input, passes it to an `awk` script with:

```php
// Make sure to escape the output so they can not inject to get our flag.txt file!
$escapedInput = escapeshellarg($inputText);
$command = "echo $escapedInput | awk -f parse.awk";
```

It looks like our input has been escaped, so we can not directly inject it to get the flag. However, the comment does tell us we are looking for a `flag.txt` file.

The output of the `awk` script looks to be of the format MM,DD based on the parsing done in the PHP:

```php
list($month, $day) = explode(',', $parsed_date);

// Removes whitespace that likes to tag along
$month = preg_replace("/\s+/", "", $month);
$day = preg_replace("/\s+/", "", $day);
```

Then, the day and month are compared to the bounds for different astrological signs:

```php
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
```

The most interesting part is those last two lines. It looks like if there is an error in the `awk` script, it will output `error.txt` as the day in the date. Since we know we are looking for a `flag.txt` file, I think this is our vulnerability.

What we need now is to find an input to the `awk` script that will output `<anything>,flag.txt`.

So let's look at `parse.awk`

Looking at the script, it seems like it uses regex to check if the input is in one of the three formats: `MM-DD`, `MM/DD`, or `MM DD`, and outputs `"0,error.txt"` otherwise.

Closely inspecting the regex for the three formats, we can see the third (`MM DD`) is different:

`$0 ~ /^[0-9]{2}-[0-9]{2}$/`

`$0 ~ /^[0-9]{2}\/[0-9]{2}$/`

`$0 ~ /^[0-9]{2} [0-9]{2}/`

The first two are of the form `^...$`. In regex, `^` is the beginning of the string, and `$` is the end of the string. This means that the first two patterns must cover the whole string, if there is anything else before or after, there is no match.

The third is missing the `$`, which means we could add to the end of the string and still have it match.

Looking at the awk script we see how that third pattern is handled:

```awk
# Check for date format MM DD
else if ($0 ~ /^[0-9]{2} [0-9]{2}/) {
  l = split($0, arr, " ")
  month = arr[l-1]
  day = arr[l]
```

The input string is split on `" "` (a space), then the month is the second to last element, and the day is the last element in that split list.

With inputs of the form `MM DD` this is fine as there are only two elements, but we know that we can add to the ending. This means with an input like `MM DD foobar`, the script parses out `month = DD` and `day=foobar`. 

The last check we need to pass is to make sure our month is valid:

```awk
if (is_valid_month(month)) {
  print month "," day
```

Since our `month = DD`, we need the day in our input to be 1-12. 

Let us try our injection to get the `flag.txt` file.

`05 01 flag.txt`

![image](https://github.com/user-attachments/assets/97f51ff4-b968-422e-a3ad-5a8fd40530ae)

![image](https://github.com/user-attachments/assets/9b4cc277-ad81-470c-aaac-b073f5d3cda4)

We got our flag!

PS. Making this, I learned that making an web `awk` based challenge is really hard. The easiest part of this challenge was probably the pun in the name.
