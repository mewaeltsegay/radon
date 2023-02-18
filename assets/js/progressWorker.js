/**
 * Created by NCEW on 6/7/2020.
 */

var i = 0;

function timedCount() {
    i = i + 1;
    postMessage(i);
    setTimeout("timedCount()",100);
}

timedCount();
