<?php


class ProfileView
{
    public static function view(/*$content_view, $template_view,*/ $data, $title)
    {

        //include 'application/views/' . $template_view;

        $page = '';
        include 'header.php';
        $page .= "<div id='initial-message'>Welcome, " . $_SESSION['username'] . " <a href='/logout'>Logout</a></div>
                  <div><a href='/createwordlist.php' class='button'>Create dictionaries</a></div>
                  <br>
                  <br>
                  <p>Your dictionaries</p>
                  <ul class='list-group'>";
        for ($i = 0; $i < count($data); $i++) {
            $link = "http://englishgenius.loc/dictionary/" . $data[$i]['dictionaryid'];
            $page .= "
                    <li class='list-group-item'>
                        <a class='stretched-link' href='" . $link . "'>" . $data[$i]['name'] . "</a>
                    </li>";
        }
        $page .= '</ul>';
        echo $page;
        include 'footer.php';

    }
}