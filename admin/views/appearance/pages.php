<?php if(! route(3) ): ?>
<div class="col-md-8">
            <a class="btn btn-default m-b" href="/admin/appearance/pages/create">Add page</a>            <table class="table">
               

   <table class="table report-table" style="border:1px solid #ddd">
      <thead>
         <tr>
            <th>Page Name</th>
<th>Visibility</th>
<th>Last Modified</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($pageList as $page): ?>
         <tr>
            <td> <?php echo $page["page_name"]; ?> </td>
            
               <td>
                        <input type="checkbox" class="tiny-toggle" data-tt-palette="blue" data-url="<?=site_url("admin/appearance/pages/type")?>" data-id="<?php echo $page["page_id"]; ?>" <?php if( $page["page_status"]==1 ): echo "checked"; endif; ?>> </td>


<?php if( $page["last_modified"]== "0000-00-00 00:00:00"): ?>
<td> Never</td>
<?php else: ?>
<td> <?php echo $page["last_modified"]; ?> </td>

<?php endif; ?>

             <td >     <a href="<?php echo site_url('admin/appearance/pages/edit/'.$page["page_get"]) ?>" class="btn btn-default btn-xs">
                  Edit
                  </a>
               
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
<?php elseif( route(3) == "edit" ): ?>
<div class="col-md-8">
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/appearance/pages/edit/'.route(4)) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label class="control-label">Page Name</label>
               <input type="text" class="form-control" readonly value="<?=$page["page_name"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Page Content</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" placeholder=""><?php echo $page["page_content"]; ?></textarea>
            </div>

<hr>
    <div class="appearance-seo__block">
        <div class="appearance-seo__block-title">    Search engine listing preview     </div>
        <a class="other_services" href="#collapse-languages-seo" role="button" data-toggle="collapse">   <span>
  Edit page SEO </span>
    </a>        <div class="seo-preview">
            <div class="seo-preview__title edit-seo__title"></div>

            <div class="seo-preview__title edit-seo__title"><?=$page["seo_title"];?></div>
    <div class="seo-preview__url"><?=site_url("")?><span class="edit-seo__url"><?=$page["page_get"];?></span>
 <div class="seo-preview__description edit-seo__meta"><?=$page["seo_description"];?></div>
        
</div>
            <div class="seo-preview__description edit-seo__meta"></div>
        </div>
    </div>
    <div class="collapse appearance-seo__block-collapse" id="collapse-languages-seo">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_title">Page title</label>            <input type="text" id="editpageform-seo_title" class="form-control" name="seo_title" value="<?=$page["seo_title"];?>">        </div>

            <div class="form-group">
            <label class="control-label" for="editpageform-seo_keywords">Meta-Keywords</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_keywords" rows="5"><?=$page["seo_keywords"];?></textarea>        </div>
    <div class="form-group">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_description">Meta-description</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_description" rows="5"><?=$page["seo_description"];?></textarea>        </div>
    </div>
</div>                                                                
                       

            <hr>
            <button type="submit" class="btn btn-primary">Update Settings</button>
         </form>
      </div>
   </div>
</div>


<?php elseif( route(3) == "create" ): ?>
<div class="col-md-8">
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/appearance/pages/create') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label class="control-label">Page Name</label>
               <input type="text" class="form-control"  name="name"  value="">
            </div>
            <div class="form-group">
               <label class="control-label">Page Content</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" placeholder=""></textarea>
            </div>
<div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="pageget" value="">                   </div>
                    </div>

<hr>
    <div class="appearance-seo__block">
        <div class="appearance-seo__block-title">    Search engine listing preview     </div>
        <a class="other_services" href="#collapse-languages-seo" role="button" data-toggle="collapse">   <span>
  Edit page SEO </span>
    </a>        <div class="seo-preview">
            <div class="seo-preview__title edit-seo__title"></div>

            <div class="seo-preview__title edit-seo__title"><?=$page["seo_title"];?></div>
    <div class="seo-preview__url"><?=site_url("")?><span class="edit-seo__url"><?=$page["page_get"];?></span>
 <div class="seo-preview__description edit-seo__meta"><?=$page["seo_description"];?></div>
        
</div>
            <div class="seo-preview__description edit-seo__meta"></div>
        </div>
    </div>
    <div class="collapse appearance-seo__block-collapse" id="collapse-languages-seo">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_title">Page title</label>            <input type="text" id="editpageform-seo_title" class="form-control" name="seo_title" value="">        </div>

            <div class="form-group">
            <label class="control-label" for="editpageform-seo_keywords">Meta-Keywords</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_keywords" rows="5"></textarea>        </div>
    <div class="form-group">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_description">Meta-description</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_description" rows="5"></textarea>                </div>
    </div>
</div>                                                                
                       

            <hr>
            <button type="submit" class="btn btn-primary">Update Settings</button>
         </form>
      </div>
   </div>
</div>

<?php endif; ?>
