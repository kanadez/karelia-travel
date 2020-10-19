var post_url = "post.php";
var urlparser = new urlParser();

$(document).ready(function(){
   $("#accordion_div").accordion({ header: "h3" });
   urlparser.parse();
});