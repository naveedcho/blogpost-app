<!DOCTYPE html>
<head>
    <meta charset="UTF-8"/>
    <title></title>
    <script>
        function resizetweeter() {
            if (window.innerWidth < 800) {
                //console.log("Window size changed.");
                var element = document.getElementById('tweeter');
                element.classList.remove('Browser');
                element.setAttribute('class', 'Mobile');
            }
            else {
                var element = document.getElementById('tweeter');
                element.classList.remove('Mobile');
                element.setAttribute('class', 'Browser');
            }
        }

        addEventListener("resize", resizetweeter);

        function addtweet(event) {
            if (newtweet.value != "")
            {
                const element = document.createElement('div');
                element.classList.add("tweet");
                input = newtweet.value;
                element.innerHTML += input;
                document.getElementsByClassName("tweets")[0].prepend(element);
            }
        }
    </script>
    <style>
        /*
        body {
            background-color: black;
        }
        */
        header {
            text-align: center;
        }
        #tweeter {
            width: 300px;
            height: 120px;
            /* border: 1pt solid black; */
        }
        textarea {
            resize: none;
            width: 280px;
            height: 80px;
            display: block;
            margin: auto;
        }
        #tweetbutton {
            margin-top: 5px;
            float: right;
        }
        .Browser {
            float: left;
            margin-right: 5px;
        }
        .Mobile {
            margin: auto;
        }
        .tweets {
            overflow: hidden;
        }
        .tweet {
            border: 1pt solid black;
            margin-top: 5px;
            height: 50px;
            padding-top: 10px;
            padding-left: 10px;
            /*
            border-radius: 20px;
            border-color: #5DF31D;
            box-shadow: 0 0 2px green;
            */
        }
        /*
        .tweet p, header {
            color: #1DB9F3;
            text-shadow: 0 0 7px blue, 0 0 15px blue, 0 0 21px blue;
        }
        */
    </style>
</head>
<body>
    <header>Dark Twitter</header>
    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
    <form id="tweeter" name="tweeting" action="process.php" method="post" target="dummyframe">
        <textarea id="newtweet" name="newentry" placeholder="What's on your mind?" maxlength="140" required></textarea>
        <input id="tweetbutton" type="submit" value="Tweet" onclick="addtweet(event)"/>
    </form>
    <script>
        /* Storing user device details in a variable*/
        let details = navigator.userAgent;
        /* Passing regular expression containing mobile devices keywords to search in details string*/
        let regexp = /android|iphone|kindle|ipad/i;
        /* Using test() method to search regexp in details*/
        let isMobileDevice = regexp.test(details);

        /* Script to detect device upon start */
        if (isMobileDevice || window.innerWidth < 800) {
            var element = document.getElementById('tweeter');
            element.setAttribute('class', 'Mobile');
        } 
        else {
            var element = document.getElementById('tweeter');
            element.setAttribute('class', 'Browser');
        }
    </script>
    <div class="tweets">
        <?php
            require_once 'twitterdblogin.php';
            $connection = new mysqli($hn, $un, $pw, $db);

            if ($connection->connect_error) die ("Fatal error.");

            $query = 'SELECT * FROM `TWEETS`';
            $result = $connection->query($query);
            if (!$result) die("Fatal error");

            $rows = $result->num_rows;

            for ($j = $rows - 1; -1 < $j; $j--) {
                $result->data_seek($j);

                echo '<div class="tweet"><p>'.htmlspecialchars($result->fetch_assoc()['tweet']).'</p></div>';
            }

            $result->close();
            $connection->close();
        ?>
        <div class="tweet">
            <p>Center of the Earth</p>
        </div>
    </div>
</body>
</html>