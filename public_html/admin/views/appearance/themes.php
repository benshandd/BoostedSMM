<?php if( !route(3) ): ?>

        

         <?php foreach($themes as $theme): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
<div class="settings-themes__card settings-themes__card-active">
                                <div class="settings-themes__card-preview" style="background-image: url()">

   
<?php  if( $settings["site_theme"] == $theme["theme_dirname"] ):  ?>
<span class="badge">Active</span>
<?php endif; ?><?php  if( $settings["site_theme"] != $theme["theme_dirname"] ):  ?>
                                                                            <div class="settings-themes__card--activate">
                                            <a class="btn btn-primary" href="<?php echo site_url('admin/appearance/themes/active/'.$theme["id"]) ?>">Activate</a>                                        </div><?php endif; ?>
                                                                                                        </div>
                                <div class="settings-themes__card-title">
                                    <?php echo $theme["theme_name"]; ?>                                                              <a href="<?php echo site_url('admin/appearance/themes/'.$theme["id"]) ?>" class="btn btn-default btn-xs pull-right">
                                        Edit code                                    </a>
                                </div>
                            </div>
                        </div>
                                            
                                            



         <?php endforeach; ?>


      </tbody>
   </table>
</div>
<br>
 
<div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-body">
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
          <label class="control-label">Theme Colour</label>
        
          <select class="form-control" name="site_theme_alt">
           	<option value="<?=$settings["site_theme_alt"]?>" selected>Active Theme-colour : <?=$settings["site_theme_alt"]?></option>	<option value="Red" >Red</option>
<option value="Blue" >Blue</option>
                     <option value="Lime" >Lime</option>
																		<option value="Grapes" >Grapes</option>
																		<option value="Dark" >Dark</option>
																		<option value="Cyan" >Cyan</option>
																		<option value="Coral" >Coral</option>
																		<option value="Green" >Green</option>
																		<option value="Grey" >Grey</option>
																		<option value="Lilac" >Lilac</option>
																		<option value="Orange">Orange</option>										
          </select>
        </div> 
     <center>  
        <button type="submit" class="btn btn-primary">Update Settings</button></center>
      </form>
    </div>
  </div>
</div>
 
<?php elseif( route(3) ): ?>
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-heading edit-theme-title"><strong><?php echo $theme["theme_name"] ?></strong> edit the theme named</div>

        <div class="row">
          <div class="col-md-3 padding-md-right-null">

            <div class="panel-body edit-theme-body">
              <div class="twig-editor-block">
                <?php





                  $layouts  = [
                    "HTML"=>[
"header.twig","footer.twig","account.twig","addfunds.twig","api.twig","child-panels.twig",
                    "login.twig","neworder.twig","open_ticket.twig","orders.twig","refill.twig","signup.twig",
                    "services.twig","tickets.twig","refer.twig","dripfeeds.twig","subscriptions.twig",
                    "resetpassword.twig","setnewpassword.twig","updates.twig","blog.twig","blogpost.twig",
                    "terms.twig","faq.twig"],
                    "CSS"=>["bootstrap.css","style.css"],
                    "JS"=>["bootstrap.js","script.js"]
                  ];
                foreach ($layouts as $style => $layout):
                  echo '<div class="twig-editor-list-title" data-toggle="collapse" href="#folder_'.$style.'"><span class="fa fa-folder-open"></span>'.$style.'</div><ul class="twig-editor-list collapse in" id="folder_'.$style.'">';
                  foreach ($layouts[$style] as $layout) :
                    if( $lyt == $layout ):
                      $active = ' class="active file-modified" ';
                    else:
                      $active = '';
                    endif;
                    echo '
                      <li '. $active .'><a href="'.site_url('admin/appearance/themes/'.$theme["id"]).'?file='.$layout.'">'.$layout.'</a></li>';
                  endforeach;
                  echo '</ul>';
                endforeach;
              ?>
              </div>

            </div>
          </div>
          <div class="col-md-9 padding-md-left-null edit-theme__block-editor">
            <?php if( !$lyt ): ?>
              <div class="panel-body">
                <div class="row">
                   <div class="col-md-12">
                    <div class="theme-edit-block">
                      <div class="alert alert-info" role="alert">
                       Select a file from the left sidebar to start editing.
                      </div>
                    </div>
                  </div>
                  </div>
              </div>
            <?php else: ?>
                  
                  <div id="fullscreen">

               <div class="panel-body">

                <?php
                $file = fopen($fn, "r");
                $size = filesize($fn);
                $text = fread($file, $size); // -> Kodu okur
                $text = str_replace("<","&lt;",$text);
                $text = str_replace(">","&gt;",$text);
                $text = str_replace('"',"&quot;",$text);
                fclose($file); // -> Kapatır
                ?>

                <div class="row">
                    <div class="col-md-8">
                      <strong class="edit-theme-filename"><?=$dir."/".$lyt?></strong>
                        </div>
                        <div class="col-md-4 text-right">
                                    <a class="btn btn-xs btn-default fullScreenButton">
                                        <span class="glyphicon glyphicon-fullscreen"></span>
                                        Edit Full Screen </a>
                                </div>
                  </div>
           

                <form action="<?php echo site_url("admin/appearance/themes/".$theme["id"]."?file=".$lyt) ?>" method="post" class="twig-editor__form">
                  <textarea id="code" name="code" class="codemirror-textarea"><?=$text;?></textarea>
                  <div class="edit-theme-body-buttons text-right">
                      
                    <button class="btn btn-primary click">Save</button>
                  </div>
                </form>

              </div>
            <?php endif; ?>
          </div>
        </div>

    </div>
  </div>


<?php endif; ?>









    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
      <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>