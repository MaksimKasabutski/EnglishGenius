<?php

namespace Components;

use Components\DB;

class Pagination
{
    public $wordsPerPage;

    public function __construct($wordsPerPage)
    {
        $this->wordsPerPage = $wordsPerPage;
    }

    public function getDataCount(): int
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        $mysqli = DB::connectToDB();
        $dataCount = ($mysqli->query("SELECT COUNT(*) FROM wordlist WHERE dictionaryid = '$dictionaryId'"))->fetch_row()[0];
        $mysqli->close();
        return $dataCount;
    }

    public function getPagesCount()
    {
        $dataCount = self::getDataCount();
        $pagesCount = ceil($dataCount / $this->wordsPerPage);
        return (($pagesCount == 0) ? 1 : $pagesCount);
    }

    public function getPage(): int
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        return $page;
    }

    public function getFirstWord(): int
    {
        return self::getPage() * $this->wordsPerPage - $this->wordsPerPage;
    }

    public function createPagination()
    {
        $pagesCount = self::getPagesCount();
        $page = self::getPage();
        $data = "";
        if ($pagesCount > 1) {
            if ($pagesCount < 8) {
                $data .= "<section id='pagination'>";
                for ($i = 1; $i <= $pagesCount; $i++) {
                    if ($i == $page) {
                        $data .=  "<a class='pagination-buttons'><div class='pg-in active'> " . $i . "</div></a>";
                    } else {
                        $data .=  "<a class='pagination-buttons' href=?page=" . $i . "><div class='pg-in'> " . $i . "</div></a>";
                    }
                }
                $data .=  "</section>";
            } else {
                $data .=  "<section id='pagination'>";
                for ($i = 1; $i <= $pagesCount; $i++) {
                    if ($i == 1 or $i == $pagesCount or $i == $page - 1 or $i == $page or $i == $page + 1) {
                        if ($i == $page - 1 and $i != 1 and $i != 2) {
                            $data .=  "<div class='pg-in'> ... </div>
                              <a class='pagination-buttons' href=?page=" . $i . "><div class='pg-in'> " . $i . "</div></a>";
                        } elseif ($i == $page + 1 and $i != $pagesCount and $i != $pagesCount - 1) {
                            $data .=  "<a class='pagination-buttons' href=?page=" . $i . "><div class='pg-in'> " . $i . "</div></a>
                              <div class='pg-in'> ... </div> ";
                        } elseif ($i == $page) {
                            $data .=  "<a class='pagination-buttons'><div class='pg-in active'> " . $i . "</div></a>";
                        } else {
                            $data .=  "<a class='pagination-buttons' href=?page=" . $i . "><div class='pg-in'> " . $i . "</div></a>";
                        }
                    }
                }
                $data .=  "</section>";
            }
        }
        return $data;
    }
}