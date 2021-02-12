<?php


class ProfileView
{
    public static function view($data)
    {
        $page = "<div class='container'>
                 <div id='initial-message'>Welcome, " . $_SESSION['username'] . " <a href='/logout'>Logout</a></div>
                 <div><a href='/createwordlist.php' class='button'>Create dictionaries</a></div>
                 <br>
                 <br>
                 <p>Your dictionaries</p>
                 <ul class='list-group'>";
        for ($i = 0; $i < count($data); $i++) {
            $link = "http://englishgenius.loc/wordlist/" . $data[$i]['dictionaryid'];
            $page .= "
                    <li class='list-group-item'>
                        <a class='stretched-link' href='" . $link . "'>" . $data[$i]['name'] . "</a>
                    </li>";
        }
        $page .= '</div>';
        echo $page;
    }
}