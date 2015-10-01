<?php
    class PaginationLib
    {
        public function numOfPages($totalRows, $rowPerPage)
        {
            return floor(($totalRows - 1) / $rowPerPage) + 1;
        }

        public function pagination($totalRows, $rowPerPage, $currentPage, $showRows, $url, $tag = "span")
        {
            $numPages = $this->numOfPages($totalRows, $rowPerPage);

            $result = "";
            $showed = true;
            for ($page = 1; $page <= $numPages; $page++)
            {
                if ($page == $currentPage)
                {
                    $result .= "&nbsp;<$tag class=\"current\">$page</$tag>";
                    $showed = true;
                }
                elseif ($page == 1) {
                    $result .= "&nbsp;<$tag><a href=\"$url/1\">1</a></$tag>";
                    $showed = true;
                }
                elseif ($page == $numPages) {
                    $result .= "&nbsp;<$tag><a href=\"$url/$page\">$numPages</a></$tag>";
                    $showed = true;
                }
                elseif ($page >= ($currentPage - $showRows / 2) && $page <= ($currentPage + $showRows / 2) )
                {
                    $result .= "&nbsp;<$tag><a href=\"$url/$page\">$page</a></$tag>";
                    $showed = true;
                }
                else {
                    if ($showed == true)
                        $result .= "<li class=\"separator\">...</li>";
                    $showed = false;
                }
            }

            return $result;
        }
    }