function object() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlHttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xmlHttp;
}
http = object();
function liveSearch(data) {
  if (data != "") {
    http.onreadystatechange = process;
    http.open('GET', './handle/search.php?data=' + data, true);
    http.send();
  } else {
    http.onreadystatechange = process;
    http.open('GET', './handle/search.php?data=', true);
    http.send();
  }
}

function navigation(page) {
  if (!isEmpty(page)) {
    http.onreadystatechange = process('.content-container-table-body')
    http.open('GET', './handle/search.php?data=' + data, true);
    http.send();
  }
}

function process() {
  if (http.readyState == 4 && http.status == 200) {
    result = http.responseText;
    $(".content-container-table-body").innerHTML = result;

  }
}


