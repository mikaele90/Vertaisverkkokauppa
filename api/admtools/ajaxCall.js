//POST REQUEST

$(document).ready(function(){
    $('#postMessage').click(function(e){
        e.preventDefault();

        //serialize form data
        var url = $('form').serialize();

        //function to turn url to an object
        function getUrlVars(url) {
            var hash;
            var myJson = {};
            var hashes = url.slice(url.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                myJson[hash[0]] = hash[1];
            }
            return JSON.stringify(myJson);
        }

        //pass serialized data to function
        var test = getUrlVars(url);

        //item with ajax
        $.ajax({
            type:"POST",
            url: "/Vertaisverkkokauppa/Vertaisverkkokauppa/api/item/create.php",
            data: test,
            ContentType:"application/json",

            success:function(){
                alert('successfully posted');
            },
            error:function(){
                alert('Could not be posted');
            }

        });
    });
});


//GET REQUEST

document.addEventListener('DOMContentLoaded',function(){
    document.getElementById('getMessage').onclick=function(){

        var xhr;
        xhr = new XMLHttpRequest();
        var url = '/Vertaisverkkokauppa/Vertaisverkkokauppa/api/item/read.php';
        xhr.open("GET", url,true);
        xhr.send();

        xhr.onload=function(){
            var parsedJson = JSON.parse(xhr.responseText);
            console.log(parsedJson);
            console.log(parsedJson[1]);
            console.log(JSON.stringify(parsedJson));

            //limit data called
            var son = parsedJson.filter(function(val) {
                return (val >= 4);
            });

            var html = "";

            for (var i = 0; i < parsedJson.length; i++) {
                html += JSON.stringify(parsedJson[i]) + '<br>';
            }

            //append in message class
            document.getElementsByClassName('message')[0].innerHTML=html;
        };
    };
});

