<?php
if (!route(1)) {
    $templateDir = "blog";
    $blogs = getRows("blogs");
    $title = "Blog";
} elseif (route(1) && preg_replace('/[^a-zA-Z]/', '', route(1))) {
    $templateDir = "blogpost";
    $blogGet = route(1);
    $blog = getRow("blogs", "blog_get", $blogGet);
    $blogcontent = $blog['content'];
    $blogtitle = $blog['title'];
    $blogimage = $blog['image_file'];
   $getblog = $blog['blog_get'];
}
?>