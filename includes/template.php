<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.3, maximum-scale=1.0, user-scalable=1" />
    <meta name="apple-mobile-web-app-capable" content="no">
    <title>Siemens | <?php echo $this->title; ?></title>
    <link rel="shortcut icon" href="../favicon.png">
    <link rel="apple-touch-icon" href="../assets/images/icon57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="../assets/images/icon72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="../assets/images/icon76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="../assets/images/icon114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="../assets/images/icon120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="../assets/images/icon144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="../assets/images/icon152.png" sizes="152x152">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <?php
    foreach ($this->stylesheets as $stylesheet) {
        echo '<link href="' . $stylesheet . '" rel="stylesheet" type="text/css" />' . "\n";
    }
    ?>
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript">/* <![CDATA[ */Math.random=function(a,c,d,b){return function(){return 300>d++?(a=(1103515245*a+12345)%b,a/b):c()}}(732528557,Math.random,0,1<<21);/* ]]> */</script>
    <script>
        (function(document,navigator,standalone) {
            if ((standalone in navigator) && navigator[standalone]) {


                var curnode, location=document.location, stop=/^(a|html)$/i;
                document.addEventListener('click', function(e) {
                    curnode=e.target;
                    while (!(stop).test(curnode.nodeName)) {
                        curnode=curnode.parentNode;
                    }

                    if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
                        e.preventDefault();
                        location.href = curnode.href;
                    }
                },false);

            }

        })(document,window.navigator,'standalone');
    </script>
    <script>
        function goBack()
        {
            window.history.back()
        }
    </script>
    <script language="javascript">
        function toggle() {
            var ele = document.getElementById("toggleText");
            var text = document.getElementById("displayText");
            if(ele.style.display == "block") {
                ele.style.display = "none";
                text.innerHTML = "<button class='btn-lgn btn-primary'>Other Week</button>";
            }
            else {
                ele.style.display = "block";
                text.innerHTML = "<button class='btn-lgn btn-primary'>Hide</button>";
            }
        }
    </script>

    <script language="javascript">
        function show() {
            var ele = document.getElementById("toggleLGN");
            var text = document.getElementById("displayLGN");
            if(ele.style.display == "block") {
                ele.style.display = "none";
                text.innerHTML = "<h2>Show Legend</h2>";
            }
            else {
                ele.style.display = "block";
                text.innerHTML = "<h2>Hide Legend</h2>";
            }
        }
    </script>

    <script language="javascript">
        $(function() {
            $( "#datepicker" ).datepicker({
                dateFormat: "m/dd/y",
                altField: "#alternate",
                showOn: "button",
                onSelect: function(date, ui){
                    ui.settings.altField = (ui.settings.altField=="#alternate") ? "#endDate" : "#startDate";
                }
            });
        });
    </script>
</head>

<body>

<div id="wrapper">

    <div id="header">
        <h1><a href="../dashboard/">Siemens</a></h1>

        <a href="javascript:;" id="reveal-nav">
            <span class="reveal-bar"></span>
            <span class="reveal-bar"></span>
            <span class="reveal-bar"></span>
        </a>
    </div>
    <?php
    echo $this->body;
    include "topnav.php";
    ?>
    <div id="footer">
        Copyright &copy; 2013, Siemens Industry.
        <br>
        Designed by Nicholas Knight
    </div>
    <?php
    foreach ($this->javascripts as $javascript) {
        echo '<script src="' . $javascript . '" language="javascript" type="text/javascript" defer="defer"></script>' . "\n";
    }
    ?>
</body>
</html>
