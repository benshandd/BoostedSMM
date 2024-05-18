<?php

  if( !route(2) ):
    $route[2]   = "themes";
  endif;

  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;

  $menuList = ["Themes"=>"themes","Pages"=>"pages","Meta (SEO) Settings" =>"meta","Blogs" =>"blog", "Menu"=>"menu","Languages" =>"language"] ;
  if( !array_search(route(2),$menuList) ):
    header("Location:".site_url("admin/appearance"));
        elseif( route(2) == "files" ):
         
if( $_POST ):

$insert = $conn->prepare("INSERT INTO files SET link=:link ");
            $insert = $insert->execute(array("link"=>"logo_newname" ));


         foreach ($_POST as $key => $value) {
            $$key = $value;
          }
 if ( $_FILES["logo"] && ( $_FILES["logo"]["type"] == "image/jpeg" || $_FILES["logo"]["type"] == "image/jpg" || $_FILES["logo"]["type"] == "image/png" || $_FILES["logo"]["type"] == "image/gif"  ) ):
            $logo_name      = $_FILES["logo"]["name"];
            $uzanti         = substr($logo_name,-4,4);
            $logo_newname   = "public/images/".md5(rand(10,999)).".png";
            $upload_logo    = move_uploaded_file($_FILES["logo"]["tmp_name"],$logo_newname);

$insert = $conn->prepare("INSERT INTO files SET link=:link ");
            $insert = $insert->execute(array("link"=>"logo_newname" ));


header("Location:".site_url("admin/appearance/blog"));
                  

endif;
endif;
   
  elseif( route(2) == "pages" ):
    $access = $admin["access"]["pages"];
      if( $access ):
        if( route(3) == "edit" ):
          if( $_POST ):
            $id = route(4);
            foreach ($_POST as $key => $value) {
              $$key = $value;
            }
              if( $content == "<br>" ): $content = ""; endif;
            if( !countRow(["table"=>"pages","where"=>["page_get"=>$id]]) ):
              $error    = 1;
              $icon     = "error";
              $errorText= "Lütfen geçerli ödeme methodu seçin";
            else:
              $update = $conn->prepare("UPDATE pages SET last_modified=:last_modified,  page_content=:content, seo_title=:title, seo_keywords=:keywords, seo_description=:description WHERE page_get=:id ");
              $update->execute(array("id"=>$id,"content"=>$content, "title"=>$seo_title,"description"=>$seo_description,"keywords"=>$seo_keywords,"last_modified"=>date('Y-m-d h:i:s')  ));
                if( $update ):
                  $success    = 1;
                  $successText= "Success";
                else:
                  $error    = 1;
                  $errorText= "Failed";
                endif;
            endif;
          endif;
          $page = $conn->prepare("SELECT * FROM pages WHERE page_get=:get ");
          $page->execute(array("get"=>route(4)));
          $page = $page->fetch(PDO::FETCH_ASSOC); if( !$page ): header("Location:".site_url("admin/appearance/pages")); endif;
elseif( route(3) == "type" ):
          $id     = $_GET["id"];
          $type   = $_GET["type"]; if( $type == "off" ): $type = 2; elseif( $type == "on" ): $type = 1; endif;
          $update = $conn->prepare("UPDATE pages SET page_status=:type WHERE page_id=:id ");
          $update->execute(array("id"=>$id,"type"=>$type));
            if( $update ):
              echo "1";
            else:
              echo "0";
            endif;
elseif( route(3) == "create" ):
                  if( $_POST ):
            $id = route(4);
            foreach ($_POST as $key => $value) {
              $$key = $value;
            }
$code = $pageget;
if (countRow(["table" => "pages", "where" => ["page_get" => $pageget ]])):
        
    else:
                $html = "";
                file_put_contents('app/controller/'.$code.'.php', $html);
                
$insert = $conn->prepare("INSERT INTO pages SET last_modified=:last_modified,   page_content=:content, seo_title=:title, seo_keywords=:keywords, seo_description=:description, page_get=:get , page_name=:name");
            $insert = $insert->execute(array("content"=>$content, "title"=>$seo_title,"description"=>$seo_description,"keywords"=>$seo_keywords,"get"=>$pageget,"name"=>$name 
 ,"last_modified"=>"0000-00-00 00:00:00" ));


$themes = $conn->prepare("SELECT * FROM themes ");
          $themes->execute(array());
          $themes = $themes->fetchAll(PDO::FETCH_ASSOC);
foreach( $themes as $theme ):

$fn       = "app/views/".$theme["theme_dirname"]."/$pageget.twig";
              $codeType = "twig";
              $dir      = "HTML";
            $text = $_POST["code"];
            $text = str_replace("&lt;","<",$text);
            $text = str_replace("&gt;",">",$text);
            $text = str_replace("&quot;",'"',$text);
            $updated_file   = fopen($fn,"w");
            fwrite($updated_file, $text);
            fclose($updated_file);
$text = $theme["newpage"];
file_put_contents($fn, $text );
endforeach;
if( $insert):
                  $success    = 1;
                  $successText= "Success";
header("Location:".site_url("admin/appearance/pages"));
                else:
                  $error    = 1;
                  $errorText= "Failed";
               



endif; 
           endif; 
           

endif; 
           
          
        elseif( !route(3) ):
          $pageList = $conn->prepare("SELECT * FROM pages ");
          $pageList->execute(array());
          $pageList = $pageList->fetchAll(PDO::FETCH_ASSOC);
        else:
          header("Location:".site_url("admin/appearance/pages"));
        endif;
      endif;
    if( route(5) ): header("Location:".site_url("admin/appearance/pages")); endif;
  elseif( route(2) == "menu" ):
$menus = $conn->prepare("SELECT * FROM menus ORDER BY menu_line ");
          $menus->execute(array());
          $menus = $menus->fetchAll(PDO::FETCH_ASSOC);
     if( route(3) == "add_internal" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          if( empty($name) ):
            $error    = 1;
            $errorText= "Name cannot be empty";
            $icon     = "error";
          elseif( empty($slug) ):
            $error    = 1;
            $errorText= "Slug Cannot be empty";
            $icon     = "error";
          
          else:
$active = preg_replace("(/)", "", $slug);
$row = $conn->query("SELECT * FROM menus ORDER BY menu_line DESC LIMIT 1 ")->fetch(PDO::FETCH_ASSOC);
            $conn->beginTransaction();
if($slug == "/neworder") :
            $insert = $conn->prepare("INSERT INTO menus SET name=:name, active=:active,  slug=:url, menu_line=:line, visible=:visible, icon=:icon ");
            $insert = $insert->execute(array("name"=>$name,"active"=>"neworder","url"=>"/","visible"=>"Internal","icon"=>$icon,"line"=>($row["menu_line"]+1)));
elseif($slug == "/login") :
            $insert = $conn->prepare("INSERT INTO menus SET name=:name, active=:active,  slug=:url, menu_line=:line, visible=:visible, icon=:icon ");
            $insert = $insert->execute(array("name"=>$name,"active"=>"login","url"=>"/","visible"=>"External","icon"=>$icon,"line"=>($row["menu_line"]+1))); 
else:
$insert = $conn->prepare("INSERT INTO menus SET name=:name, active=:active,  slug=:url, menu_line=:line, visible=:visible, icon=:icon ");
            $insert = $insert->execute(array("name"=>$name,"active"=>$active,"url"=>$slug,"visible"=>$visible,"icon"=>$icon,"line"=>($row["menu_line"]+1)));
endif;
            if( $insert ):
              $conn->commit();
              $referrer = site_url("admin/appearance/menu");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
elseif( route(3) == "edit_menu" && $_POST  ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $id = route(4);
          if( empty($name) ):
            $error    = 1;
            $errorText= "Name cannot be empty";
            $icon     = "error";
          elseif( empty($slug) ):
            $error    = 1;
            $errorText= "Slug Cannot be empty";
            $icon     = "error";
          else:
            $conn->beginTransaction();
            $update = $conn->prepare("UPDATE menus SET name=:name, icon=:icon, slug=:slug WHERE id=:id ");
            $update = $update->execute(array("name"=>$name,"icon"=>$icon,"slug"=>$slug,"id"=>$id));
            if( $update ):
              $conn->commit();
              $referrer = site_url("admin/appearance/menu");
              $error    = 1;
              $errorText= "Success";
              $icon     = "success";
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Failed";
              $icon     = "error";
            endif;
          endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);
          exit();
endif;


  
  elseif( route(2) == "language" ):
    $access = $admin["access"]["language"];
      if( $access ):
        $languageList = $conn->prepare("SELECT * FROM languages");
        $languageList->execute(array());
        $languageList = $languageList->fetchAll(PDO::FETCH_ASSOC);
        if( route(3) && route(3) != "new" && !countRow(["table"=>"languages","where"=>["language_code"=>route(3)]]) ):
          header("Location:".site_url("admin/appearance/language"));
        elseif( route(3) == "new" ):
          include 'app/language/default.php';
        else:
          $language = $conn->prepare("SELECT * FROM languages WHERE language_code=:code");
          $language->execute(array("code"=>route(3)));
          $language = $language->fetch(PDO::FETCH_ASSOC);
          include 'app/language/'.route(3).'.php';
        endif;
        if( $_POST && route(3) != "new" && countRow(["table"=>"languages","where"=>["language_code"=>route(3)]]) ):
          $html = '<?php '.PHP_EOL.PHP_EOL;
          $html.= '$languageArray= [';
          foreach ($_POST["Language"] as $key => $value):
            $html .= ' "'.$key.'" => "'.$value.'", '.PHP_EOL;
          endforeach;
          $html .=  '];';
          file_put_contents('app/language/'.route(3).'.php', $html);
          header("Location:".site_url("admin/appearance/language/".route(3)));
        elseif( route(3) == "new" && $_POST ):
          $name = $_POST["language"];
          $code = $_POST["languagecode"];
          if( countRow(["table"=>"languages","where"=>["language_code"=>$code]]) ):
            $error      = 1;
            $errorText  = "Bu dil kodu zaten kullanılıyor.";
          else:
            $insert = $conn->prepare("INSERT INTO languages SET language_name=:name, language_code=:code ");
            $insert->execute(array("name"=>$name,"code"=>$code ));
              if( $insert ):
                $html = '<?php '.PHP_EOL.PHP_EOL;
                $html.= '$languageArray= [';
                foreach ($_POST["Language"] as $key => $value):
                  $html .= ' "'.$key.'" => "'.$value.'", '.PHP_EOL;
                endforeach;
                $html .=  '];';
                file_put_contents('app/language/'.$code.'.php', $html);
                header("Location:".site_url("admin/appearance/language/"));
              endif;
          endif;
        elseif( $_GET["lang-default"] && $_GET["lang-id"] ):
          $update = $conn->prepare("UPDATE languages SET default_language=:default");
          $update->execute(array("default"=>0));
          $update = $conn->prepare("UPDATE languages SET default_language=:default WHERE language_code=:code ");
          $update->execute(array("code"=>$_GET["lang-id"],"default"=>1));
          header("Location:".site_url("admin/appearance/language"));
        elseif( $_GET["lang-type"] && $_GET["lang-id"] ):
          if( countRow(["table"=>"languages","where"=>["language_type"=>"2"]]) > 1 && $_GET["lang-type"] == 1 ):
            $update = $conn->prepare("UPDATE languages SET language_type=:type WHERE language_code=:code ");
            $update->execute(array("code"=>$_GET["lang-id"],"type"=>$_GET["lang-type"]));
          elseif( $_GET["lang-type"] == 2 ):
            $update = $conn->prepare("UPDATE languages SET language_type=:type WHERE language_code=:code ");
            $update->execute(array("code"=>$_GET["lang-id"],"type"=>$_GET["lang-type"]));
          endif;
          header("Location:".site_url("admin/appearance/language"));
        endif;
      endif;
  elseif( route(2) == "themes" ):
    $access = $admin["access"]["themes"];
      if( $access ): 
$theme = $conn->prepare("SELECT * FROM themes WHERE id=:id");
          $theme->execute(array("id"=>route(4)));
          $theme = $theme->fetch(PDO::FETCH_ASSOC);
        if( route(3) == "active" && countRow(["table"=>"themes","where"=>["theme_dirname"=>$theme["theme_dirname"]]]) ):
          $update = $conn->prepare("UPDATE settings SET site_theme=:theme WHERE id=:id ");
          $update->execute(array("id"=>1,"theme"=>$theme["theme_dirname"] ));
          header("Location:".site_url("admin/appearance/themes"));
        elseif( route(3) && countRow(["table"=>"themes","where"=>["id"=>route(3)]]) ):
          $lyt   =  $_GET["file"];
          $theme = $conn->prepare("SELECT * FROM themes WHERE id=:id");
          $theme->execute(array("id"=>route(3)));
          $theme = $theme->fetch(PDO::FETCH_ASSOC);
            if( substr($lyt, -3) == "css"  ){
              $fn       = "public/".$theme["theme_dirname"]."/".$lyt;
              $codeType = "css";
              $dir      = "CSS";
            }elseif( substr($lyt, -2) == "js"  ){
              $fn       = "public/".$theme["theme_dirname"]."/".$lyt;
              $codeType = "js";
              $dir      = "JS";
            }else{
              $fn       = "app/views/".$theme["theme_dirname"]."/".$lyt;
              $codeType = "twig";
              $dir      = "HTML";
            }
          if( $_POST ):
            $text = $_POST["code"];
            $text = str_replace("&lt;","<",$text);
            $text = str_replace("&gt;",">",$text);
            $text = str_replace("&quot;",'"',$text);
            $updated_file   = fopen($fn,"w");
            fwrite($updated_file, $text);
            fclose($updated_file);
$update = $conn->prepare("UPDATE themes SET last_modified=:theme WHERE id=:id ");
          $update->execute(array("id"=>route(3),"theme"=>date('Y-m-d h:i:s') ));

            header("Location:".site_url("admin/appearance/themes/".$theme["id"]."?file=".$lyt));
          endif;
        elseif( route(3) && !countRow(["table"=>"themes","where"=>["id"=>route(3)]]) ):
          header("Location:".site_url("admin/appearance/themes"));
        else:
          $themes = $conn->prepare("SELECT * FROM themes");
          $themes->execute(array());
          $themes = $themes->fetchAll(PDO::FETCH_ASSOC);
        if( $_POST ):
         foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          
            $update = $conn->prepare("UPDATE settings SET 
			
			site_theme_alt=:site_theme_alt
			 WHERE id=:id ");
            $update->execute(array(
                "id" => 1,
                "site_theme_alt" => $site_theme_alt ));

                $referrer = site_url("admin/appearance/themes");
                $icon = "success";
                $error = 1;
                $errorText = "Success";
                
                header("Location:".site_url("admin/appearance/themes"));
                echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer,"time"=>1]);

              if( $update ):
                header("Location:" . site_url("admin/appearance/themes"));
                    $_SESSION["client"]["data"]["success"] = 1;
                    $_SESSION["client"]["data"]["successText"] = "Successful";
              else:
                $errorText  = "Failed";
                $error      = 1;
				
             endif;  
endif;   
endif;  
        
        
      endif;  
    elseif( route(2) == "meta" ):
          
    $access = $admin["access"]["meta"];
    
      if( $access ):
         
        if( $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          $conn->beginTransaction();
          $update = $conn->prepare("UPDATE settings SET site_seo=:seo,
			site_title=:title,
			
			site_keywords=:keys,
			site_description=:desc WHERE id=:id ");
          $update = $update->execute(array("id"=>1,"seo" => $seo,
                "title" => $title,
                "keys" => $keywords,
                "desc" => $description,  ));
          if( $update ):
            $conn->commit();
            header("Location:".site_url("admin/appearance/meta"));
            $_SESSION["client"]["data"]["success"]    = 1;
            $_SESSION["client"]["data"]["successText"]= "Success";
          else:
            $conn->rollBack();
            $error    = 1;
            $errorText= "Failed";
          endif;
        endif;
      endif;

    if( route(3) ): header("Location:".site_url("admin/appearance/alert")); endif;
      

  elseif( route(2) == "blog" ):
$id = route(4);
$bloge = $conn->prepare("SELECT * FROM blogs WHERE id=:id ");
          $bloge->execute(array("id"=> $id));
          $bloge = $bloge->fetch(PDO::FETCH_ASSOC); 

$blogs = $conn->prepare("SELECT * FROM blogs ");
          $blogs->execute(array());
          $blogs = $blogs->fetchAll(PDO::FETCH_ASSOC);

if( route(3) == "new" && $_POST ):
          foreach ($_POST as $key => $value) {
            $$key = $value;
          }
          
            $conn->beginTransaction();
            $insert = $conn->prepare("INSERT INTO blogs SET title=:title , status=:status , content=:content , image_file=:link, published_at=:published_at , blog_get=:get ");
            $insert = $insert->execute(array("title"=>$title,"status"=>$status,"get"=>$blogurl,"content"=>$content,"link"=>$url,"published_at"=>date('Y-m-d h:i:s') ));
            if( $insert ):
              $conn->commit();
            header("Location:".site_url("admin/appearance/blog"));
            $_SESSION["client"]["data"]["success"]    = 1;
            $_SESSION["client"]["data"]["successText"]= "Success";
          else:
            $conn->rollBack();
$_SESSION["client"]["data"]["error"]    = 1;
            $_SESSION["client"]["data"]["errorText"]= "Failed ";
            endif;

elseif( route(3) == "edit" ):
          if( $_POST ):
            $id = route(4);
            foreach ($_POST as $key => $value) {
              $$key = $value;
            }
              if( $content == "<br>" ): $content = ""; endif;

              $update = $conn->prepare("UPDATE blogs SET title=:title , blog_get=:get , status=:status  , updated_at=:at , image_file=:link , content=:content WHERE id=:id ");
              $update->execute(array("id"=>$id,"title"=>$title,"link"=>$url,"get"=>$blogurl,"status"=>$status, "at"=>date('Y-m-d h:i:s'), "content"=>$content ));

                if( $update ):
header("Location:".site_url("admin/appearance/blog"));
                  $success    = 1;
                  $successText= "Success";
                else:
                  $error    = 1;
                  $errorText= "Failed";
                endif;
   
      
endif;
   
      
endif;
   
      
  
                              


  
endif;
  require admin_view('appearance');
