function is_valid_month(month) {
	return (month >= "01" && month <= "12")
}


{
    # Check for date format MM-DD
    if ($0 ~ /^[0-9]{2}-[0-9]{2}$/) {
        month = substr($0, 1, 2)
        day = substr($0, 4, 2)
    }
    # Check for date format MM/DD
    else if ($0 ~ /^[0-9]{2}\/[0-9]{2}$/) {
        month = substr($0, 1, 2)
        day = substr($0, 4, 2)
    }
    # Check for date format MM DD
    else if ($0 ~ /^[0-9]{2} [0-9]{2}/) {
        l = split($0, arr, " ")
	month = arr[l-1]
        day = arr[l]
    } else {
        print "0,error.txt"
        next
    }

    if (is_valid_month(month)) {
        print month "," day
    } else {
        print "0,error.txt"
    }
}
