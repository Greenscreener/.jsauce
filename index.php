<html>
    <head>
        <script src="jquery.js">
        </script>
        <script>
            var placeholder1;
            var prefix = "<b>@JSAUCE</b>:~$";
            var ecologyrunning = 0;
            var newuser = 1;
            var username;
            var stopwatch = 0;
            var usedstopwatch = 0;
            var comm;
            var version = "1.9";
            var commands = [];
            var commhist = 1;
            var enter = 0;
            var bckgrnd;
            var frgrnd;
            var placeholder2;
            function inputfield () {
                var prefixwidth = document.getElementById("userprefix").offsetWidth;
                var inputwidth = document.getElementById("input").offsetWidth;
                document.getElementById("inputtext").style.width = inputwidth - prefixwidth - 60;
            }
            function output (texttodisplay) {
                var outputtextbefore = document.getElementById("outputtext").innerHTML;
                document.getElementById("outputtext").innerHTML = outputtextbefore + texttodisplay + "<br>";
                return outputtextbefore;
            }
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires="+d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            function getinput () {
                return input;
            }

            function help () {
                output("The list of all commands:");
                output("");
                output("<b>help</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Display this message");
                output("<b>echo</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Display a custom line of text.");
                output("<b>whoami</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Display your username. ");
                output("<b>rm -rf /</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Removes everything - DO NOT PERFORM");
                output("<b>stopwatch</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Display a stopwatch.");
                output("<b>&lt;num&gt; &lt;op&gt; &lt;num&gt;</b>&nbsp;&nbsp; Number (space) Operator (space) Number - Display the result of an equation.");
                output("<b>theme &lt;opt&gt; &lt;col&gt; </b>&nbsp;Change the colors of the terminal. Options: -b - change background color, -t change text color, -d revert to default. Color has to be specificated in a css valid color code(#fff, #ffffff, white, rgb(255,255,255)");
                output("<b>datetime</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Display current date and time.");
                output("<b>reboot</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remove all cookie data, resets everything - themes, command history etc.");
                output("");
                output("PLESE NOTE: This is in an early development stage and is ment mostly for fun. ");
                 output("To request new commands, go <a href='https://github.com/Greenscreener/.jsauce/issues'>here</a> and create a new issue.");
            }
            function echo () {
                var comlen = comm.lenght;
                var text;
                var i;
                for (i = 1; i < comlen; i++) {
                    text += comm[i] + " ";
                    }
                output(text);
                return text;
                }
            function escapeHtml (str) {
                var div = document.createElement('div');
                div.appendChild(document.createTextNode(str));
                return div.innerHTML;
                }
            function stopwatch1 () {
                if (usedstopwatch == 0) {
                    usedstopwatch++;
                    output("<div id='stopwatch' class='stopwatch'></div>");
                    setTimeout(stopwatch2, 1000);
                } else {
                    output("Stopwatch can be used only once.");
                }
            }
            function stopwatch2 () {
                stopwatch++;
                document.getElementById("stopwatch").innerHTML = stopwatch + " seconds";
                setTimeout(stopwatch2, 1000);
            }
            function theme (com1, com2) {
                if (com1 == "-t") {
                    var x = document.getElementsByClassName("jsos");
                    var i;
                    frgrnd = com2;
                    for (i = 0; i < x.length; i++) {
                        x[i].style.color = com2;
                        }
                    } else if (com1 == "-b") {
                        var x = document.getElementsByClassName("jsos");
                        var i;
                        bckgrnd = com2;
                        for (i = 0; i < x.length; i++) {
                            x[i].style.backgroundColor = com2;
                            }
                    } else if (com1 == "-d") {
                        var x = document.getElementsByClassName("jsos");
                        var i;
                        bckgrnd = "black";
                        frgrnd = "white";
                        for (i = 0; i < x.length; i++) {
                            x[i].style.backgroundColor = "black";
                            }
                        for (i = 0; i < x.length; i++) {
                            x[i].style.color = "white";
                            }
                    } else {
                        output("Invalid option.");
                    }
                }
            function rungame () {
                switch (comm[1]) {
                    case "ecology":
                        ecology();
                        if (input != "" && !hasWhiteSpace(input)) {
             commands.push(input);

         }
        savecookies();
                    default:
                        output("Unknown game.");
                }
            }
            function keydown (event) {
                var key = event.keyCode;
                if (key == 13) {
                    enter = 0;
                }
                if (key == 38 || key == 40) {
                    if (commhist == 1 && enter == 0) {
                        var input = escapeHtml(document.getElementById("inputtext").value);
                        commands.push(input);
                        enter = 1;
                    } else if (commhist == 1) {
                        var input = escapeHtml(document.getElementById("inputtext").value);
                        var i = commands.length - 1;
                        commands[i] = input;
                    }
                    if (key == 38 && commhist <= commands.length) {
                        commhist++;
                    } else if (key == 40 && commhist > 1) {
                        commhist--;
                    }
                    var commandslength = commands.length - commhist;
                    document.getElementById("inputtext").value = commands[commandslength];
                    if (commands.length <= commhist) {
                        commhist--;
                    } else if (commhist <= 0) {
                        commhist++;
                    }
                }
            }
            function hasWhiteSpace(s) {
                return s.indexOf(' ') >= 0;
            }
            function savecookies () {
                var save = 0;
                var variables = ""
                for (var name in this) {
                        if (name == "placeholder2") {save = 0;}
                        if (save == 1) {
                            value = window[name];
                            setCookie(name, value, 9999999);
                            variables += name + "\n";
                        }
                        if (name == "placeholder1") {save = 1;}
                }
                return variables;
            }
            function loadcookies () {
                var save = 0;
                var variables = ""
                for (var name in this) {
                        if (name == "placeholder2") {save = 0;}
                        if (save == 1) {
                            window[name] = getCookie(name);
                            variables += name + "\n";
                        }
                        if (name == "placeholder1") {save = 1;}
                }
                commands = commands.split(",");
                theme("-b", bckgrnd);
                theme("-t", frgrnd);
                return variables;
            }
            function formsubmit (debuginput) {
                if (ecologyrunning == 1) {
                    ecologyformsubmit();
                    return false;
                }
                var input = escapeHtml(document.getElementById("inputtext").value);
                if (debuginput != null) {
                    input = debuginput;
                }
                var hours;
                var seconds;
                var minutes;
                if (newuser == 1) {
                    newuser = 0;
                    userword = input.split(" ")
                    username = userword[0];
                    prefix = "<b>" + userword[0] + "</b>" + prefix;
                    document.getElementById("inputtext").value = "";
                    document.getElementById("userprefix").innerHTML = prefix;
                    inputfield();
                } else {
                    document.getElementById("inputtext").value = "";
                    output(prefix + input);
                    comm = input.split(" ");
                    var comm1 = input.split("echo ");
                    switch (comm[0]) {
                        case "help":
                            help();
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);

                            }
                            savecookies();
                            break;
                        case "echo":
                        output(comm1[1]);
                        if (input != "" && !hasWhiteSpace(input)) {
                            commands.push(input);
                        }
                        savecookies();
                            break;
                        case "rm":
                            if (comm[1] == "-rf" && comm[2] == "/") {
                                document.write("");
                                }
                                if (input != "" && !hasWhiteSpace(input)) {
                                    commands.push(input);
                                }
                                savecookies();
                            break;
                        case "whoami":
                            output(username);
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "stopwatch":
                            stopwatch1();
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "theme":
                            theme(comm[1],comm[2]);
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "datetime":
                            var d = new Date();
                            if (d.getHours() < 10) {
                                hours = "0" + d.getHours();
                            } else {
                                hours = d.getHours();
                            }
                            if (d.getMinutes() < 10) {
                                minutes = "0" + d.getMinutes();
                            } else {
                                minutes = d.getMinutes();
                            }
                            if (d.getSeconds() < 10) {
                                seconds = "0" + d.getSeconds();
                            } else {
                                seconds = d.getSeconds();
                            }
                            var o = d.getDate() + "." + (d.getMonth() + 1) + "." + d.getFullYear() + " " + hours + ":" + minutes + ":" + seconds;
                            output(o);
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "game":
                            rungame();
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "":
                            if (input != "" && !hasWhiteSpace(input)) {
                                commands.push(input);
                            }
                            savecookies();
                            break;
                        case "reboot":
                            prefix = "<b>@JSAUCE</b>:~$";
                            ecologyrunning = 0;
                            newuser = 1;
                            username = "";
                            stopwatch = 0;
                            usedstopwatch = 0;
                            comm = "";
                            version = "1.9";
                            commands = [];
                            commhist = 1;
                            enter = 0;
                            bckgrnd = "";
                            frgrnd = "";
                            savecookies();
                            loadcookies();
                            document.getElementById("versionnumber").innerHTML = version;
                            document.getElementById("userprefix").innerHTML = prefix;
                            break;
                        default:
                            if (!isNaN(comm[0]) && !isNaN(comm[2])) {
                                var op1 = +comm[0];
                                var op2 = +comm[2];
                                switch (comm[1]) {
                                    case "+":
                                        var vysl = op1 + op2;
                                        vysl *= 100000000;
                                        vysl = Math.round(vysl);
                                        vysl /= 100000000;
                                        output(vysl);
                                        if (input != "" && !hasWhiteSpace(input)) {
                                            commands.push(input);
                                        }
                                        savecookies();
                                        break;
                                    case "-":
                                        var vysl = op1 - op2;
                                        output(vysl);
                                        if (input != "" && !hasWhiteSpace(input)) {
                                            commands.push(input);
                                        }
                                        savecookies();
                                        break;
                                    case "*":
                                        var vysl = op1 * op2;
                                        output(vysl);
                                        if (input != "" && !hasWhiteSpace(input)) {
                                            commands.push(input);
                                        }
                                        savecookies();
                                        break;
                                    case "/":
                                        var vysl = op1 / op2;
                                        output(vysl);
                                        if (input != "" && !hasWhiteSpace(input)) {
                                            commands.push(input);
                                        }
                                        savecookies();
                                        break;
                                    default:
                                        output("Unknown operator.");
                                        if (input != "" && !hasWhiteSpace(input)) {
                                            commands.push(input);
                                        }
                                        savecookies();
                                    }
                            } else {
                                output("Unknown command. Type 'help' for the list of all commands.");
                                if (input != "" && !hasWhiteSpace(input)) {
                                    commands.push(input);
                                }
                                savecookies();
                                }
                            }
                    }
                if (input != "" && !hasWhiteSpace(input)) {
                     commands.push(input);

                 }
                savecookies();
                return false;
            }
            </script>
        <meta charset="utf-8">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,700" rel="stylesheet">
        <link href="styles/style1.css" rel="stylesheet">
        </head>
    <body>
    <div id="output" class="jsos"><div id="outputtext" clas="jsos">
    Welcome to
    <div style="font-family: monospace, fixed; font-weight: bold;color: #99ff00">
        <span>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;</span><br />
        <span>&#160;&#160;&#160;mmm&#160;&#160;&#160;mmmm&#160;&#160;&#160;&#160;mm&#160;&#160;&#160;m&#160;&#160;&#160;&#160;m&#160;&#160;&#160;mmm&#160;&#160;mmmmmm</span><br />
        <span>&#160;&#160;&#160;&#160;&#160;#&#160;&#160;#&quot;&#160;&#160;&#160;&quot;&#160;&#160;&#160;##&#160;&#160;&#160;#&#160;&#160;&#160;&#160;#&#160;m&quot;&#160;&#160;&#160;&quot;&#160;#&#160;&#160;&#160;&#160;&#160;</span><br />
        <span>&#160;&#160;&#160;&#160;&#160;#&#160;&#160;&quot;#mmm&#160;&#160;&#160;#&#160;&#160;#&#160;&#160;#&#160;&#160;&#160;&#160;#&#160;#&#160;&#160;&#160;&#160;&#160;&#160;#mmmmm</span><br />
        <span>&#160;&#160;&#160;&#160;&#160;#&#160;&#160;&#160;&#160;&#160;&#160;&quot;#&#160;&#160;#mm#&#160;&#160;#&#160;&#160;&#160;&#160;#&#160;#&#160;&#160;&#160;&#160;&#160;&#160;#&#160;&#160;&#160;&#160;&#160;</span><br />
        <span>&#160;&quot;mmm&quot;&#160;&#160;&quot;mmm#&quot;&#160;#&#160;&#160;&#160;&#160;#&#160;&quot;mmmm&quot;&#160;&#160;&quot;mmm&quot;&#160;#mmmmm</span><br />
        <span>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;</span><br />

        JavaScript Authentic Ubuntu Computer Emulator<br>

        </div>
        <div id="version">Version:&nbsp;</div><div id="versionnumber"></div> <br><br>
It is based on the terminal of Ubuntu and made entirely in JavaScript.<br><b>PLESE NOTE: </b>JSAUCE is in an early development stage and is meant mostly for fun. <br> To start please select your username. Warning: A lot of special characters may cause strange things.<br><a href="https://github.com/Greenscreener/.jsauce/">Source Code on GitHub</a> <br />        </div></div>
    <form id="input" class="jsos" onSubmit="formsubmit(); return false;" onkeydown="keydown(event);">
        <div id="userprefix" class="jsos"></div>
        <input type="text" name="input" id="inputtext" autocomplete="off" class="jsos">
        </form>
    <script>
        loadcookies();
        document.getElementById("versionnumber").innerHTML = version;
        document.getElementById("userprefix").innerHTML = prefix;
        inputfield();
        if (0<? echo $_GET["debug"]; ?> == 1) {
            newuser = 0;
            formsubmit("help");
        } else if (0<? echo $_GET["debug"]; ?> == 2) {
            newuser = 0;
            formsubmit("game ecology");
        }
        </script>
        <a href="//github.com/Greenscreener/.jsauce"> <img src="github.png" style="text-decoration: none; box-shadow: 0px 0px 5px black" height="50px"> </a>
    </body>
