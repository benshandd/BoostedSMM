<?php if( !route(3) ): ?>

            
<div class="settings-header__table">

            <div class="col-md-8">
	<div class="settings-header__table">
	<a href="admin/appearance/blog/new" >	<button type="button" class="btn btn-default m-b">Create Blog</button></a>
	</div>
	<hr>

   <table class="table report-table" style="border:1px solid #ddd">
      <thead>
         <tr>
            <th>Blog Title</th>
<th>Created</th>
<th>Visibility</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($blogs as $blog): ?>
         <tr>
<td> <?php echo $blog["title"]; ?> </td>
            <td> <?php echo $blog["published_at"]; ?> </td>
<td><?php if($blog["status"]==1){ echo 'Published';}else{ echo 'Not Published';}   ?></td>

            <td class="text-right col-md-1">
               <div class="dropdown">
                  <a href="<?php echo site_url('admin/appearance/blog/edit/'.$blog["id"]) ?>" class="btn btn-default btn-xs">
                  Edit
                  </a>
               </div>
            </td>
         </tr>
         <?php endforeach; ?>



      </tbody>
   </table>
</div>
</div>



<?php elseif( route(3) == "new" ): ?>
<div class="col-md-8">
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/appearance/blog/new') ?>" method="post" enctype="multipart/form-data">
<div class="form-group">
               <label class="control-label">Blog Image</label>
               <input type="text" class="form-control" name="url" value="">
            </div>
            <div class="form-group">
               <label class="control-label">Blog Title</label>
               <input type="text" class="form-control" name="title" value="">
            </div>
            <div class="form-group">
               <label class="control-label">Page Content</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" placeholder=""></textarea>
            </div>
<hr>
                    <div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("blog/")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="blogurl" value="">                   </div>
                    </div>
<div class="form-group">
          <label class="control-label">Visibility
            </label>
          <select class="form-control" name="status">
            <option value="2">Not Published</option>
            <option value="1">Published</option>
          </select>
</div> 
            <hr>
            <button type="submit" class="btn btn-primary">Update Settings</button>
         </form>
      </div>
   </div>
</div>

<?php elseif( route(3) == "edit" ): ?>
         
<div class="col-md-8">
   <div class="panel panel-default">
      <div class="panel-body">
<form action="<?php echo site_url('admin/appearance/blog/edit/'.route(4)) ?>" method="post" enctype="multipart/form-data">

         <div class="form-group">
               <label class="control-label">Blog Image</label>
               <input type="text" class="form-control" name="url" value="<?=$bloge["image_file"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Blog Title</label>
               <input type="text" class="form-control" name="title" value="<?=$bloge["title"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Blog Content</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" ><?=$bloge["content"];?></textarea>
            </div>
                          
                    <hr>
                    <div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("blog/")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="blogurl" value="<?=$bloge["blog_get"];?>">                   </div>
                    </div>
                    
                    

        <div class="form-group">
          <label class="control-label">Visibility
            </label>
          <select class="form-control" name="status">
            <option value="2" <?= $bloge["status"] == 2 ? "selected" : null; ?> >Not Published</option>
            <option value="1" <?= $bloge["status"] == 1 ? "selected" : null; ?>>Published</option>
          </select>
</div>
            <hr>
<button type="submit" class="btn btn-primary">Update Settings</button>
                                            <a class="btn btn-link pull-right delete-btn" href="/admin/appearance/delete-blog/<?= $bloge["id"]; ?>"data-title="Delete this post?">Delete</a>
         </form>
      </div>
   </div>
</div>
         
<?php endif; ?>


          
        
               