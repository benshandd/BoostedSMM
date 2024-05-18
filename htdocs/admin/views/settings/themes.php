<?php if( !route(3) ): ?>
<div class="col-md-8">
   <table class="table report-table" style="border:1px solid #ddd">
      <thead>
         <tr>
            <th>Theme Name</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($themes as $theme): ?>

    <div class="col-md-8">
            <div class="settings-themes settings-themes__appearance">
                <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="settings-themes__card">
                                                                    <div class="settings-themes__card-preview" style="background-image: url(https://cdn.mypanel.link/m44795/a1n6fm9nc5ny7z0z.png)">
                                                                                                    </div>
                                <div class="appearance-themes__footer">
                                    <div class="appearance-themes__footer-desc">
                                        <div class="footer-desc__title">Simplify</div>
                                        <div class="footer-desc__modified">
                                                                                            Last&nbsp;modified 2021-08-27                                                                                    </div>
                                    </div>
                                                                            <div class="appearance-themes__footer-link">
                                            <a class="btn btn-default" href="/admin/appearance/theme-activate" data-method="POST" data-params='{"id":"21"}'>Activate</a>                                        </div>
                                                                    </div>
                            </div>
                        </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="settings-themes__card">
                                                                    <div class="settings-themes__card-preview" style="background-image: url(/img/themes/editor_2.png)">
                                                                                                            <span class="badge">Active</span>

                                        
                                        <div class="settings-themes__card--activate">
                                            <a href="/admin/editor" class="btn btn-primary">
                                                <span class="fas fa-magic"></span>
                                                Open editor                                            </a>
                                        </div>
                                                                    </div>
                                <div class="appearance-themes__footer">
                                    <div class="appearance-themes__footer-desc">
                                        <div class="footer-desc__title">Engaging</div>
                                        <div class="footer-desc__modified">
                                                                                            Last&nbsp;modified 2021-08-30                                                                                    </div>
                                    </div>
                                                                    </div>
                            </div>
                        </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="settings-themes__card">
                                                                    <div class="settings-themes__card-preview" style="background-image: url(https://cdn.mypanel.link/m44795/5t92aawb02co9xek.png)">
                                                                                                    </div>
                                <div class="appearance-themes__footer">
                                    <div class="appearance-themes__footer-desc">
                                        <div class="footer-desc__title">Eternity</div>
                                        <div class="footer-desc__modified">
                                                                                            Last&nbsp;modified 2021-08-27                                                                                    </div>
                                    </div>
                                                                            <div class="appearance-themes__footer-link">
                                            <a class="btn btn-default" href="/admin/appearance/theme-activate" data-method="POST" data-params='{"id":"23"}'>Activate</a>                                        </div>
                                                                    </div>
                            </div>
                        </div>
                                    </div>
            </div>
        </div>
    </div>
</div>


         <tr>



            <td> <?php echo $theme["theme_name"]; if( $settings["site_theme"] == $theme["theme_dirname"] ): echo ' <span class="badge">Active</span>'; endif; ?></td>
            <td class="text-right col-md-1">
              <div class="dropdown pull-right">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <?php if( $settings["site_theme"] != $theme["theme_dirname"] ): ?>
                    <li>
                      <a href="<?php echo site_url('admin/settings/themes/active/'.$theme["theme_dirname"]) ?>">
                        Activate
                      </a>
                    </li>
                  <?php endif; ?>
                  <li>
                    <a href="<?php echo site_url('admin/settings/themes/'.$theme["theme_dirname"]) ?>">
                    Edit
                    </a>
                  </li>
                </ul>
              </div>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
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
                    "HTML"=>["header.twig","footer.twig","account.twig","addfunds.twig","api.twig","child-panels.twig",
                    "login.twig","neworder.twig","open_ticket.twig","orders.twig","signup.twig",
                    "services.twig","tickets.twig","dripfeeds.twig","subscriptions.twig",
                    "resetpassword.twig",
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
                      <li '. $active .'><a href="'.site_url('admin/settings/themes/'.$theme["theme_dirname"]).'?file='.$layout.'">'.$layout.'</a></li>';
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
           

                <form action="<?php echo site_url("admin/settings/themes/".$theme["theme_dirname"]."?file=".$lyt) ?>" method="post" class="twig-editor__form">
                  <textarea id="code" name="code" class="codemirror-textarea"><?=$text;?></textarea>
                  <div class="edit-theme-body-buttons text-right">
                      <a href="<?php echo ("https://cdn.panelingo.com/app/views/".$theme["theme_dirname"]."/$lyt") ?>" class="btn btn-link" >Download Zero</a>
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