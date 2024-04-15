function timeAgo(dateTime) {
    var dateTimeArray = dateTime.split(" ");
    var dateArray = dateTimeArray[0].split("-");
    var timeArray = dateTimeArray[1].split(":");

    var sortedDateTime = dateArray[2] + "-" + dateArray[1] + "-" + dateArray[0] + " " + timeArray[0] + ":" +
        timeArray[1] + ":" + timeArray[2];
    return sortedDateTime;
}